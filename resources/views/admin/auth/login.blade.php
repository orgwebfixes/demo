@extends('limitless.login')

@section('title', 'Login Section')

@section('content')

<form accept-charset="UTF-8" method="post" action="{{ route('auth.login.attempt') }}" autocomplete="off">
    <input name="_token" value="{{ csrf_token() }}" type="hidden">
    <div class="panel panel-body login-form">
        <div class="text-center">
                <div class="icon-object border-slate-300 text-slate-300"><i class="icon-reading"></i></div>
            <h5 class="content-group">Sign In</h5>
        </div>
        @include('limitless.partials.notifications')
        <div class="form-group has-feedback has-feedback-left {{ $errors->has('email') ? 'has-error' : ''}}">
            <input type="text" class="form-control" placeholder="Email" name="email" id="email" autofocus="autofocus">
            {!! ($errors->has('email') ? $errors->first('email', '<p class="text-danger">:message</p>') : '') !!}
            <div class="form-control-feedback">
                <i class="icon-user text-muted"></i>
            </div>
        </div>
        <div class="form-group has-feedback has-feedback-left {{ $errors->has('password') ? 'has-error' : ''}}">
            <input type="password" class="form-control" placeholder="Password"  name="password">
            {!! ($errors->has('password') ? $errors->first('password', '<p class="text-danger">:message</p>') : '') !!}
            <div class="form-control-feedback">
                <i class="icon-lock2 text-muted"></i>
            </div>
        </div>
        <div class="form-group login-options">
            <div class="row">
                <div class="col-sm-6">
                    <label class="checkbox-inline">
                        <input type="checkbox" class="styled" name="remember-me"> Remember Me
                    </label>
                </div>
                <div class="col-sm-6 text-right">
                    {{link_to_route('auth.password.request.form', 'Forgot Password?', array('_url'=>'login'),array('title'=>'Password'))}}
                </div>
            </div>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-block">Sign in <i class="icon-circle-right2 position-right"></i></button>
        </div>
    </div>
</form>
@stop
