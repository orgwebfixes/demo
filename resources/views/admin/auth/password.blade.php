@section('title', 'PSK::Reset')
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
        <link rel="manifest" href="/favicon/manifest.json">
        <title>@yield('title')</title>
        <link rel="stylesheet" href="{{
 mix('/themes/limitless/css/all.css') }}">
    </head>
    <body class="">
        <div class="navbar navbar-inverse">
            <div class="navbar-header">
                <a class="navbar-brand" href="{{ route('dashboard') }}">Production</a>
                <!-- Logo Of Production Here -->
            </div>
        </div>
        <div class="page-container pb-40">
            <div class="page-content">
                <div class="content-wrapper" align="center">
                    <div class="row">
                        <div class="col-md-3 col-md-offset-4">
                            <div class="panel panel-default">
                                <br>
                                <div class="text-center">
                                    <div class="icon-object border-slate-300 text-slate-300"><i class="icon-reading"></i></div>
                                </div>
                                <div class="panel-heading">
                                    <h3 class="panel-title">{{trans("comman.reset_your_pwd")}}</h3>
                                </div>
                                <div class="panel panel-body login-form">
                                    <form accept-charset="UTF-8" role="form" method="post" action="{{ route('auth.password.reset.attempt', $code) }}">
                                        <fieldset>
                                            <div class="form-group  {{ ($errors->has('password')) ? 'has-error' : '' }}">
                                                <input class="form-control" placeholder={{trans("comman.password")}} name="password" autofocus="autofocus" type="password" value="">
                                                {!! ($errors->has('password') ? $errors->first('password', '<p class="text-danger">:message</p>') : '') !!}
                                            </div>
                                            <div class="form-group  {{ ($errors->has('password_confirmation')) ? 'has-error' : '' }}">
                                                <input class="form-control" placeholder={{trans("comman.confirm_password")}} name="password_confirmation" type="password" value="">
                                                {!! ($errors->has('password_confirmation') ? $errors->first('password_confirmation', '<p class="text-danger">:message</p>') : '') !!}
                                            </div>
                                            <input name="_token" value="{{ csrf_token() }}" type="hidden">
                                            <input class="btn btn-lg btn-primary btn-block" type="submit" value={{trans("comman.save")}}>
                                        </fieldset>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @section('footer')
        @include('limitless.partials.footer')
        @show
        <script src="{{ mix('/themes/limitless/js/async.js') }}"></script>
        @stack('scripts')
    </body>
</html>
