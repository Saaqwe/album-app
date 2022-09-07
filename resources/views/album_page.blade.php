@extends("layouts.app")

@section('content')
    <div id="app">
        <album-list
            :user-authenticated='<?php echo json_encode(Auth::check()); ?>'
        ></album-list>
    </div>
@stop
