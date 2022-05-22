@extends('limitless.login')

@section('title', 'PSK::Login')

@section('content')

<div class="tabbable panel login-form width-400">
    <ul class="nav nav-tabs nav-justified">
        <li><a href="{{ route('auth.login.form') }}" title="Using PSK ID / E-Mail" class="midium-font"><h6>{{trans("comman.using_psk")}}</h6></a></li>
        <li class="active">
            <a href="{{ route('auth.login.otp-form') }}" data-toggle="tab" title='Using OTP' class='midium-font'><h6> {{ trans("comman.using_otp") }}</h6></a>
        </li>
    </ul>

    <div class="tab-content panel-body">
        <div class="tab-pane fade in active" id="basic-tab2">
            <form accept-charset="UTF-8" method="post" action="{{ route('auth.otp-login.otp-form') }}" autocomplete="off">
                <input name="_token" id="_token" value="{{ csrf_token() }}" type="hidden">
                <div class="text-center">
                        <div class="icon-object border-slate-300 text-slate-300"><i class="icon-reading"></i></div>
                    <h5 class="content-group">{{trans("comman.login_otp")}}</h5>
                </div>
                @include('limitless.partials.notifications')
                <div class="row hide" id="success">
                    <div class="col-sm-12">
                        <div class="alert alert-success alert-dismissable remove-padding">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <strong>Success:</strong> OTP sent successfully
                        </div>
                    </div>
                </div>
                <br/>
                <div class="col-sm-8">
                    <div class="form-group has-feedback has-feedback-left">
                        <input type="text" name="psk_id" id="psk_id" placeholder='{{trans("comman.psk_id")}}' class="form-control" autocomplete="off" value="{{isset($psk_id) ? $psk_id : '' }}" readonly="true">
                        {!! ($errors->has('psk_id') ? $errors->first('psk_id', '<p class="text-danger">:message</p>') : '') !!}
                        <div class="form-control-feedback">
                            <i class="icon-user-check text-muted"></i>
                        </div>
                    </div>
                </div>
            <div class="clearfix"></div>
            @if(isset($GetOtp) && $GetOtp == 'true')
                <div id="otp_id">
                    <div class="col-sm-8">
                        <div class="form-group">
                            <input type="password" name='otp_value' id="otp_value" placeholder='{{trans("comman.otp_enter")}}' class="form-control" maxlength="4" autofocus='true'>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <button type="button" class="btn btn-block btn-info btn-xs resend_value">
                            <i class='fa fa-repeat'></i> {{trans("comman.resend")}}
                        </button>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="form-group col-sm-12">
                    <button type="submit" class="btn bg-indigo-400 btn-block">{{trans("comman.sign_in")}} <i class="icon-circle-right2 position-right"></i></button>
                </div>
            @endif
            <div class="clearfix"></div>
            </form>
        </div>
    </div>
</div>

@stop
@push('scripts')
<!-- custome js -->
<script type="text/javascript">
(function($) {
    jQuery('body').on("click",".resend_value", function (event) {
        resendotp(jQuery('#psk_id').val().trim());
    });
    jQuery("form input").keypress(function (e) {
        if ((e.which && e.which == 13) || (e.keyCode && e.keyCode == 13)) {
            jQuery('button[type=submit]').click();
            return false;
        } else {
            return true;
        }
    });
})(jQuery);
function resendotp(psk_id) {
    var csrf_token = jQuery('#_token').val();
    if(psk_id !== "" && psk_id !== null){
        jQuery.ajax({
            type:"POST",
            url: "@php echo route('ajax.sendotp'); @endphp",
            data:{
                _token : csrf_token,
                psk_id:psk_id,
                resend:'resend'
            },
            success:function(result){
                if(result==='true'){
                    jQuery('#success').removeClass('hide');
                }else{
                    jQuery('#success').addClass('hide');
                }
            }
        });
    }
}
</script>
@endpush