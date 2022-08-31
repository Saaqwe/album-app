@extends("layouts.app")

@section('content')

<div class="container vh-100 d-flex flex-column mt-5">
    @if(Auth::check())
        <div class="mt-5">
            <h2 class="text-center">Вход</h2>
        </div>
        <form method="POST" action="/login" class="container-sm w-50 my-3">
            @method('POST')
            @csrf
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Email</label>
                <input type="text" name="email" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" id="exampleFormControlInput1">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
        @if ($errors->any())
            <div class="alert alert-danger">
                There were some errors with your request.
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    @else

    @endif
</div>
@stop
<script>

</script>
