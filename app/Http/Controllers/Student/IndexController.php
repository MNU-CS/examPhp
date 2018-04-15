<?php

namespace App\Http\Controllers\Student;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class IndexController extends Controller
{

    /**
     * @param Request $request 判断请求类型
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function register(Request $request)
    {
        if($request->isMethod('post')){
            $input = Request::all();
            var_dump($input);
        }else{
            return view('Student.register');
        }
    }


    /**
     * 登录验证
     * @param Request $request
     * @return string
     */
    public function login(Request $request)
    {
        if (session('student') != null){
            return redirect('content');
        }
        if ($request->isMethod('post')){
            $username = Input::get('username');
            $passwd = Input::get('passwd');
            if($username == '' || $passwd == ''){
                return '用户名或密码不能为空';
            }
            $res = DB::select('select * from student where num = ?',[$username]);
            if(empty($res)){
                return '用户名不存在';
            }else{
                if ($res[0]->passwd != substr_replace(md5($passwd),'a8c1m4',5,0)){
                    return '密码错误';
                }else {
                    session(['student' => $username]);
                    session(['name' => $res[0]->name]);
                    return 1;
                }
            }
        } else {
            return view('Student.index');
        }
    }


    /**
     * 列出考试列表
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function content()
    {
        if (session('student') == null){
            return redirect('login');
        }
        $res = DB::table('content')->where('status',1)->paginate(1);
        return view('Student.content')->with('res',$res);
    }


    /**
     * 查看某个考试题目
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function online_problem()
    {
        if (session('student') == null){
            return redirect('login');
        }
        $id = Input::get('id');
        if ($id == null){
            return back();
        }
        $num = session('student');
        $bool1 = DB::table('content')->where('id',$id)->first();
        if ($bool1->open == 0){
            $bool = DB::table('group')->where('num_id',$num)->where('content_id',$id)->first();
            if ($bool == null){
                $base['message'] = '你没有该考试权限';
                $base['url'] = 'content';
                return showMessage($base);
            }
        }
        $res = DB::table('online_problem')
            ->where('content_id',$id)
            ->join('problem','online_problem.problem_id','=','problem.id')
            ->paginate(20);
        $title = DB::table('content')->where('id',$id)->first();
        $problem_finish = DB::table('submit')->where([
            ['content_id','=',$id],
            ['num_id','=',session('student')],
        ])->get();
        $finish = array();
        foreach ($problem_finish as $v){
            $finish[] = $v->problem_id;
        }
        return view('Student.online_problem')
            ->with('res',$res)
            ->with('title',$title)
            ->with('id',$id)
            ->with('finish',$finish);
    }


    /**
     * 提交和查看单个题目
     * @param Request $request
     * @return $this|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function detail_problem(Request $request)
    {
        if (session('student') == null){
            return redirect('login');
        }
        $id = session('student');
        $problem_id = Input::get('id');
        $content_id = Input::get('content_id');
        $bool1 = DB::table('content')->where('id',$content_id)->first();
        if ($bool1->open == 0){
            $bool = DB::table('group')->where('num_id',$id)->where('content_id',$id)->first();
            if ($bool == null){
                $base['message'] = '你没有该考试权限';
                $base['url'] = 'content';
                return showMessage($base);
            }
        }

        if ($problem_id == null || $content_id == null){
            return back();
        }
        if ($request->isMethod('post')){
            $bool = DB::table('submit')->where([
                ['content_id','=',$content_id],
                ['problem_id','=',$problem_id],
                ['num_id','=',$id],
            ])->first();
            if ($bool != null){
                $data['result'] = Input::get('result');
                $res = DB::table('submit')->where([
                    ['content_id','=',$content_id],
                    ['problem_id','=',$problem_id],
                    ['num_id','=',$id],
                ])->update($data);
                if ($res !== false){
                    $base['message'] = '添加成功';
                    $base['url'] = 'online_problem?id=' . $content_id;
                    return showMessage($base);
                }else{
                    $base['message'] = '添加失败';
                    $base['url'] = 'detail_problem?id=' . $problem_id . '&content_id=' . $content_id;
                    return showMessage($base);
                }
            }
            else{
                $data['result'] = Input::get('result');
                $data['num_id'] = $id;
                $data['problem_id'] = $problem_id;
                $data['content_id'] = $content_id;
                $res = DB::table('submit')->insert($data);
                if ($res !== false){
                    $base['message'] = '添加成功';
                    $base['url'] = 'online_problem?id=' . $content_id;
                    return showMessage($base);
                }else{
                    $base['message'] = '添加失败';
                    $base['url'] = 'detail_problem?id=' . $problem_id . '&content_id=' . $content_id;
                    return showMessage($base);
                }
            }
        }else{
            $res = DB::table('problem')->where('id',$problem_id)->first();
            $result = DB::table('submit')->where([
                ['problem_id','=',$problem_id],
                ['num_id','=',$id],
                ['content_id','=',$content_id],
                ])->first();
            if ($result != null){
                $result = $result->result;
            }
            return view('Student.detail_problem')
                ->with('res',$res)
                ->with('result',$result)
                ->with('content_id',$content_id)
                ->with('problem_id',$problem_id);
        }
    }


    /**
     * 修改个人信息
     * @param Request $request
     * @return $this|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function user_information(Request $request)
    {
        if (session('student') == null){
            return redirect('login');
        }
        if ($request->isMethod('post')){
            $passwd = Input::get('passwd');
            if ($passwd != null){
                if (strlen($passwd) < 6){
                    $base['message'] = '密码长度不少于6位';
                    $base['url'] = 'user_information';
                    return showMessage($base);
                }
                $data['passwd'] = substr_replace(md5($passwd),'a8c1m4',5,0);
            }
            $data['name'] = Input::get('name');
            $data['class'] = Input::get('class');
            $num = session('student');
            $bool = DB::table('student')->where('num',$num)->update($data);
            if ($bool !== false){
                return redirect('content');
            }else{
                $base['message'] = '更改失败，数据库挂了？';
                $base['url'] = 'login';
                return showMessage($base);
            }
        }else{
            $id = session('student');
            $res = DB::table('student')->where('num',$id)->first();
            return view('Student.user_information')->with('res',$res);
        }
    }

    /**
     * 退出
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function logout(Request $request)
    {
        if (session('teacher') != null) {
            $request->session()->flush();
            return redirect('admin');
        }else {
            $request->session()->flush();
            return redirect('login');
        }

    }
}
