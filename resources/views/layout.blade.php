<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@3.x/css/materialdesignicons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Oswald&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Fjalla+One&display=swap" rel="stylesheet">
    
    @stack('styles')

    <title>Ventas Evertec</title>
    <style>
         * {
            font-family: 'Roboto', sans-serif;
        }
        
          html{
            background: #fafafa;
        }
        ::-webkit-scrollbar-track
{
	-webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
	border-radius: 5px;
	background-color: #F5F5F5;
}


::-webkit-scrollbar
{
	width: 5px;
	height: 5px;
	background-color: #F5F5F5;
}

::-webkit-scrollbar-thumb
{
	border-radius: 5px;
	-webkit-box-shadow: inset 0 0 6px rgba(0,0,0,.3);
	background-color: #0e4686;
}
    a.menu_a.v-list-item--active::before{
            content: '';
            border-left: 7px solid #424242;
            height: 100%;
            left: 0;
            position: absolute;
            opacity: 1;
            background-color: transparent;
        }
        .menu_a i.v-icon{
            font-size: 30px!important;
    margin-top: 3px;
}
a.menu_a .v-list-item__content{
    opacity: 1;
}
a.menu_a.v-list-item{
    height: 85px!important;

    flex-direction: column;
    justify-content: center;
    align-items: center;
    font-size: 13px;
    font-style: normal;
    font-weight: 400;
    border-bottom: 1px solid #f3f3f3;
    -webkit-transition: color .3s;
    transition: color .3s;
    -webkit-transition: background .3s;
    transition: background .3s;
}

.v-list-item--active {
    color: #000!important;
    background: #fafafa;
}

a.menu_a.v-list-item:hover{


        color: #1565c0!important;

}
a.menu_a.v-list-item{
    border-bottom: none!important;
    text-decoration: none!important;

}</style>
</head>

<body>
    <div id="app">
        <v-app id="inspire">
            
              @yield('componentes_vue')
            
           
        </v-app>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
    
   
    
    @stack('scripts')
</body>
</html>
