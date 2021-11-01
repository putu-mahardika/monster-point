 <!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <link rel="icon" href="{{ asset('img/money.png') }}">
        <title>Point Service</title>
        <link href="{{ asset('app.css') }}" rel="stylesheet" />
    </head>
    <body class="sb-nav-fixed" style="overflow-x: hidden;">
        @include('partials.topbar')
        <div id="layoutSidenav">
          @include('partials.menu')
           @include('partials.content')
        </div>
        </div>
        <script src="{{ asset('js/app.js') }}"></script>
    </body>
</html>
