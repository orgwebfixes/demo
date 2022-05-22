<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>{{$module_title}}</title>
        <!-- Stylesheets -->
        <!-- Bootstrap is included in its original form, unaltered -->
        <link rel="stylesheet" href="{{ base_path('resources/themes/limitless/assets/css/bootstrap.min.css') }}">
        <style type="text/css" media="all">
            *{
                color: black;
            }
            body {
                margin-left: 0px;
                margin-right: 0px;                
            }
            .table-bordered{
                border: 0.8px solid black !important;
            }
            .table-bordered > thead > tr > td, .table-bordered > thead > tr > th,.table-bordered > tfoot > tr > td, .table-bordered > tfoot > tr > th{
                border-bottom-width: 1px;
                padding: 2px;
                font-size: 10px;
                border: 0.8px solid black !important;
            }
            .table-bordered > tbody > tr > td, .table-bordered > tbody > tr > th{
                padding: 2px;
                font-size: 10px;
                border: 0.8px solid black !important;
            }
            .bold{
                font-weight: bold;
            }
        </style>
        @section('style')
        @show
    </head>
    <body>
        <!-- Page Container -->
        <div id="page-container">
            <!--  Content -->
            @yield('content')
        </div>
        <!-- END Page Container -->
    </body>
</html>