@section('style')
<style>
    .padding_left {padding-left: 208px;}
    .vertical_middle{ vertical-align:middle; }
    .margin_left{ margin-left: 20px; }
    .pl-0{
        padding-left: 0px!important;
    }
    .m-t-30{margin-top: 30px;}
</style>
@stop
<div class="col-lg-12">
    <div class="col-lg-6">
        <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
            {!! Html::decode(Form::label('name', 'Name:<span class="has-stik">*</span>', ['class' => 'col-sm-2 control-label '])) !!}
            <div class="col-sm-8">
                {!! Form::text('name', null, ['class' => 'form-control','placeholder'=>'Name', 'required' => true, 'autocomplete' => 'off']) !!}
                {!! ($errors->has('name') ? $errors->first('name', '<p class="text-danger">:message</p>') : '') !!}
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="form-group {{ $errors->has('email') ? 'has-error' : ''}}">
            {!! Html::decode(Form::label('email', 'E-Mail:<span class="has-stik">*</span>', ['class' => 'col-sm-2 control-label '])) !!}
            <div class="col-sm-8">
                {!! Form::text('email', null, ['class' => 'form-control','placeholder'=>"E-Mail address", 'required' => true, 'autocomplete' => 'off']) !!}
                {!! ($errors->has('email') ? $errors->first('email', '<p class="text-danger">:message</p>') : '') !!}
            </div>
        </div>
    </div>
</div>
<div class="col-lg-12">
  <div class="col-lg-6">
        <div class="form-group {{ ($errors->has('password')) ? 'has-error' : '' }}">
            {!! Html::decode(Form::label('password', trans("comman.password"). ':', ['class' => 'col-sm-2 control-label '])) !!}
            <div class="col-lg-8">
                <input class="form-control" placeholder="Password" name="password" type="password" value="" id="password"  autocomplete="off">
                {!! ($errors->has('password') ? $errors->first('password', '<p class="text-danger">:message</p>') : '') !!}
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="form-group {{ ($errors->has('password_confirmation')) ? 'has-error' : '' }}">
            {!! Html::decode(Form::label('password_confirmation', trans("comman.confirm_password"). ':', ['class' => 'col-sm-2 control-label '])) !!}
            <div class="col-lg-8">
                <input class="form-control" placeholder="Password" name="password_confirmation" type="password" value="" id="password_confirmation" autocomplete="off">
                {!! ($errors->has('password_confirmation') ? $errors->first('password_confirmation', '<p class="text-danger">:message</p>') : '') !!}
            </div>
        </div>
    </div>
</div>
<div class="col-lg-12">
    <div class="col-lg-6">
        <div class="form-group {{ ($errors->has('mobile_no')) ? 'has-error' : '' }}">
            {!! Html::decode(Form::label('mobile_no', trans("comman.mobile_no"). ':<span class="has-stik">*</span>', ['class' => 'col-sm-2 control-label '])) !!}
            <div class="col-lg-8">
                {!! Form::text('mobile_no', null, ['class' => 'form-control','placeholder'=>'Mobile No', 'required' => true, 'pattern' => "[6-9]{1}[0-9]{9}", 'title' => 'Please enter valid Mobile Number i.e. 9000000000', 'autocomplete' => 'off']) !!}
                {!! ($errors->has('mobile_no') ? $errors->first('mobile_no', '<p class="text-danger">:message</p>') : '') !!}
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="form-group {{ ($errors->has('password_confirmation')) ? 'has-error' : '' }}">
            {!! Html::decode(Form::label('activation', trans("comman.activation"). ':', ['class' => 'col-sm-2 control-label '])) !!}
            <div class="col-lg-8">
                 <div class="checkbox">
                    <label>
                    @if(Request::old('activate'))
                        @php $flag='checked'; @endphp
                    @elseif(Request::old())
                        @php $flag=''; @endphp
                    @elseif(isset($activate)&&($activate=="1"))
                        @php $flag='checked'; @endphp
                    @else
                        @php $flag=''; @endphp
                    @endif
                    <input name="activate" type="checkbox" class="styled" value="true" {{ $flag }} />
                    </label>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="clearfix"></div>
<hr />
<div class="col-lg-12">
    <div class="col-lg-3">
        <div class="form-group {{ $errors->has('roles') ? 'has-error' : ''}}">
            <h5>Roles <span class='has-stik'>*</span></h5>
            @foreach ($roles as $role)
            <div class="radio">
                <label>
                    @if(Request::old('roles') && Request::old('roles')==$role->id)
                        @php $flag='checked'; @endphp
                    @elseif(isset($user) && $user->inRole($role) && !Request::old('roles'))
                        @php $flag='checked'; @endphp
                    @else
                        @php $flag=''; @endphp
                    @endif
                    <input type="radio" name="roles" value="{{ $role->id }}" {{ $flag }} required="required" />
                    {{ $role->name }}
                </label>
            </div>
            @endforeach
            {!! ($errors->has('roles') ? $errors->first('roles', '<p class="text-danger">:message</p>') : '') !!}
        </div>
    </div>
    @if(!Request::get("download",false))
        <div class="col-lg-7">
            <div class="form-group border-bottom-none {{ $errors->has('image') ? 'error' : '' }}">
                <h5>Photo</h5>
                <div class="col-lg-4 pl-0 m-t-30">
                    <div class="controls col-sm-5 vertical_middle pl-0">
                        <input type="file" name="image" onchange="readUserURL(this)" accept="image/*">
                        {!! ($errors->has('image') ? $errors->first('image', '<p class="text-danger">:message</p>') : '') !!}
                    </div>
                </div>
                <div class="col-lg-4">
                    @if(isset($user->image) && !empty($user->image))
                        <a href="/{{AppHelper::size('')->getImageUrl($user->image)}}" data-popup="lightbox">
                            {{Html::image(AppHelper::path('uploads/user/')->size('100x100')->getImageUrl($user->image),'User Photo',array("class"=>"img-circle",'id'=>'staff','height'=>'100','width'=>'100'))}}
                        </a>
                        <a href="/{{AppHelper::size('')->getImageUrl($user->image)}}" download class="margin_left"><i class="fa fa-download"></i></a>
                    @else
                        {{Html::image(AppHelper::size('100x100')->getImageUrl(),'User Photo',array("class"=>"img-circle staff",'id'=>'staff','height'=>'100','width'=>'100'))}}
                    @endif
                </div>
            </div>
        </div>
    @endif
</div>
<div class="clearfix"></div>
<div class="col-lg-12 hide">
    <div class="col-sm-2">
        <button type="button" class="btn btn-info btn-xs getOTP">
            <i class='fa fa-paper-plane'></i> {{trans("comman.get_otp")}}
        </button>
    </div>
    <div id="otp_id" class="hide">
        <div class="col-sm-2">
            <input type="password" id="enter_otp" placeholder='{{trans("comman.otp_enter")}}' maxlength="4" class="form-control" name="enter_otp" autocomplete="off">
        </div>
        <div class="col-sm-2">
            <button type="button" class="btn btn-info btn-xs resend_value">
                <i class='fa fa-repeat'></i> Resend
            </button>
        </div>
    </div>
    <div class="clearfix"></div>
    {!! ($errors->has('enter_otp') ? $errors->first('enter_otp', '<p class="text-danger">:message</p>') : '') !!}
    <div class="clearfix"></div>
</div>
<br>
<div class="notified hide"></div>