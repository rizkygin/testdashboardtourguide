<!DOCTYPE html>
<html lang="en">
  <head>
    <base href="./admin">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="description" content="CoreUI - Laravel">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Dashboard Travel Guide </title>

    <!-- Styles -->
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{asset('node_modules/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}"/>
  </head>
  <body class="c-app flex-row align-items-center">

    @yield('content')
    
     <!-- Scripts -->
    <script src="{{ asset('js/dashboard.js') }}"></script>
    @stack('scripts')

  </body>
</html>
