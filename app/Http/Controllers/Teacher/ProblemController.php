<?php

namespace App\Http\Controllers\Teacher;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
class ProblemController extends Controller
{


    //
    public function problem_list()
    {

        $res = DB::table('problem')->paginate(20);
        return view('Teacher.problem_list')->with('res',$res);
    }


    public function add_problem(Request $request)
    {
        if(session('teacher') == null){
            $base['message'] = '请重新登录';
            $base['url'] = 'login';
            return showMessage($base);
        }
        if($request->isMethod('post')){
            $data['title'] = Input::get('title');
            if($data['title'] == null){
                return showMessage(array('message' => '标题不能为空','url' => 'add_problem'));
            }
            $data['descripe'] = Input::get('descripe');
            if($data['descripe'] == null){
                return showMessage(array('message' => '描述不能为空','url' => 'add_problem'));
            }
            $data['input'] = Input::get('sample_input');
            $data['output'] = Input::get('sample_output');
            $data['hint'] = Input::get('hint');
            $data['update_at'] = session('teacher');
            $now = date('Y-m-d H:i:s');
            $data['update_time'] = $now;
            $res = DB::table('problem')->insertGetId($data);
            if($res != null){
                $base['message'] = '成功';
                $base['url'] = url('manage');
                return showMessage($base);
            }else{
                $base['message'] = '添加失败';
                $base['url'] = url('add_problem');
                return showMessage($base);
            }
        }else{
            return view('Teacher.add_problem');
        }
    }


    public function update_problem(Request $request)
    {
        if(session('teacher') == null){
            $base['message'] = '请重新登录';
            $base['url'] = 'manage';
            return showMessage($base);
        }
        if ($request->isMethod('post')){
            $data['title'] = Input::get('title');
            if($data['title'] == null){
                return showMessage(array('message' => '标题不能为空','url' => 'add_problem'));
            }
            $data['descripe'] = Input::get('descripe');
            if($data['descripe'] == null){
                return showMessage(array('message' => '描述不能为空','url' => 'add_problem'));
            }
            $data['input'] = Input::get('sample_input');
            $data['output'] = Input::get('sample_output');
            $data['hint'] = Input::get('hint');
            $data['update_at'] = session('teacher');

            $now = date('Y-m-d H:i:s');
            $data['update_time'] = $now;
            $id = Input::get('id');
            $res = DB::table('problem')
                ->where('id',$id)
                ->update($data);
            if($res !== false){
                $base['message'] = '更改成功';
                $base['url'] = url('manage');
                return showMessage($base);
            }else{
                $base['message'] = '更改失败';
                $base['url'] = url('update_problem?id=' . $id);
                return showMessage($base);
            }
        }else{
            $id = Input::get('id');
            $res = DB::table('problem')
                ->where('id',$id)
                ->first();
            return view('Teacher.update_problem')->with('res',$res);
        }
    }


    public function update_status(Request $request)
    {
        if(session('teacher') == null){
            $base['message'] = '请重新登录';
            $base['url'] = 'login';
            return showMessage($base);
        }
        $id = Input::get('id');
        $data['status'] = Input::get('status');
        $data['status'] = $data['status'] == 1 ? 0 : 1;
        $data['update_time'] = date('Y-m-d H:i:s');
        $data['update_at'] = session('teacher');

        $res = DB::table('problem')
            ->where('id',$id)
            ->update($data);
        if($res != false){
            return back();
        }
    }


}
