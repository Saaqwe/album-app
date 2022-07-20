<html>
<head>
    <title>{{  'Laravel' }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ mix('css/app.css') }}" type="text/css">
</head>
<body>
@yield('content')
</body>
<script src="{{ mix('js/app.js') }}"></script>
<script>
    // axios.get('/sanctum/csrf-cookie').then(response => {
    //     console.log("csfr res");
    //     console.log(response);
    // });
</script>
</html>
