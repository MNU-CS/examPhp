<?php

namespace App\Http\Controllers\Teacher;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Validation\Rules\In;

class AdminController extends Controller
{
    //
    public function index(Request $request)
    {
        if(session('teacher') != null){
            return redirect('manage');
        }
        if($request->isMethod('post')){
            $username = Input::get('username');
            $passwd = Input::get('passwd');
            $res = DB::table('teacher')->where('num',$username)->first();
            if(empty($res)){
                return back()->with('k','账号不存在');
            }
            else {
                if (substr_replace(md5($passwd),'a8c1m4',5,0) != $res->passwd) {
                    return back()->with('k','密码错误');
                }else{
                    session(['teacher' => $res->name]);
                    session(['teacher_num' => $username]);
                    return redirect('manage');
                }
            }
        }else{
            return view('Teacher.login');
        }
    }


    public function admin()
    {
        if(session('teacher') == null){
            return redirect('admin');
        }
        return view('Teacher.admin');
    }


    public function admin_information(Request $request)
    {
        if(session('teacher') == null){
            return redirect('manage');
        }
        if ($request->isMethod('post')){
            $passwd = Input::get('passwd');
            if ($passwd != null){
                if (strlen($passwd) < 6){
                    $base['message'] = '密码长度不少于6位';
                    $base['url'] = 'admin_information';
                    return showMessage($base);
                }
                $data['passwd'] = substr_replace(md5($passwd),'a8c1m4',5,0);
            }
            $data['name'] = Input::get('name');
            $data['class'] = Input::get('class');
            $num = session('teacher_num');
            $bool = DB::table('teacher')->where('num',$num)->update($data);
            if ($bool !== false){
                return redirect('admin');
            }else{
                $base['message'] = '更改失败，数据库挂了？';
                $base['url'] = 'admin';
                return showMessage($base);
            }
        }else{
            $id = session('teacher');
            $teacher_num = session('teacher_num');
            $res = DB::table('teacher')->where('num',$teacher_num)->first();
            return view('Teacher.admin_information')->with('res',$res);
        }
    }
}
