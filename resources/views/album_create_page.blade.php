@extends("layouts.app")

@section('content')

    <div id="app">

        <div class="m-auto mt-5" style="width: 600px;">
            <album-create-form
                :user-authenticated='<?php echo json_encode(Auth::check()); ?>'
            ></album-create-form>
        </div>
    </div>

@stop
