@extends('limitless.login')

@section('title', 'Login Section')

@section('content')

<div class="tabbable panel login-form width-400">
    <ul class="nav nav-tabs nav-justified">
        <li><a href="{{ route('auth.login.form') }}" title="Using E-Mail" class="midium-font"><h6>Using E-Mail</h6></a></li>
        <li class="active">
            <a href="{{ route('auth.login.otp-form') }}" data-toggle="tab" title='Using OTP' class='midium-font'><h6>Using OTP</h6></a>
        </li>
    </ul>

    <div class="tab-content panel-body">
        <div class="tab-pane fade in active" id="basic-tab2">
            <form accept-charset="UTF-8" method="post" action="{{ route('auth.otp-login.attempt') }}" autocomplete="off" id="otp-form">
                <input name="_token" id="_token" value="{{ csrf_token() }}" type="hidden">
                <div class="text-center">
                        <div class="icon-object border-slate-300 text-slate-300"><i class="icon-reading"></i></div>
                    <h5 class="content-group">Login With OTP</h5>
                </div>
                @include('limitless.partials.notifications')
                <br/>
                <div class="col-sm-8">
                    <div class="form-group has-feedback has-feedback-left {{ $errors->has('psk_id') ? 'has-error' : ''}}">
                        <input type="text" name="psk_id" id="psk_id" placeholder='Mobile No' class="form-control" autocomplete="off" value="{{isset($psk_id) ? $psk_id : '' }}">
                        {!! ($errors->has('psk_id') ? $errors->first('psk_id', '<p class="help-block">:message</p>') : '') !!}
                        <div class="form-control-feedback">
                            <i class="icon-user-check text-muted"></i>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <button type="submit" class="btn btn-info btn-xs getOTP">
                        <i class='fa fa-paper-plane'></i> {{trans("comman.get_otp")}}
                    </button>
                </div>
            <div class="clearfix"></div>
            </form>
        </div>
    </div>
</div>

@stop
@push('scripts')
<!-- custome js -->
<script type="text/javascript">
jQuery('.input').keypress(function (e) {
    if (e.which == 13) {
        jQuery('form#otp-form').submit();
        return false;
    }
});
</script>
@endpush