@extends("layouts.app")
@section('content')

<div class="container vh-100 d-flex flex-column mt-5">
    <div class="mt-5">
        <h2 class="text-center">Вход</h2>
    </div>
    <form method="POST" action="/login" class="container-sm w-50 my-3">
        @method('POST')
        @csrf
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Login</label>
            <input type="text" name="email" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Password</label>
            <input type="password" name="password" class="form-control" id="exampleFormControlInput1">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    <div id="app">
        <login></login>
    </div>
</div>

<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
        Launch demo modal
    </button>
<div class="my-btn">
        <div class="text" style="height: 80px; width: 80px">
            MY MESSAGE
        </div>
    </div>
    <!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
@stop
<script>

</script>
