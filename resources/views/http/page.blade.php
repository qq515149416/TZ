@extends('layouts.layout')

@section('title', '服务器租用，服务器托管，专业IDC服务商')

@section('content')

    <div class="row">
        <div class="iframe">
            @if (strpos($p,".html"))
            <iframe width="100%" scrolling="no" seamless frameborder="0" src="http://175.6.248.62:8080/{{ $directory }}/{{ $p }}" height="3065px"></iframe>
            @else
            <iframe width="100%" scrolling="no" seamless frameborder="0" src="http://175.6.248.62:8080/{{ $directory }}/{{ $p }}.jsp" height="3065px"></iframe>
            @endif
        </div>
    </div>

@endsection
