<?php
/**
* 跳转提示函数
*/
function showMessage(Array $array){

//验证参数
if(!empty($array['message']) && !empty($array['url'])){
$data = [
'message' => $array['message'],
'url' => $array['url'],
'jumpTime' => !empty($array['time']) ? $array['time'] : 2000,
'ok'=>!empty($array['ok']) ? $array['ok'] : true
];
} else {
$data = [
'message' => '非法访问！',
'url' => 'javascript：history.back();',
'jumpTime' => 2000,
'ok'=>!empty($array['ok']) ? $array['ok'] : true
];
}
return view('message',['data' => $data]);

//  return redirect('/message')->with($array);
}