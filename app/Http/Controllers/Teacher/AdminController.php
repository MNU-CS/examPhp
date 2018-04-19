<?php

namespace App\Http\Controllers\Teacher;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Validation\Rules\In;

class AdminController extends Controller
{


    public function admin()
    {
        if(session('teacher') == null){
            return redirect('login');
        }
        return view('Teacher.admin');
    }


    /**
     * 更改用户信息
     * @param Request $request
     * @return $this|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function admin_information(Request $request)
    {
        if(session('teacher') == null){
            return redirect('manage');
        }
        if ($request->isMethod('post')) {
            $passwd = Input::get('passwd');
            if ($passwd != null){
                if (strlen($passwd) < 6){
                    $base['message'] = '密码长度不少于6位';
                    $base['url'] = 'admin_information?id=' . Input::get('id');
                    return showMessage($base);
                }
                $data['passwd'] = substr_replace(md5($passwd),'a8c1m4',5,0);
            }
            $data['name'] = Input::get('name');
            $data['class'] = Input::get('class');
            $data['role'] = Input::get('type');
            $num = Input::get('num');
            if (session('del') == null){
                $user = DB::table('student')->where('num',$num)->first();
                if ($user->role == 3 && $data['role'] != 3){
                    $base['message'] = '你没有更改管理员身份权限';
                    $base['url'] = 'admin_information?id=' . Input::get('id');
                    return showMessage($base);
                }
            }
            $bool = DB::table('student')->where('num',$num)->update($data);
            if ($bool !== false){
                $base['message'] = '更改成功';
                $base['url'] = 'teacher_list';
                return showMessage($base);
            }else{
                $base['message'] = '更改失败，数据库挂了？';
                $base['url'] = 'manage';
                return showMessage($base);
            }
        } else {
            $id = Input::get('id');
            $res = DB::table('student')->where('id',$id)->first();
            return view('Teacher.admin_information')->with('res',$res);
        }
    }
}
