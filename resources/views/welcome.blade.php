<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">


        <title>{{config("app.name", 'Lagsapi Vue')}}</title>

        <!-- CSS -->
        <link rel="stylesheet" href="{{asset('css/app.css')}}">

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <script>
            window.Laravel = {
                csrfToken: '{{ csrf_token() }}'
            }
        </script>
    </head>
    <body>
        <div id="app">
            <navbar></navbar>
           <div class="container">
               
                <articles></articles>
           </div>
        </div>
        <!-- JS -->
        <script src="{{asset('js/app.js')}}"></script>
    </body>
</html>
