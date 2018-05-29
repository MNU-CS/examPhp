<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/problem_confirm',function (Request $request){
    $allproblem = $request->get('problem');
    $problem = explode(',',$allproblem);
    foreach ($problem as $value){
        $bool = DB::table('problem')->where('id',$value)->first();
        if ($bool == null){
            return 0;
        }
    }
    return 1;
});
