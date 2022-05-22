<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
        <title>@yield('title')</title>
        <!-- Icons -->
        <link rel="shortcut icon" href="{{config('app.url')}}/themes/limitless/images/logo_icon_dark.png">
    <link rel="icon" sizes="192x192" type="image/png" href="{{config('app.url')}}/themes/limitless/images/logo_icon_dark.png">
    <link rel="apple-touch-icon" sizes="180x180" href="{{config('app.url')}}/themes/limitless/images/favicons/logo_icon_dark.png">
        <link rel="stylesheet" href="{{ mix('/themes/limitless/css/all.css') }}">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        @section('style')
        @show
    </head>
    <body>
        <div class="app">
            <div id="content" class="app-content" role="main">
                <div class="box">
                    @include('limitless.partials.header')
                    @include('limitless.partials.notifications')
                    <div class="page-container">


                        <!-- Page content -->
                        <div class="page-content">
                            {{-- @include('limitless.partials.left') --}}
                            @yield('content')
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @yield('add_button')
        <script type="text/javascript">
            var form_submit_seconds = @php echo isset($form_submit_seconds)?$form_submit_seconds:10; @endphp;
        </script>
        <script src="{{ mix('/themes/limitless/js/async.js') }}"></script>
        <script type="text/javascript">
        var cancel_btn = '{{trans("comman.cancel")}}';
        var please_confirm = '{{trans("comman.please_confirm")}}';
        var ok_btn = '{{trans("comman.ok")}}';
        var delete_msg = '{{trans("comman.delete_msg")}}';
        var permission = '{{trans("comman.delete_msg")}}';
        var rejectStatus_msg = '{{trans("comman.rejectStatus_msg")}}';
        </script>
        @stack('scripts')
        <!-- footer section -->
        @section('footer')
        @include('limitless.partials.footer')
        @show
    </body>
</html>