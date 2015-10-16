<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $page_title }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="stylesheet" type="text/css" media="screen" href="{{ url('bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ url('bower_components/fontawesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" type="text/css" media="screen" href="{{ url('css/template.css') }}">

</head>
<body class="">

    @yield('content')

    <script src="{{ url('bower_components/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ url('bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>

    <script src="{{ url('scripts/main.js') }}"></script>
    @yield('page_js')

</body>
</html>
