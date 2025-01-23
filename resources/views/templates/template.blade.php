<!DOCTYPE html>
<html lang="{{str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="sistema de ventas de abarrotes" />
        <meta name="author" content="" />
        <title>Sistema ventas - @yield('title')</title>
        {{--<link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />--}}
        {{--<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">--}}
        <link href="{{asset('assetes/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" />
        <link href="{{asset('templates/css/template.css') }}" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
       {{-- <script src="{{asset('templates/js/fontawesome.js') }}" crossorigin="anonymous"></script>--}}
       @stack('css')
    </head>
    <body class="sb-nav-fixed">
        <x-navigation-header></x-navigation-header>
        <div id="layoutSidenav">
            <x-navigation-menu></x-navigation-menu>
            <div id="layoutSidenav_content">
                <main>
                    @yield('content')
                </main>
               <x-footer></x-footer>
            </div>
        </div>
       {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>--}}
        <script src="{{asset('assetes/bootstrap/js/bootstrap.bundle.min.js') }}" crossorigin="anonymous"></script>
        {{--<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>--}}
        {{--<script src="{{asset('assetes/bootstrap/js/bootstrap.bundle.min.js') }}" crossorigin="anonymous"></script>--}}
        <script src="{{asset('templates/js/scripts.js') }}"></script>
        @stack('js')
       
    </body>
</html>

