<?php

namespace App\Http\Controllers\Teacher;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Excel;
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
            $base['url'] = 'admin';
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
            if (Input::get('type') == 1){
                $bool = DB::table('student')
                    ->where('num',$data['num'])
                    ->first();
                if($bool != null){
                    $base['message'] = '用户名已存在';
                    $base['url'] = 'add_user';
                    return showMessage($base);
                }
                $id = DB::table('student')->insertGetId($data);
                if ($id != null){
                    $base['message'] = '添加成功';
                    $base['url'] = 'admin';
                    return showMessage($base);
                }
            }else{
                $bool = DB::table('teacher')
                    ->where('num',$data['num'])
                    ->first();
                if($bool != null){
                    $base['message'] = '用户名已存在';
                    $base['url'] = 'add_user';
                    return showMessage($base);
                }
                $id = DB::table('teacher')->insertGetId($data);
                if ($id != null){
                    $base['message'] = '添加成功';
                    $base['url'] = 'admin';
                    return showMessage($base);
                }
            }
        }else{
            return view('Teacher.add_user');
        }
    }


    /**
     * 管理员列表
     * @return $this|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function teacher_list()
    {
        if(session('teacher') == null){
            $base['message'] = '请重新登录';
            $base['url'] = 'admin';
            return showMessage($base);
        }
        $num = Input::get('num');
        if($num == null){
            $res = DB::table('teacher')->paginate(1);;
            return view('Teacher.teacher_list')->with('res',$res);
        }else{

        }
    }


    /**
     * 更改管理员是否有效
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function update_flag()
    {
        if(session('teacher') == null){
            $base['message'] = '请重新登录';
            $base['url'] = 'admin';
            return showMessage($base);
        }
        $id = Input::get('id');
        $data['flag'] = Input::get('flag') == 1 ? 0 : 1;
        DB::table('teacher')
            ->where('id',$id)
            ->update($data);
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
            $base['url'] = 'admin';
            return showMessage($base);
        }
        if($request->isMethod('post')){
            $num = Input::get('num');
            if(Input::get('type') == 1){
                $res = DB::table('student')->where('num',$num)->first();
                if($res == null){
                    return back()->with(['msg' => '学号不存在','type' => 1,'num' => $num]);
                }else{
                    $data['passwd'] = substr_replace(md5(Input::get('passwd')),'a8c1m4',5,0);
                    $bool = DB::table('student')->where('num',$num)->update($data);
                    if($bool != false){
                        $base['message'] = '更改成功';
                        $base['url'] = 'admin';
                        return showMessage($base);
                    }
                }
            }else{
                $res = DB::table('teacher')->where('num',$num)->first();
                if($res == null){
                    return back()->with(['msg' => '工号不存在','type' => 0,'num' => $num]);
                }else{
                    $data['passwd'] = substr_replace(md5(Input::get('passwd')),'a8c1m4',5,0);
                    $bool = DB::table('teacher')->where('num',$num)->update($data);
                    if($bool != false){
                        $base['message'] = '更改成功';
                        $base['url'] = 'admin';
                        return showMessage($base);
                    }
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
     * 授予比赛权限
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function grant_power(Request $request)
    {
        if(session('teacher') == null){
            $base['message'] = '请重新登录';
            $base['url'] = 'admin';
            return showMessage($base);
        }
        if ($request->isMethod('post')){
            $type = Input::get('type');
            $num = Input::get('num');

            $content_id = Input::get('content_id');
            $content_group = DB::table('content')->where('id',$content_id)->first();
            if ($content_group == null){
                $base['message'] = '不存在的考试id';
                $base['url'] = 'grant_power';
                return showMessage($base);
            }
            if ($type == 1){
                $file = $_FILES['file']['tmp_name'];
                if ($file == null){
                    $base['message'] = '请上传文件';
                    $base['url'] = 'grant_power';
                    return showMessage($base);
                }
                Excel::load($file, function($reader) {
                    //$data = $reader->all();
                    //获取excel的第几张表
                    $reader = $reader->getSheet(0);
                    $highestRow = $reader->getHighestRow(); // 取得总行数
                    //获取表中的数据
//                $data = $reader->toArray();
                    $content_id = Input::get('content_id');
                    for ($i = 2;$i <= $highestRow;$i ++){
                        $data[$i]['num_id'] = $reader->getCell('A'.$i)->getValue();
                        $data[$i]['content_id'] = $content_id;
                        $bool = DB::table('group')->where('num_id',$data[$i]['num_id'])->where('content_id',$content_id)->first();
                        if ($bool == null){
                            try{
                                DB::table('group')->where('num_id',$data[$i]['num_id'])->insert($data[$i]);
                            }catch (Exception $e){
                                print($e->getMessage());
                                exit;
                            }
                        }
                    }
                });
                $base['message'] = '添加成功';
                $base['url'] = 'grant_power';
                return showMessage($base);

            }else {
                if ($num == null){
                    $base['message'] = '请输入学号';
                    $base['url'] = 'grant_power';
                    return showMessage($base);
                }
                $data['num_id'] = $num;
                $data['content_id'] = $content_id;
                $bool = DB::table('group')->where('num_id',$num)->where('content_id',$content_id)->first();

                if ($bool == null){
                    $bool1 = DB::table('group')->insert($data);
                    if ($bool1 === false){
                        $base['message'] = '数据库发生错误，请重试';
                        $base['url'] = 'grant_power';
                        return showMessage($base);
                    }
                }
                $base['message'] = '添加成功';
                $base['url'] = 'grant_power';
                return showMessage($base);
            }
        }else{
            return view('Teacher.grant_power');
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
            $base['url'] = 'admin';
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
                    $data[$i]['passwd'] = $reader->getCell('D'.$i)->getValue();
                    $data[$i]['register_time'] = date("Y-m-d H:i:s");
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
            $data1['url'] = 'admin';
            $data1['message'] = '添加成功';
            return json_encode($data1);
        }else{
            return view('Teacher.add_batch');
        }
    }


}
