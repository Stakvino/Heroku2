<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Data Table | @yield('title', '')</title>

        <link href="/img/favicon.ico" rel="SHORTCUT ICON" />

        <!-- Css Libs -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="http://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

        @yield('extra-css')
    </head>


<body >

    <div class="main-secion">
      @yield('content')
    </div> 

    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script src="http://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <!-- jQuery Modal -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>

  @yield('extra-js')

</body>
</html>