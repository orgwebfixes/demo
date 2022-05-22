<div class="panel-body">
    <div class="text-center">
            <h5>{{trans("comman.create_account")}}</h5>
    </div>
    <div class="row">
        <div class="col-md-12">
            <fieldset>
                    <legend class="text-semibold text-capitalize"><i class="icon-reading position-left"></i><span style="font-size:16px;">{{trans("comman.user_details")}}</span></legend>
                    <div class="col-sm-2 {{ ($errors->has('surname')) ? 'has-error' : '' }}">
                        <div class="form-group">
                            <label>{{trans("comman.surname")}}:<span class="has-stik">*</span></label>
                            {!! Form::text('surname', null, ['class' => 'form-control input-sm','placeholder' => trans("comman.surname") ]) !!}
                            {!! ($errors->has('surname') ? $errors->first('surname', '<p class="text-danger">:message</p>') : '') !!}
                        </div>
                    </div>
                    <div class="col-sm-2 {{ ($errors->has('name')) ? 'has-error' : '' }}">
                        <div class="form-group">
                            <label>{{trans("comman.name")}}:<span class="has-stik">*</span></label>
                            {!! Form::text('name', null, ['class' => 'form-control','placeholder' => trans("comman.name") ]) !!}
                            {!! ($errors->has('name') ? $errors->first('name', '<p class="text-danger">:message</p>') : '') !!}
                        </div>
                    </div>
                    <div class="col-sm-4 {{ ($errors->has('father_name')) ? 'has-error' : '' }}">
                        <div class="form-group">
                            <label>{{trans("comman.fathername")}}:<span class="has-stik">*</span></label>
                            {!! Form::text('father_name', null, ['class' => 'form-control','placeholder' => trans("comman.fathername") ]) !!}
                            {!! ($errors->has('father_name') ? $errors->first('father_name', '<p class="text-danger">:message</p>') : '') !!}
                        </div>
                    </div>

                    <div class="col-sm-4 {{ ($errors->has('email')) ? 'has-error' : '' }}">
                        <div class="form-group">
                            <label>{{trans("comman.email")}}:<span class="has-stik">*</span></label>
                            {!! Form::text('email', null, ['class' => 'form-control','placeholder' => trans("comman.email") ]) !!}
                            {!! ($errors->has('email') ? $errors->first('email', '<p class="text-danger">:message</p>') : '') !!}
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-sm-4 {{ ($errors->has('password')) ? 'has-error' : '' }}">
                        <div class="form-group">
                            <label>{{trans("comman.password")}}:<span class="has-stik">*</span></label>
                            <input class="form-control" placeholder= {{trans("comman.password")}} name="password" type="password" value="">
                            {!! ($errors->has('password') ? $errors->first('password', '<p class="text-danger">:message</p>') : '') !!}
                        </div>
                    </div>
                    <div class="col-sm-4 {{ ($errors->has('confirm_password')) ? 'has-error' : '' }}">
                        <div class="form-group">
                            <label>{{trans("comman.confirm_password")}}:</label>
                            <input class="form-control" placeholder={{trans("comman.password")}} name="password_confirmation" type="password" />
                            {!! ($errors->has('password_confirmation') ? $errors->first('password_confirmation', '<p class="text-danger">:message</p>') : '') !!}
                        </div>
                    </div>
                    <div class="col-sm-2 mobile_no {{ ($errors->has('mobile_no')) ? 'has-error' : '' }}">
                        <div class="form-group">
                            <label>{{trans("comman.mobile")}}:<span class="has-stik">*</span></label>
                            {!! Form::text('mobile_no', null, ['class' => 'form-control ','placeholder' => trans("comman.mobile"),'data-mask'=>"99999 99999" ]) !!}
                            {!! ($errors->has('mobile_no') ? $errors->first('mobile_no', '<p class="text-danger">:message</p>') : '') !!}
                        </div>
                    </div>
                    <div class="col-sm-2 {{ ($errors->has('birth_date')) ? 'has-error' : '' }}">
                        <div class="form-group">
                            <label>{{trans("comman.birthdate")}}:</label>
                            {!! Form::text('birth_date', null, ['class' => 'form-control datepicker hasDatepicker','placeholder' => '']) !!}
                            {!! ($errors->has('birth_date') ? $errors->first('birth_date', '<p class="text-danger">:message</p>') : '') !!}
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-sm-4 {{ ($errors->has('pincode')) ? 'has-error' : '' }}">
                        <div class="form-group">
                            <label>{{trans("comman.pincode")}}:</label>
                            {!! Form::text('pincode', null, ['class' => 'form-control','placeholder' => trans("comman.pincode") ]) !!}
                            {!! ($errors->has('pincode') ? $errors->first('pincode', '<p class="text-danger">:message</p>') : '') !!}
                        </div>
                    </div>
                    <div class="col-sm-8 {{ ($errors->has('image')) ? 'has-error' : '' }}">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>{{trans("comman.photo")}}:</label>
                                <input type="file" name="image" onchange="readUserURL(this)" accept="image/*" >
                                {!! ($errors->has('image') ? $errors->first('image', '<p class="text-danger">:message</p>') : '') !!}
                            </div>
                        </div>
                        <div class="col-sm-6">
                            {{Html::image(AppHelper::path('uploads/')->size('100x100')->getImageUrl('default.jpg'),'User Photo',array("class"=>"img-circle",'id'=>'user','height'=>'70','width'=>'70'))}}
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <legend class="text-semibold text-capitalize"><i class="icon-truck position-left"></i><span style="font-size:16px;"> {{trans("comman.address_details")}}</span></legend>
                    <div class="col-sm-12 proof">
                        <div class="col-sm-12">
                            <div class="col-sm-4 {{ $errors->has('address') ? 'has-error' : ''}}">
                                {!! Html::decode(Form::label('address', trans("comman.address").':', ['class' => 'control-label'])) !!}
                                {!! Form::text('address_line_one', null, ['class' => 'form-control','placeholder' => trans("comman.address_one") ]) !!}
                                {!! Form::text('address_line_two', null, ['class' => 'form-control','placeholder' => trans("comman.address_two") ]) !!}
                                {!! Form::text('address_line_three', null, ['class' => 'form-control','placeholder' => trans("comman.address_three") ]) !!}
                            </div>
                            <div class="col-sm-4 {{ $errors->has('country_id') ? 'has-error' : ''}}">
                                {!! Form::label('country_id',trans("comman.country").':', ['class' => ' control-label']) !!}
                                {!! Form::select('country_id',array(""=>"")+$countries, null, ['class' => 'select-size-sm','data-placeholder' => trans("comman.select_country")]) !!}
                            </div>
                            <div class="col-sm-4 {{ $errors->has('state_id') ? 'has-error' : ''}}">
                                {!! Form::label('state_id', trans("comman.state").':', ['class' => 'control-label']) !!}
                                {!! Form::select('state_id',array(""=>"")+$states, null, ['class' => 'select-size-sm','data-placeholder' => trans("comman.select_state")]) !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 proof">
                        <div class="col-sm-12">
                            <div class="col-sm-4 {{ $errors->has('district_id') ? 'has-error' : ''}}">
                                {!! Form::label('district_id', trans("comman.district").':', ['class' => 'control-label']) !!}
                                {!! Form::select('district_id', [''=>'']+$district, null, ['class' => 'select-size-sm','data-placeholder' => trans("comman.select_district")]) !!}
                            </div>
                            <div class="col-sm-4 {{ $errors->has('taluka_id') ? 'has-error' : ''}}">
                                {!! Form::label('taluka_id', trans("comman.taluka").':', ['class' => 'control-label']) !!}
                                {!! Form::select('taluka_id', [''=>'']+$taluka, null, ['class' => 'select-size-sm','data-placeholder' => trans("comman.select_taluka")]) !!}
                            </div>
                            <div class="col-sm-4 {{ $errors->has('city_id') ? 'has-error' : ''}}">
                                {!! Html::decode(Form::label('city_id', trans("comman.city"). ':<span class="has-stik">*</span>', ['class' => 'control-label'])) !!}
                                {!! Form::select('city_id', [''=>'']+$city, null, ['class' => 'select-size-sm','data-placeholder' => trans("comman.select_city")]) !!}
                                {!! $errors->first('city_id', '<p class="help-block">:message</p>') !!}
                            </div>
                        </div>
                    </div>

                    <div class="clearfix"></div>
                    <legend class="text-semibold text-capitalize"><i class="fa fa-paperclip position-left"></i><span style="font-size:16px;"> {{trans("comman.proof_attach")}}</span></legend>

                    <div class="col-sm-12 proof">
                        <div class="col-sm-2">
                            <label>{{trans("comman.pancard_no")}}:</label>
                        </div>
                        <div class="col-sm-3">
                            {!! Form::text('pancard_no', null, ['class' => 'form-control','placeholder' => trans("comman.pancard_no"), ]) !!}
                            <span class="label label-default">Ex.ABCDE1234G</span>
                            {!! ($errors->has('pancard_no') ? $errors->first('pancard_no', '<p      class="text-danger">:message</p>') : '') !!}
                        </div>
                        <div class="col-sm-4">
                            <input type="file" class="file-styled" name="pancard_photo" onchange="readPancardURL(this)" accept="image/*">
                            {!! ($errors->has('pancard_photo') ? $errors->first('pancard_photo', '<p class="text-danger">:message</p>') : '') !!}
                        </div>
                        <div class="col-sm-2">
                            {{Html::image(AppHelper::path('uploads/')->size('100x100')->getImageUrl('default.jpg'),'Pancard Photo',array('id'=>'pancard','height'=>'70','width'=>'70'))}}
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-sm-12 proof">
                        <div class="col-sm-2">
                            <label>{{trans("comman.aadhaarcard_no")}}:</label>
                        </div>
                        <div class="col-sm-3">
                            {!! Form::text('aadhar_card_no', null, ['class' => 'form-control','placeholder' => trans("comman.aadhaarcard_no"),'data-mask'=>"9999 9999 9999" ]) !!}
                            {!! ($errors->has('aadhar_card_no') ? $errors->first('aadhar_card_no', '<p class="text-danger">:message</p>') : '') !!}
                        </div>
                        <div class="col-sm-4">
                            <input type="file" class="file-styled" name="aadhar_card_photo" onchange="readAadharURL(this)" accept="image/*">
                            {!! ($errors->has('aadhar_card_photo') ? $errors->first('aadhar_card_photo', '<p class="text-danger">:message</p>') : '') !!}
                        </div>
                        <div class="col-sm-2">
                            {{Html::image(AppHelper::path('uploads/')->size('100x100')->getImageUrl('default.jpg'),'Aadhar Card Photo',array('id'=>'aadhar','height'=>'70','width'=>'70'))}}
                        </div>
                    </div>
                    <div class="col-sm-12 proof">
                        <div class="col-sm-2">
                            <label>{{trans("comman.electioncard_no")}}:</label>
                        </div>
                        <div class="col-sm-3">
                            {!! Form::text('election_card_no', null, ['class' => 'form-control','placeholder' => trans("comman.electioncard_no") ]) !!}
                            {!! ($errors->has('election_card_no') ? $errors->first('election_card_no', '<p class="text-danger">:message</p>') : '') !!}
                        </div>
                        <div class="col-sm-4">
                            <input type="file" class="file-styled" name="election_card_photo" onchange="readElectionURL(this)" accept="image/*">
                            {!! ($errors->has('election_card_photo') ? $errors->first('election_card_photo', '<p class="text-danger">:message</p>') : '') !!}
                        </div>
                        <div class="col-sm-2">
                            {{Html::image(AppHelper::path('uploads/')->size('100x100')->getImageUrl('default.jpg'),'Election Card Photo',array('id'=>'election','height'=>'70','width'=>'70'))}}
                        </div>
                    </div>
                    <div class="col-sm-12 proof">
                        <div class="col-sm-2">
                            <label>{{trans("comman.drivinglicence_no")}}</label>
                        </div>
                        <div class="col-sm-3">
                            {!! Form::text('driving_licence_no', null, ['class' => 'form-control','placeholder' => trans("comman.drivinglicence_no") ]) !!}
                            {!! ($errors->has('driving_licence_no') ? $errors->first('driving_licence_no', '<p class="text-danger">:message</p>') : '') !!}
                        </div>
                        <div class="col-sm-4">
                            <input type="file" class="file-styled" name="driving_licence_photo" onchange="readLicenceURL(this)" accept="image/*">
                            {!! ($errors->has('driving_licence_photo') ? $errors->first('driving_licence_photo', '<p class="text-danger">:message</p>') : '') !!}
                        </div>
                        <div class="col-sm-2">
                            {{Html::image(AppHelper::path('uploads/')->size('100x100')->getImageUrl('default.jpg'),'Driving License Photo',array('id'=>'licence','height'=>'70','width'=>'70'))}}
                        </div>
                    </div>
            </fieldset>
        </div>
    </div>
    <br>
    <div class="clearfix"></div>
    <br>
    @if(!isset($locker))
    <div class="col-lg-12">
        <div class="checkbox">
            <label>
                <input name="approve" type="checkbox" class="styled" value="true">
                <span class="help-block text-center no-margin">By continuing, you're confirming that you've read our <a href="{{route('users.terms')}}" target="_blank">Terms &amp; Conditions</a>
            </label>
            {!! ($errors->has('approve') ? $errors->first('approve', '<p class="text-danger">:message</p>') : '') !!}
        </div>
    </div>
    <div class="clearfix"></div>
    @endif
    <hr>
    @if(isset($locker))
        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-4 text-center">
                {!! Form::submit(trans('comman.save'), ['name' => 'save','class' => 'btn btn-primary']) !!}
                {!! link_to(URL::full(), trans('comman.cancel'),array('class' => 'btn btn-warning')) !!}
            </div>
        </div>
    @else
        <div class="text-right">
            <br>
            <a href="{{route('auth.login.form')}}" class="btn bg-warning-400 btn-labeled btn-labeled-left ml-10"><b><i class="icon-arrow-left13 position-left"></i></b> {{trans("comman.back_to_login")}}</a>

            <button type="submit" class="btn bg-primary-400 btn-labeled btn-labeled-right ml-10"><b><i class="icon-plus3"></i></b>{{trans("comman.create_account")}}</button>
        </div>
    @endif
</div>
@push('scripts')
@parent
<script type="text/javascript">
    function readUserURL(input){
        $.imageChanger(input,"user");
    }
    function readPancardURL(input){
        $.imageChanger(input,"pancard");
    }
    function readAadharURL(input){
        $.imageChanger(input,"aadhar");
    }
    function readElectionURL(input){
        $.imageChanger(input,"election");
    }
    function readLicenceURL(input){
        $.imageChanger(input,"licence");
    }

    //For Clear Country,State,District,Taluka,City
    jQuery('#country_id').on('change',function(){
        jQuery("#state_id").select2("val", "");
    });
    jQuery('#state_id').on('change',function(){
        jQuery("#district_id").select2("val", "");
    });
    jQuery('#district_id').on('change',function(){
        jQuery("#taluka_id").select2("val", "");
    });
    jQuery('#taluka_id').on('change',function(){
        jQuery("#city_id").select2("val", "");
    });

</script>

{!! ajax_fill_dropdown('country_id','state_id',route('register.ajax.allstate')) !!}
{!! ajax_fill_dropdown('state_id','district_id',route('register.ajax.district')) !!}
{!! ajax_fill_dropdown('district_id','taluka_id',route('register.ajax.taluka')) !!}
{!! ajax_fill_dropdown('taluka_id','city_id',route('register.ajax.city')) !!}

@endpush