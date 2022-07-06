<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://unpkg.com/tailwindcss@1.4.6/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/flowbite@1.4.7/dist/flowbite.min.css" />
</head>
<body class=" flex items-center justify-center overflow-auto" style="background: #edf2f7;">
    <!-- comment form -->

    @yield('content')

    <script src="https://unpkg.com/flowbite@1.4.7/dist/flowbite.js"></script>
    @stack('js')
</body>
</html>
