<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('page_title') :: {{ config('app.name') }}</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway:300,400,700,800">
    {{--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">--}}
    <link rel="icon" href="{{ asset("images/favicon.ico") }}" type="image/ico"/>
    <!-- NProgress -->
    <link href="{{ asset("vendors/nprogress/nprogress.css") }}" rel="stylesheet">
    <!-- Bootstrap -->
    <link href="{{ asset("vendors/bootstrap/dist/css/bootstrap.min.css") }}" rel="stylesheet">
    <!-- bootstrap-progressbar -->
    <link href="{{ asset("vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css") }}" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="{{ asset('css/custom.min.css') }}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{ asset("vendors/font-awesome/css/font-awesome.min.css") }}" rel="stylesheet">
    <!-- iCheck -->
    <link href="{{ asset("vendors/iCheck/skins/flat/green.css") }}" rel="stylesheet">



    <!-- JQVMap -->
    <link href="{{ asset("vendors/jqvmap/dist/jqvmap.min.css") }}" rel="stylesheet"/>
    <!-- bootstrap-daterangepicker -->
    <link href="{{ asset("vendors/bootstrap-daterangepicker/daterangepicker.css") }}" rel="stylesheet">

</head>
