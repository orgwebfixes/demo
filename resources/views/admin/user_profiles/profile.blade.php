@extends($theme)
@section('title', $title)
@section('content')
@section('style')
<style>
    .alert {
        margin-left:0px;
        margin-right:0px;
        margin-top:1%;
    }
    .margin-top{
    	margin-top: 1%;
    }
</style>
@stop
<div class="content-wrapper">
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-white">
				<div class="panel-heading">
					<h6 class="panel-title">Profile information</h6>
				</div>
				<div class="panel-body">
        			{!! Form::model($userData, ['method' => 'POST','url' => route('store.profile'),'class' => 'form-horizontal','autocomplete'=>'off','files'=>'true']) !!}
						<div class="form-group">
							<div class="row">
								<div class="col-md-4 {{ ($errors->has('name')) ? 'has-error' : '' }}">
									{!! Html::decode(Form::label('name',trans("comman.name"). ':<span class="has-stik">*</span>')) !!}
									{!! Form::text('name',$userData->name, ['class' => 'form-control','placeholder' => trans("comman.name"), 'autocomplete' => 'off' ]) !!}
									{!! $errors->first('name', '<p class="help-block">:message</p>') !!}
								</div>
								<div class="col-md-4  {{ ($errors->has('mobile_no')) ? 'has-error' : '' }}">
									{!! Html::decode(Form::label('mobile_no',trans("comman.mobile_no"). ':<span class="has-stik">*</span>')) !!}
									{!! Form::text('mobile_no', null, ['class' => 'form-control','placeholder' => trans("comman.mobile_no"), 'required' => true, 'autocomplete' => 'off']) !!}
									{!! $errors->first('mobile_no', '<p class="help-block">:message</p>') !!}
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<!-- <div class="col-sm-4 {{ $errors->has('address') ? 'has-error' : ''}}">
								                        			{!! Html::decode(Form::label('address', trans("comman.address").':', ['class' => 'control-label'])) !!}
								                        			{!! Form::text('address_line_one', null, ['class' => 'form-control','placeholder' => trans("comman.address_one") ]) !!}
								                        			{!! Form::text('address_line_two', null, ['class' => 'form-control','placeholder' => trans("comman.address_two") ]) !!}
								                        			{!! Form::text('address_line_three', null, ['class' => 'form-control','placeholder' => trans("comman.address_three") ]) !!}
								                        		</div> -->

	                        		<div class="col-sm-4" {{ $errors->has('image') ? 'has-error' : ''}}">
	                        			{!! Html::decode(Form::label('image',trans("comman.upload_image") , ['class' => 'control-label'])) !!}
	                        			<input type="file" class="file-styled" name="image" onchange="readURL(this)" accept='image/*'>
                 					{!! ($errors->has('image') ? $errors->first('image', '<p class="text-danger">:message</p>') : '') !!}
                 					<span class="help-block">Accepted formats: gif, png, jpg. Max file size 2Mb</span>
	                        		</div>
	                        		<div class="col-sm-4">
                                @if(isset($user_image) && !empty($user_image))
                                    {!!Form::hidden('image',$user_image) !!}
					                <a href="/{{AppHelper::size('')->getImageUrl($user_image)}}" data-popup="lightbox">
				                        {{Html::image(AppHelper::path('uploads/user/')->size('100x100')->getImageUrl($user_image),'User Photo',array("class"=>"img-circle",'id'=>'staff','height'=>'100','width'=>'100'))}}
				                    </a>
				                    <a href="/{{AppHelper::size('')->getImageUrl($user_image)}}" download "><i class="fa fa-download"></i></a>
				                @else
				                	{{HTML::image(AppHelper::size('100x100')->getImageUrl(),'User Photo',array("class"=>"img-circle staff",'height'=>'100px','width'=>'100px','id'=>'staff'))}}
				                @endif

			                        </div>

							</div>
						</div>
						<div class="form-group">

	                        </div>

						</div>
				</div>


	<div class="panel panel-white">
        <div class="panel-heading">
            <div class="col-sm-9"><h5 class="panel-title">Account Settings</h5></div>
            @if(Request::get("download",false))
                <div class="pull-right">
                    <button type="button" class="close" ng-click="cancel($event)" aria-label="Close">
                    <span aria-hidden="true" ><i class="icon-cross2"></i></span>
                    </button>
                </div>
            @else
                <div class="heading-elements">

                </div>
            @endif
            <div class="clearfix"></div>
        </div>
    			<div class="panel-body">
					<div class="form-group">
					<div class="form-group">
							<div class="row">
								<div class="col-md-12">
									@if(isset($userData->email) && !empty($userData->email))
										<b>{{trans("comman.email")}}:</b>
										<u>{{$userData->email}}</u>
									@endif
									@if(isset($userData->psk_id) && !empty($userData->psk_id))
										&nbsp;&nbsp;&nbsp;&nbsp;<b>{{trans("comman.psk_idOnly")}}:</b>
										{{$userData->psk_id}}
									@endif
								</div>
	                        	</div>
						</div>
							<div class="row">
								<div class="col-md-4 {{ ($errors->has('current_password')) ? 'has-error' : '' }}">
									{!! Html::decode(Form::label('current_password',trans("comman.current_password"). ':')) !!}
									<input class="form-control" placeholder={{trans("comman.password")}} name="current_password" type="password" autocomplete = "off"/>
									{!! $errors->first('current_password', '<p class="help-block">:message</p>') !!}
								</div>
							</div>
							<div class="row">
								<div class="col-md-4 {{ ($errors->has('password')) ? 'has-error' : '' }}">
									{!! Html::decode(Form::label('new_password',trans("comman.new_password"). ':')) !!}
									<input class="form-control" placeholder={{trans("comman.password")}} name="password" type="password" autocomplete = "false"/>
									{!! $errors->first('password', '<p class="help-block">:message</p>') !!}
								</div>
							</div>
							<div class="row">
								<div class="col-md-4  {{ ($errors->has('password_confirmation')) ? 'has-error' : '' }}">
									{!! Html::decode(Form::label('password_confirmation',trans("comman.password_confirmation"). ':')) !!}
									 <input class="form-control" placeholder={{trans("comman.password")}} name="password_confirmation" type="password" autocomplete = "false"/>
									{!! $errors->first('password_confirmation`', '<p class="help-block">:message</p>') !!}
								</div>
							</div>
							</div>
				</div>
					<div class="col-sm-offset-3 col-sm-4 text-center margin-top">
					                    		<button type="submit" class="btn btn-primary ">{{trans('comman.save') }} </button>
					                    		{!! link_to(URL::full(), trans('comman.cancel'),array('class' => 'btn btn-warning')) !!}
					                    	</div>
										{!! Form::close() !!}
			</div>
			</div>
		</div>
	</div>
</div>
@push('scripts')
<script type="text/javascript">
jQuery('.select-size-sm').select2();
jQuery('.select-size').select2({ width: '200px' });
</script>

<script type="text/javascript">
    function readURL(input){
        $.imageChanger(input,"staff");
    }
    jQuery('.app > .app-content > .box').append('<div class="overlay ajax-overlay"><i class="fa fa-spinner fa-pulse fa-5x fa-fw"></i></div>');
    var $loading = jQuery('.ajax-overlay').hide();
    jQuery(document).ajaxStart(function () {
        $loading.show();
    }).ajaxStop(function () {
        $loading.hide();
    });
</script>
@endpush
{{-- Popup File --}}

@stop

