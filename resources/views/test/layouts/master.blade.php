<!doctype html>
<html lang="tr">
<head>
    @include('test.layouts.partials.head')
    <title>@yield('html_title', config('app.name')) :: {{ config('app.name') }}</title>
</head>
<body>
<header>
@include('test.layouts.partials.navbar')
</header>
<main>
@yield('html_body')
</main>
<footer>
@include('test.layouts.partials.footer')
</footer>
@include('test.layouts.partials.scripts')
</body>
</html>
