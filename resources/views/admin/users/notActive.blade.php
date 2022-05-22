@extends($theme)

@section('title', $title)
@section('style')
<style>
    .name {
        width: 200px;
    }
    .mobile {
        width: 100px;
        font-size: 12px;
    }
    .small {
        width:110px;
    }
    .panel-heading {
        padding: 8px 20px;
        border-bottom: 1px solid transparent;
        border-top-right-radius: 2px;
        border-top-left-radius: 2px;
    }
    .panel-body {
        padding: 15px;
        padding-top: 5px;
    }
    .nav-tabs {
        margin-bottom: 0px;
    }
</style>
@stop
@section('content')
<div class="content-wrapper">
    <div class="panel panel-default">
        <div class="panel-heading">
            @if(!empty($title))
                <h5 class="panel-title">{{ $title }}</h5>
                @if(!empty($module_sub_title))
                    | {{ $module_sub_title }}
                @endif
                @if(!empty($module_help))
                    | {{ $module_help }}
                @endif
            @endif
            <div class="heading-elements">
                @if(!empty($module_action))
                    @foreach($module_action as $key=>$action)
                        {!! Html::decode(Html::link($action['url'],$action['title'],$action['attributes'])) !!}
                    @endforeach
                @endif
            </div>
        </div>
        <div class="panel-body">
             <div class="tabbable">
                <ul class="nav nav-tabs bg-slate nav-tabs-component">
                    <li >{!! Html::linkRoute('users.index',trans('comman.Active')); !!}</li>
                    <li class="active">{!! Html::linkRoute('users.notActive',trans('comman.NoActive')); !!}</li>
                </ul>
            </div>
            <div class="tab-content">
                <div class="tab-pane active" id="active">
                    <table class="table datatable-basic dataTable no-footer table-hover table-bordered table-striped" id="dataTableBuilder">
                        <thead>
                            <tr>
                                <th></th>
                                <th>
                        <div class="col-sm-4 datatable-form-filter">{!! Form::text('filter_id',Request::get('filter_id',null),array('class' => 'form-control name')) !!}</div>
                        </th>
                        <th>
                        <div class="col-sm-4 datatable-form-filter">{!! Form::text('filter_email',Request::get('filter_email',null),array('class' => 'form-control name')) !!}</div>
                        </th>
                        <th>
                        <div class="col-sm-4 datatable-form-filter">{!! Form::text('filter_role',Request::get('filter_role',null),array('class' => 'form-control small')) !!}</div>
                        </th>
                        <th></th>
                        </tr>
                        <tr>
                            <th>Image</th>
                            <th>Name</th>
                            <th>E-mail</th>
                            <th>Role</th>
                            <th style="width: 80px;">Action</th>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="show_user_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog model-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h6 class="modal-title">{{trans("comman.user_info")}}</h6>
                <div class="pull-right">
                    <button type="button" class="close" ng-click="cancel($event)" aria-label="Close">
                        <span aria-hidden="true" ><i class="icon-cross2"></i></span>
                    </button>
                </div>
            </div>
            <div class="modal-body">
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<link rel="stylesheet" href='{{ asset("themes/limitless/css/buttons.dataTables.min.css")}}'/>
<script src='{{ asset("themes/limitless/js/dataTables.buttons.min.js")}}'></script>
<script src="/vendor/datatables/buttons.server-side.js"></script>
<script type="text/javascript">
    (function(window, $) {
        window.LaravelDataTables = window.LaravelDataTables || {};
        window.LaravelDataTables["dataTableBuilder"] = $("#dataTableBuilder").DataTable({
            "serverSide": true,
            "processing": true,
            "ajax": {
                data: function (d) {
                    d.id = jQuery(".datatable-form-filter input[name='filter_id']").val();
                    d.role = jQuery(".datatable-form-filter input[name='filter_role']").val();
                    d.email = jQuery(".datatable-form-filter input[name='filter_email']").val();
                }
            },
            "columns": [{
                "name": "image",
                "data": "image",
                "title": "Preview",
                "render": null,
                "searchable": false,
                "orderable": false
            }, {
                "name": "id",
                "data": "id",
                "title": "Name",
                "orderable": true,
                "searchable": false
            }, {
                "name": "email",
                "data": "email",
                "title": "E-mail",
                "orderable": true,
                "searchable": false
            },{
                "name": "role",
                "data": "role",
                "title": "Role",
                "orderable": true,
                "searchable": false
            },{
                "name": "action",
                "data": "action",
                "title": "Action",
                "render": null,
                "orderable": false,
                "searchable": false,
                "width": "80px"
            }],
            "searching": false,
            "dom": "<\"wrapper\"B>frtilp",
            "buttons": [],
            "drawCallback": function() {
                jQuery(this).find("tbody tr").slice(-3).find(".dropdown, .btn-group").addClass("dropup");
            },
            "preDrawCallback": function() {
                jQuery(this).find("tbody tr").slice(-3).find(".dropdown, .btn-group").removeClass("dropup");
            },
            "order": [
                [1, "desc"]
            ]
        });
    })(window, jQuery);
    jQuery('.datatable-form-filter input').on('keyup', function (e) {
        window.LaravelDataTables["dataTableBuilder"].draw();
        e.preventDefault();
    });
    jQuery('.dataTables_length select').select2({
        minimumResultsForSearch: Infinity,
        width: '75px'
    });
</script>
@endpush

