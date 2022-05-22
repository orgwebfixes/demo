<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="agd-partner-manual-verification" />
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{config('app.url')}}{{mix('themes/limitless/css/all.css')}}">
    <!-- Icons -->
    <link rel="shortcut icon" href="{{config('app.url')}}/themes/limitless/images/logo_icon_dark.png">
    <link rel="icon" sizes="192x192" type="image/png" href="{{config('app.url')}}/themes/limitless/images/logo_icon_dark.png">
    <link rel="apple-touch-icon" sizes="180x180" href="{{config('app.url')}}/themes/limitless/images/favicons/logo_icon_dark.png">
</head>

<body class="login-container pace-done">
    <div class="pace pace-inactive">
        <div class="pace-progress" data-progress-text="100%" data-progress="99">
            <div class="pace-progress-inner"></div>
        </div>
        <div class="pace-activity"></div>
    </div>
    <!-- Main navbar -->
    <div class="navbar navbar-inverse" style="min-height:63px">
        <span class="border-orange">&nbsp;</span>
        <div class="col-sm-4">
            <div class="navbar-header navbar-header-custom">
                <a class="" href="{{ route('dashboard') }}">
                    <img src="{{config('app.url')}}/themes/limitless/images/logo_icon_light.png" alt="">
                </a>
                <ul class="nav navbar-nav pull-right visible-xs-block">
                    <li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="page-container">
        <div class="page-content">
            <div class="content-wrapper">
                <!-- Login Form -->
                @yield('content')
            </div>
        </div>
    </div>
    <script src="{{config('app.url')}}{{mix('themes/limitless/js/async.js')}}"></script>
    @stack('scripts')
    <!-- footer section -->
    @section('footer')
    <div class="footer text-muted">
        <div class="col-sm-6">
            &copy; {{ date('Y') }}.
            <a href="{{ route('dashboard') }} ">
                {{Config::get('srtpl.settings.site_copyright','OrgWebTech. All rights reserved.')}}
            </a>
        </div>
        <div class="col-sm-6">
            @include('limitless.partials.crafted-by')
        </div>
    </div>
    @show
</body>

</html>