@section('style')
<style>
    .font-limit {
        font-size: 14px;
    }
    legend.module{
        margin-bottom: 5px;
    }
    .permission_display{
        /*width:270px;*/
        width: 100%;
        float: left;
        padding: 0;
        margin: 1px;
        border: 1px solid #f39c12;
    }
    .permission_title:hover{
        cursor:pointer;
    }
    .permission_title{
        font-size:15px;
        /*width: 155px;*/
        display: inline-block;
        min-height: 20px;
        vertical-align: top;
        padding-top: 7px;
    }
    legend.module{
        margin-bottom: 5px;
    }
    .all_lbl{
        font-size: 14px !important;
        width:8%;
        float:left;
        position: relative;
        padding: 0px;
        margin:0px;
        margin-top:7px;
    }
    .all_per_div{
        float:left;
        position: relative;
        min-height: 1px;
        margin-left:5px;
        font-size: 14px;
    }
    .all_permission{
        display:inline-block;
    }
    .sub_title{
        float: left;
        margin: 0;
        padding: 0 0 0 14px;
        /*width: 160px;*/
        text-transform: capitalize;
    }
    .sub_radio{
        float: left;
        margin: 4px;
        padding: 0;
        width: auto;
    }
    .sub_radio label{
        width: 100%;
        font-weight: normal;
        margin: 0;
        padding: 0;
    }
    .checker, .checker span, .checker input {
        margin-right: 10px;
    }
    .fa.pull-right {
        margin-left: .3em;
        font-size: 14px;
    }
    .display_none{ display:none; }
</style>
@stop
<div class="form-group {{ ($errors->has('name')) ? 'has-error' : '' }}">
    {!! Html::decode(Form::label('name', trans("comman.name"). ':<span class="has-stik">*</span>', ['class' => 'col-lg-1 control-label'])) !!}
    <div class="col-lg-9">
        @if(Request::old('name'))
            @php $name=Request::old('name'); @endphp
        @elseif(Request::old())
            @php $name=''; @endphp
        @elseif(isset($role->name)&&($role->name!=""))
            @php $name=$role->name; @endphp
        @else
            @php $name=''; @endphp
        @endif
        <input class="form-control text-capitalize" placeholder={{trans("comman.name")}} name="name" id="name" type="text" value="{{ $name }}" autofocus='true' required="required" autocomplete="off" />
        {!! ($errors->has('name') ? $errors->first('name', '<p class="text-danger">:message</p>') : '') !!}
    </div>
</div>
<div class="form-group {{ ($errors->has('slug')) ? 'has-error' : '' }}">
    {!! Html::decode(Form::label('slug', trans("comman.slugname"). ':<span class="has-stik">*</span>', ['class' => 'col-lg-1 control-label'])) !!}
    <div class="col-lg-9">
        @if(Request::old('slug'))
            @php $slug=Request::old('slug'); @endphp
        @elseif(Request::old())
            @php $slug=''; @endphp
        @elseif(isset($role->slug)&&($role->slug!=""))
            @php $slug=$role->slug; @endphp
        @else
            @php $slug=''; @endphp
        @endif
        <input class="form-control" placeholder={{trans("comman.slug")}} name="slug" id="slug" type="text" value="{{ $slug }}" readonly="true" required="required" />
        {!! ($errors->has('slug') ? $errors->first('slug', '<p class="text-danger">:message</p>') : '') !!}
    </div>
</div>
<hr/>
<h5>Permissions</h5>
@php
    $flag_row = 0;
    //for view 4 permissions in single row
    $tmp = 1;
    //Tmp variable for all Permission
@endphp
<div class="row">
@foreach ($all_permission as $area => $permissions)
    @php $flag_row++; @endphp
    <div class="col-md-4">
        <div class="permission_display">
            <span data-id="{{str_replace(array('.',' ','/'), '_', $area)}}" class="col-md-9 permission_title text-capitalize">{{str_replace('_', ' ', $area)}}
            <i class="fa fa-chevron-circle-down fa-2x pull-right"></i>
            </span>

            <div class="all_permission parent_permission ">
                {{-- Check In All permission Allow/Deny Selected or not Start--}}
                @if(isset($groupPermissions))
                @php $allow = $deny = $counter = 0; @endphp
                    @foreach ($permissions as $permission)
                        @php $counter++; @endphp
                        @if(array_get($groupPermissions,$permission['permission']))
                            @php $allow++; @endphp
                        @endif
                        @if(array_get($groupPermissions,$permission['permission']))
                            @php $deny++; @endphp
                        @endif
                    @endforeach
                @endif
                {{--  Check In All permission Allow/Deny Selected or not End --}}
                 <div class="checkbox all_per_div">
                    <label for="{{ $area }}_allow" onclick="" class="font-limit">
                        <input type="checkbox" value="1" id="{{ $area }}_allow" name="grp[{{$tmp}}]" data-allow="{{$tmp}}_alw" class="allow all parent_alw styled" {{isset($groupPermissions) ? ($counter === $allow ? ' checked="checked"' : ''):'' }}>
                        &nbsp;Allow
                    </label>
                </div>
                <!-- <div class="radio all_per_div">
                   <label for="{{ $area }}_deny" onclick="" class="font-limit">
                        <input type="radio" value="-1" name="grp[{{$tmp}}]" id="{{ $area }}_deny" data-deny="{{$tmp}}_dny" class="deny all parent_dny" {{isset($groupPermissions)?($counter === $deny ? ' checked="checked"' : ''):'' }}>
                        Deny
                    </label>
                </div>  -->
            </div>
            <div id="sub_{{str_replace(array('.',' ','/'), '_', $area)}}" class="display_none" class="sub_permission">
                @foreach ($permissions as $keyname=>$permission)
                <label class="sub_title col-md-8">{{str_replace('_',' ',$permission['label'])}}</label>
                <div class="sub_radio chec">
                    {{Form::hidden("permissions[".$permission['permission']."]","0")}}
                    <label for="{{ $permission['permission']}}_allow">
                        <input type="checkbox" value="1" id="{{ $permission['permission']}}_allow" class="{{$tmp}}_alw child_alw styled" name="permissions[{{ $permission['permission']}}]" {{ isset($groupPermissions) ? (array_get($groupPermissions,$permission['permission']) ? ' checked="checked"' : ''):'' }} />
                               Allow

                    </label>
                </div>
                <!-- <div class="sub_radio">
                    <label for="{{ $permission['permission']}}_deny">
                        <input type="radio" value="0" id="{{ $permission['permission']}}_deny" class="{{$tmp}}_dny child_dny" name="permissions[{{ $permission['permission']}}]" {{ isset($groupPermissions)?( ! array_get($groupPermissions,$permission['permission']) ? ' checked="checked"' : ''):' checked="checked"' }} />
                               Deny
                    </label>
                </div> -->
                <div class="clearfix"></div>
                @endforeach
            </div>
        </div>
    </div>
        @if($flag_row % 3 == 0)
            </div><div class="row">
        @endif
    @php $tmp++; @endphp
@endforeach
</div>
<div class="clearfix"></div><br/>

@push('scripts')
<script type="text/javascript">
    jQuery(".select2").select2();

    // For all Permission Jquery - Start
    jQuery(".allow").on('change', function () {
        var attribute = jQuery(this).attr('data-allow');
        var classname = "." + attribute;
        if(jQuery(this).is(':checked')){
            jQuery(classname).each(function () {
                id = jQuery(this).prop('id');
                jQuery(this).prop('checked', true);
                jQuery(this).parent().addClass('checked');
                //jQuery(this).trigger("click");
            });
        }else{
            jQuery(classname).each(function () {
                jQuery(this).prop('checked', false);
                jQuery(this).parent().removeClass('checked');
                //jQuery(this).trigger("click");
            });

        }
    });
    jQuery(".deny").on('change', function () {
        var attribute = jQuery(this).attr('data-deny');
        var classname = "." + attribute;
        jQuery(classname).each(function () {
            jQuery(this).prop('checked', true);

        });
    });

    // For deselect when any on is not selected - Start
    jQuery('.child_alw').on('click', function () {
        var total_checkbox = jQuery(this).parents('.sub_permission').find(':input.child_alw').length;
        var selected_checkbox = jQuery(this).parents('.sub_permission').find(':input:checked.child_alw').length
        if (total_checkbox == selected_checkbox) {
            jQuery(this).parents('.permission_display').find('.all_per_div :input.parent_alw').prop('checked', true);
            jQuery(this).parents('.permission_display').find('.all_per_div :input.parent_alw').parent().addClass("checked");
        }
        else {
            jQuery(this).parents('.permission_display').find('.all_per_div :input.parent_alw').prop('checked', false);
            jQuery(this).parents('.permission_display').find('.all_per_div :input.parent_alw').parent().removeClass("checked");
        }
    });
    jQuery('.child_dny').on('click', function () {
        var total_checkbox = jQuery(this).parents('.sub_permission').find(':input.child_dny').length;
        var selected_checkbox = jQuery(this).parents('.sub_permission').find(':input:checked.child_dny').length
        if (total_checkbox == selected_checkbox) {
            jQuery(this).parents('.permission_display').find('.all_per_div :input.parent_dny').prop('checked', true);
        }
        else {
            jQuery(this).parents('.permission_display').find('.all_per_div :input.parent_alw').prop('checked', false);
        }
    });
    // For deselect when any on is not selected - End


    /* Sub Permission toggle Code Start */
    jQuery('.permission_title').on('click', function () {
        var data_id = jQuery(this).attr('data-id');
        // jQuery(".sub_permission").css("height","124px");
        if(jQuery('#sub_' + data_id).is(":hidden"))
        {
            jQuery(this).find("i").removeClass("fa-chevron-circle-down");
            jQuery(this).find("i").addClass("fa-chevron-circle-up");
        }else{
            jQuery(this).find("i").addClass("fa-chevron-circle-down");
            jQuery(this).find("i").removeClass("fa-chevron-circle-up");

        }
        jQuery(document).find('#sub_' + data_id).slideToggle("slow", "linear");

    });
    checkForPermission();
    function checkForPermission() {
        var parent_element = jQuery('.permission_display');
        parent_element.each(function (moudle_key, module_element) {
            jQuery(module_element).find('.child_alw').each(function (input_key, input_ele) {
                if(jQuery(input_ele). prop("checked") == true){
                    jQuery(module_element).find('.all_permission .parent_alw').prop('checked', true);
                }
            });
        });
    }
</script>
@endpush