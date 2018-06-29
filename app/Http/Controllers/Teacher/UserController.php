<?php

namespace App\Http\Controllers\Teacher;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Excel;
use Illuminate\Validation\Rules\In;

class UserController extends Controller
{

    /**
     * 添加用户
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add_user(Request $request)
    {
        if(session('teacher') == null){
            $base['message'] = '请重新登录';
            $base['url'] = 'login';
            return showMessage($base);
        }
        if ($request->isMethod('post')){
            $data = [
                'num'       => Input::get('num'),
                'passwd'    => substr_replace(md5(Input::get('passwd')),'a8c1m4',5,0),
                'name'      => Input::get('name'),
                'class'     => Input::get('class'),
                'register_time' => date('Y-m-d H:i:s'),
            ];
            $data['role'] = Input::get('type');

            $bool = DB::table('student')
                ->where('num',$data['num'])
                ->first();
            if($bool != null){
                $base['message'] = '用户已存在';
                $base['url'] = 'add_user';
                return showMessage($base);
            }
            $id = DB::table('student')->insertGetId($data);
            if ($id != null){
                $base['message'] = '添加成功';
                $base['url'] = 'manage';
                return showMessage($base);
            }

        }else{
            return view('Teacher.add_user');
        }
    }


    /**
     * 用户列表
     * @return $this|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function teacher_list()
    {
        if(session('teacher') == null){
            $base['message'] = '请重新登录';
            $base['url'] = 'login';
            return showMessage($base);
        }
        $num = Input::get('num');
        if($num == null){
            $res = DB::table('student')->paginate(20);
            return view('Teacher.teacher_list')->with('res',$res)->with('num',$num);
        }else{
            $res = DB::table('student')->where('num',$num)->paginate(20);
            return view('Teacher.teacher_list')->with('res',$res)->with('num',$num);
        }
    }


    /**
     * 删除用户
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function del_user()
    {
        if(session('teacher') == null){
            $base['message'] = '请重新登录';
            $base['url'] = 'login';
            return showMessage($base);
        }
        $id = Input::get('id');
        if (session('del') == null) {
            $user = DB::table('student')->where('id',$id)->first();
            if ($user->role == 3) {
                $base['message'] = '你没有删除管理员用户权限';
                $base['url'] = 'teacher_list';
                return showMessage($base);
            }
        }
        DB::transaction(function () {
            $id = Input::get('id');
            $student = DB::table('student')
                ->where('id',$id)
                ->first();
            DB::table('submit')->where('num_id',$student->num)->delete();
            DB::table('group')->where('num_id',$student->num)->delete();
            DB::table('student')->where('id',$id)->delete();
        }, 5);
        return back();

    }


    /**
     * 更改密码
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function change_pwd(Request $request)
    {
        if(session('teacher') == null){
            $base['message'] = '请重新登录';
            $base['url'] = 'login';
            return showMessage($base);
        }
        if($request->isMethod('post')){
            $num = Input::get('num');
            $res = DB::table('student')->where('num',$num)->first();
            if($res == null){
                return back()->with(['msg' => '学号不存在','type' => 1,'num' => $num]);
            }else{
                $data['passwd'] = substr_replace(md5(Input::get('passwd')),'a8c1m4',5,0);
                $bool = DB::table('student')->where('num',$num)->update($data);
                if($bool !== false){
                    $base['message'] = '更改成功';
                    $base['url'] = 'manage';
                    return showMessage($base);
                }
            }
        }else{
            $num = Input::get('num');
            if ($num != null){
//                $res = DB::table('');
//                return view('Teacher.change_pwd')->with('res',$res);
            }
            return view('Teacher.change_pwd');
        }
    }


    /**
     * 批量添加
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add_batch(Request $request)
    {
        if(session('teacher') == null){
            $base['message'] = '请重新登录';
            $base['url'] = 'login';
            return showMessage($base);
        }
        if ($request->isMethod('post')){

            $file = $_FILES['file']['tmp_name'];
            Excel::load($file, function($reader) {
                //$data = $reader->all();
                //获取excel的第几张表
                $reader = $reader->getSheet(0);
                $highestRow = $reader->getHighestRow(); // 取得总行数
                $highestColumm = $reader->getHighestColumn(); // 取得总列数
                //获取表中的数据
//                $data = $reader->toArray();
                for ($i = 2;$i <= $highestRow;$i ++){
                    $data[$i]['class'] = $reader->getCell('A'.$i)->getValue();
                    $data[$i]['num'] = $reader->getCell('B'.$i)->getValue();
                    $data[$i]['name'] = $reader->getCell('C'.$i)->getValue();
                    $data[$i]['passwd'] = substr_replace(md5($reader->getCell('D'.$i)->getValue()),'a8c1m4',5,0);
                    $data[$i]['register_time'] = date("Y-m-d H:i:s");
                    $data[$i]['role'] = 1;
                    $bool = DB::table('student')->where('num',$data[$i]['num'])->first();
                    if ($bool != null){
                        try{
                            DB::table('student')->where('num',$data[$i]['num'])->update($data[$i]);
                        }catch (Exception $e){
                            print($e->getMessage());
                            exit;
                        }
                    } else {
                        try{
                            DB::table('student')->insert($data[$i]);
                        }catch (Exception $e){
                            print($e->getMessage());
                            exit;
                        }
                    }
                }
            });
            $data1['url'] = 'manage';
            $data1['message'] = '添加成功';
            return json_encode($data1);
        }else{
            return view('Teacher.add_batch');
        }
    }


    public function reset_ip(Request $request)
    {
        if ($request->isMethod("post")){
            $num = Input::get('num');
            $data['ip'] = '';
            $res = DB::table('student')->where('num',$num)->update($data);
            if ($res != ''){
                return 0;
            }else {
                return 1;
            }
        }else {
            return view('Teacher.reset_ip');
        }

    }
}
