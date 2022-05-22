@extends($theme)
@section('title', $title)
@section('style')
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
            <table class="table datatable-basic dataTable no-footer table-hover table-bordered table-striped" id="dataTableBuilder">
                <thead>
                    <tr>
                        <th class="th_width">
                                    <div class="col-sm-12 datatable-form-filter">{!! Form::text('filter_name',Request::get('filter_name',null),array('class' => 'form-control custom_width')) !!}</div>
                                    </th>
                                    <th class="th_width">
                                    <div class="col-sm-12 datatable-form-filter">{!! Form::text('filter_slug',Request::get('filter_slug',null),array('class' => 'form-control custom_width')) !!}</div>
                                    </th>
                                    <th>
                    
                    </th>
                                    <th></th>
                                    </tr>
                <tr>
                    <th>Name</th>
                    <th class="hide"></th>
                    <th>Slug</th>
                    <th>Users</th>
                    <th class="action_width">Action</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
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
    var name='{{trans("comman.name")}}';
    var slug='{{trans("comman.slug")}}';
    var users='{{trans("comman.users")}}';
    var action='{{trans("comman.action")}}';
    (function(window, $) {
        window.LaravelDataTables = window.LaravelDataTables || {};
        window.LaravelDataTables["dataTableBuilder"] = $("#dataTableBuilder").DataTable({
            "serverSide": true,
            "processing": true,
            "ajax": {
                data: function (d) {
                    d.name = jQuery(".datatable-form-filter input[name='filter_name']").val();
                    d.slug = jQuery(".datatable-form-filter input[name='filter_slug']").val();
                    d.users = jQuery(".datatable-form-filter input[name='filter_users']").val();
                }
            },
            "columns": [{
                "name": "name",
                "data": "name",
                "title": name,
                "orderable": true,
                "searchable": false
            },{
               "name": "updated_at",
                "data": "updated_at",
                "title": 'updated_at',
                "class": "hide"
            }, {
                "name": "slug",
                "data": "slug",
                "title": slug,
                "orderable": true,
                "searchable": false
            }, {
                "name": "users",
                "data": "users",
                "title": users,
                "orderable": false,
                "searchable": false
            }, {
                "name": "action",
                "data": "action",
                "title": action,
                "render": null,
                "orderable": false,
                "searchable": false,
                "width": "80px"
            }],
            "searching": false,
           "dom": "<\"wrapper\"B>frtilp",
            "buttons": [],
            "pageLength": 50,
            "order": [[0,'asc']]
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