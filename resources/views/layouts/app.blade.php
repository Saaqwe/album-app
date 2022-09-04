<html>
<head>
    <title>{{  'Laravel' }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ mix('css/app.css') }}" type="text/css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
</head>
<body>

<div id="header" class="header">
    <div class="middle-column">
        <div class="search">
        </div>
        <article-add-modal></article-add-modal>
    </div>
    @if(Auth::check())
{{--        <x-user-header></x-user-header>--}}
    <x-header.user></x-header.user>
    @else
        <login></login>
        <registration></registration>
    @endif
{{--    @unless (Auth::check())--}}
{{--        <login></login>--}}
{{--    @endunless--}}
{{--    <login :user-data='{{ json_encode(Auth::user()->toArray()) }}'></login>--}}
{{--    <login user-data='user data'></login>--}}

</div>
@yield('content')

</body>
<script src="{{ mix('js/app.js') }}"></script>
<script>
    axios.get('/sanctum/csrf-cookie').then(response => {
        console.log("csfr res");
        console.log(response);
    });
</script>
</html>
