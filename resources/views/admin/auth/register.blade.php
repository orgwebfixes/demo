@extends('limitless.login')
@section('title', 'PSK::Register')
<style type="text/css">
    fieldset > div.proof{
        padding-bottom:5px;
    }
    div.panel-body > hr{
        margin-top:5px;
        margin-bottom:5px;
    }
    div.panel-body > div.row > div.detail > fieldset > hr{
        margin-top:5px;
        margin-bottom:6px;
    }
    div.form-group{
        margin-bottom:10px;
    }
</style>
@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-lg-8 col-lg-offset-2">
            <div class="panel registration-form">
            {!! Form::open(array('route' => 'auth.register.attempt','role'=>"form",'files'=>true,'mutipart')) !!}
                @include('admin.auth.form')
            {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@stop
