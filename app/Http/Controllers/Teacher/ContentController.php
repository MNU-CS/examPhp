<?php

namespace App\Http\Controllers\Teacher;

use function foo\func;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Validation\Rules\In;
use ZipArchive;
class ContentController extends Controller
{
    /**
     * 获取考试列表
     * @param Request $request
     * @return $this|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function content_list(Request $request)
    {
        if(session('teacher') == null){
            $base['message'] = '请重新登录';
            $base['url'] = 'login';
            return showMessage($base);
        }
        $res = DB::table('content')
            ->paginate(20);
        return view('Teacher/content_list')->with('res',$res);

    }


    /**
     * 添加考试
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add_content(Request $request)
    {
        if(session('teacher') == null){
            $base['message'] = '请重新登录';
            $base['url'] = 'login';
            return showMessage($base);
        }
        if ($request->isMethod('post')){
            DB::transaction(function (){

                $data = [
                    'title'        => Input::get('title'),
                    'start_time'   => Input::get('start_time'),
                    'end_time'     => Input::get('end_time'),
                    'update_at'    => session('teacher'),
                    'update_time'  => date('Y-m-d H:i:s'),
                    'news'         => Input::get('news'),
                ];
                if (Input::get('open') != null){
                    $data['open'] = 1;
                }else{
                    $data['open'] = 0;
                }
                if (Input::get('status') != null){
                    $data['status'] = 1;
                }else{
                    $data['status'] = 0;
                }
                $problem1 = Input::get('problem');
                $problem = explode(',',$problem1);
                $res['content_id'] = DB::table('content')->insertGetId($data);
                foreach ($problem as $item) {
                    $res['problem_id'] = $item;
                    DB::table('online_problem')->insert($res);
                }
                $users = explode(PHP_EOL,Input::get('users'));
                foreach ($users as $user) {
                    if ($user == ''){
                        continue;
                    }
                    $bool = DB::table('group')->where('num_id',trim($user))->where('content_id',$res['content_id'])->first();
                    if ($bool == null){
                        $group['num_id'] = trim($user);
                        $group['content_id'] = $res['content_id'];
                        DB::table('group')->insert($group);
                    }
                }

            },5);
            $base['message'] = '添加成功';
            $base['url'] = 'content_list';
            return showMessage($base);
        }else{
            $pid = Input::get('pid');
            return view('Teacher.add_content')->with('res',$pid);

        }
    }


    /**
     * 编辑考试
     * @param Request $request
     * @return $this|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function update_content(Request $request)
    {
        if(session('teacher') == null){
            $base['message'] = '请重新登录';
            $base['url'] = 'login';
            return showMessage($base);
        }
        if ($request->isMethod('post')){
            DB::transaction(function (){
                $data = [
                    'title'        => Input::get('title'),
                    'start_time'   => Input::get('start_time'),
                    'end_time'     => Input::get('end_time'),
                    'update_at'    => session('teacher'),
                    'update_time'  => date('Y-m-d H:i:s'),
                    'news'         => Input::get('news'),
                ];
                if (Input::get('open') != null){
                    $data['open'] = 1;
                }else{
                    $data['open'] = 0;
                }
                if (Input::get('status') != null){
                    $data['status'] = 1;
                }else{
                    $data['status'] = 0;
                }
                $problem1 = Input::get('problem');
                $problem = explode(',',$problem1);
                $id = Input::get('id');
                DB::table('content')
                    ->where('id',$id)
                    ->update($data);
                DB::table('online_problem')
                    ->where('content_id',$id)
                    ->delete();
                foreach ($problem as $item) {
                    $res['problem_id'] = $item;
                    $res['content_id'] = $id;
                    DB::table('online_problem')->insert($res);
                }
                DB::table('group')
                    ->where('content_id',$id)
                    ->delete();
                $users = explode(PHP_EOL,Input::get('users'));
                foreach ($users as $user) {
                    if ($user != '') {
                        $bool = DB::table('group')->where('num_id', trim($user))->where('content_id', $id)->first();
                        if ($bool == null) {
                            $group['num_id'] = trim($user);
                            $group['content_id'] = $res['content_id'];
                            DB::table('group')->insert($group);
                        }
                    }
                }

            },5);
            $base['message'] = '修改成功';
            $base['url'] = 'content_list';
            return showMessage($base);
        }else{
            $id = Input::get('id');
            $res = DB::table('content')->where('id',$id)->first();
            $obj_problem = DB::table('online_problem')
                ->where('content_id',$id)
                ->pluck('problem_id');
            $problem = array();
            foreach ($obj_problem as $item) {
                $problem[] = $item;
            }
            $all_problem = implode(',',$problem);
            $obj_users = DB::table('group')->where('content_id',$id)->pluck('num_id');
            $users = array();
            foreach ($obj_users as $obj_user) {
                $users[] = $obj_user;
            }
            $user = implode(PHP_EOL,$users);
            return view('Teacher/update_content')
                ->with('problem',$all_problem)
                ->with('res',$res)
                ->with('user',$user);
        }
    }


    /**
     * 更改考试状态
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function update_cstatus()
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

        $res = DB::table('content')
            ->where('id',$id)
            ->update($data);
        if($res != false){
            return back();
        }
    }


    /**
     * 公开 或者 内部
     */
    public function update_open()
    {
        if(session('teacher') == null){
            $base['message'] = '请重新登录';
            $base['url'] = 'login';
            return showMessage($base);
        }
        $id = Input::get('id');
        $data['open'] = Input::get('open');
        $data['open'] = $data['open'] == 1 ? 0 : 1;
        $data['update_time'] = date('Y-m-d H:i:s');
        $data['update_at'] = session('teacher');

        $res = DB::table('content')
            ->where('id',$id)
            ->update($data);
        if($res != false){
            return back();
        }
    }


    /**
     * 下载考试结果
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function download()
    {
        //判断是否过期
        if(session('teacher') == null){
            $base['message'] = '请重新登录';
            $base['url'] = 'login';
            return showMessage($base);
        }
        $id = Input::get('id');
        $title = Input::get('title');
        $sto = storage_path();
        //创建当前考试文件夹
        if (is_dir($sto . '/download/' .$id)){
            $this->delete($sto . '/download/' . $id);
        }
        $bool = mkdir($sto . '/download/' . $id);
        if ($bool === false) {
            $base['message'] = '创建目录失败';
            $base['url'] = 'content_list';
            return showMessage($base);
        }
        //创建压缩目录
        if (is_dir($sto . '/zip/' . $id)){
            $this->delete($sto . '/zip/' . $id);
        }
        $bool2 = mkdir($sto . '/zip/' . $id);
        if ($bool2 === false) {
            $base['message'] = '创建目录失败';
            $base['url'] = 'content_list';
            return showMessage($base);
        }
        $zip_dir = $sto . '/zip/' . $id . '/';
        $content_dir = $sto . '/download/' . $id . '/';
        $stu_all = DB::table('submit')->select('num_id')->where('content_id',$id)->get();
        $stu = array();
        foreach ($stu_all as $item) {
            $stu[] = $item->num_id;
        }
        $stu = array_unique($stu);
        if ($stu == null){
            return back();
        }
        foreach ($stu as $value){
            $bool1 = mkdir($content_dir . $value);
            if ($bool1 === false){
                $base['message'] = '创建子目录失败';
                $base['url'] = 'content_list';
                return showMessage($base);
            }else {
                $dir1 = $content_dir . $value . '/';
                $res = DB::table('submit')->where('num_id',$value)->where('content_id',$id)->get();

                $user = DB::table('student')->where('num',$value)->first();
                foreach ($res as $v){
                    $problem = DB::table('problem')->where('id',$v->problem_id)->first();
                    $fh = fopen($dir1 . $user->class . '--' . $user->num . '--' . $user->name . '--' .
                        $problem->title . '.doc','a+');
                    fwrite($fh,$v->result);
                    fclose($fh);
                }
                $zip = new \Chumper\Zipper\Zipper;
                $file = glob($dir1 . '*');
                $zip->make($zip_dir . $user->class . '--' . $user->num .
                    '--' . $user->name  . '.zip')->add($file)->close();
            }
        }
        $zipper = new \Chumper\Zipper\Zipper;
        $files = glob($zip_dir . '*');
        $zipper->make($zip_dir .'result')->add($files);
        $zipper->close();
        return response()->download($zip_dir . 'result', $title . '.zip');

    }


    /**
     * 递归删除目录
     * @param $dir
     */
    public function delete($dir)
    {
        if (is_dir($dir)){
            $fh = opendir($dir);
            while ($file = readdir($fh)){
                if ($file != '.' && $file != '..'){
                    if (is_dir($dir . '/' . $file)){
                        $this->delete($dir . '/' . $file);
                    } else {
                        unlink($dir . '/' . $file);
                    }
                }
            }
        }else{
            unlink($dir);
        }
        closedir($fh);
        if (rmdir($dir)){
            return true;
        } else {
            return false;
        }
    }


    /**
     * 查看提交记录
     * @return $this|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show_submit()
    {
        if(session('teacher') == null){
            $base['message'] = '请重新登录';
            $base['url'] = 'login';
            return showMessage($base);
        }
        $content_id = Input::get('content_id');
        if ($content_id != null){
            $res = DB::table('submit')
                ->join('student','submit.num_id','=','student.num')
                ->where('content_id',$content_id)
                ->select('submit.*','student.name')
                ->paginate(20);
            $penple = DB::table('submit')
                ->where('content_id',$content_id)
                ->groupBy('num_id')
                ->select('num_id')
                ->get();
        } else {
            $res = DB::table('submit')
                ->join('student','submit.num_id','=','student.num')
                ->select('submit.*','student.name')
                ->paginate(20);
            $penple = DB::table('submit')
                ->groupBy('num_id')
                ->select('num_id')->get();

        }
        $penple_all = count($penple);
        return view('Teacher.show_submit')
            ->with('res',$res)
            ->with('content_id',$content_id)
            ->with('all',$penple_all);
    }


    /**
     * 查看代码
     */
    public function show_code()
    {
        if(session('teacher') == null){
            $base['message'] = '请重新登录';
            $base['url'] = 'login';
            return showMessage($base);
        }
        $id = Input::get('id');
        $res = DB::table('submit')->where('id',$id)->first();
        return view('Teacher.show_code')->with('res',$res);
    }


    /**
     * 删除题目或考试
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function delete_pc()
    {
        if(session('teacher') == null){
            $base['message'] = '请重新登录';
            $base['url'] = 'login';
            return showMessage($base);
        }
        $id = Input::get('id');
        $flag = Input::get('flag');
        if ($flag == 1){
            $bool1 = DB::table('online_problem')
                ->where('problem_id',$id)
                ->first();
            if ($bool1 != null){
                $base['message'] = '题目在考试列表中出现，不可删除';
                $base['url'] = 'problem_list';
                return showMessage($base);
            }
            $bool = DB::table('problem')
                ->where('id',$id)
                ->delete();
        } else{
            DB::transaction(function () {
                $id = Input::get('id');
                DB::table('online_problem')->where('content_id',$id)->delete();
                DB::table('submit')->where('content_id',$id)->delete();
                DB::table('group')->where('content_id',$id)->delete();
                DB::table('content')->where('id',$id)->delete();
            }, 5);

        }
       return back();
    }
}
