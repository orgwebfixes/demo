@extends('limitless.login')

@section('title', 'Reset')

@section('content')
<!-- Page container -->
<div class="page-container">
    <!-- Page content -->
    <div class="page-content">
        <!-- Main content -->
        <div class="content-wrapper">
            <!-- Password recovery -->
            <form accept-charset="UTF-8" role="form" method="post" action="{{ route('auth.password.request.attempt') }}">
                <div class="panel panel-body login-form">
                    <div class="text-center">
                        <div class="icon-object border-slate-300 text-slate-300"><i class="icon-reading"></i></div>
                        <h5 class="content-group">{{trans("comman.password_recovery")}} <small class="display-block">{{trans("comman.msg")}}</small></h5>
                    </div>

                    @include('limitless.partials.notifications')
                    <br>
                    <div class="form-group has-feedback">
                        <input type="text" name="email" class="form-control" autofocus="autofocus" placeholder='{{trans("comman.your_email")}}' />
                        <div class="form-control-feedback">
                            <i class="icon-mail5 text-muted"></i>
                        </div>
                        {!! ($errors->has('email') ? $errors->first('email', '<p class="text-danger">:message</p>') : '') !!}
                    </div>
                    <input name="_token" value="{{ csrf_token() }}" type="hidden">
                    <button type="submit" class="btn bg-blue btn-block">{{trans("comman.reset_password")}} <i class="icon-arrow-right14 position-right"></i></button>
                </div>
            </form>
            <!-- /password recovery -->
        </div>
        <!-- /main content -->
    </div>
    <!-- /page content -->
</div>
<!-- /page container -->
@stop