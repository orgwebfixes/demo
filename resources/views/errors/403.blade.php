<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
        <link rel="manifest" href="/favicon/manifest.json">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>403</title>
        <link rel="stylesheet" href="{{
 mix('/themes/limitless/css/all.css') }}">
    </head>
    <body>
        <div class="app">
            <div id="content" class="app-content" role="main">
                <div class="box">
                    <div class="page-container">
                        <!-- Page content -->
                        <div class="page-content">
                            <!-- Error title -->
                            <div class="text-center content-group">
                                <h1 class="error-title">403</h1>
                                <h5>Oops, unauthorized actions...!!!</h5>
                            </div>
                            <!-- /error title -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="themes/limitless/js/async.js"></script>
        @stack('scripts')
        <!-- footer section -->
    </body>
</html>