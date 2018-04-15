@extends('layouts.app')

@section('sidebar')
    @parent
@endsection

@section('content')
    <pre class="layui-code">
{{$res->result}}
    </pre>

@endsection
