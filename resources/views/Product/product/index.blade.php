@extends($theme)
@section('title', $title)
@section('content')
<div class="content-wrapper">
    <div class="panel panel-default">
        <div class="panel-heading">
            @if(!empty($title))
            <h5 class="panel-title">{{ $title }}</h5>
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
            <div class="tab-content">
                <div class="tab-pane active" id="active">
                    <table class="table datatable-basic dataTable table-hover no-footer table-bordered table-striped" id="dataTableBuilder">
                        <thead>
                            <tr>
                                <th></th>
                                <th>
                                    <div class="datatable-form-filter">{!! Form::text('filter_name',Request::get('filter_name',null),array('class' => 'form-control')) !!}</div>
                                </th>

                                <th>
                                
                                </th>

                                <th></th>

                                <th></th>
                            </tr>
                            <tr>
                                <th>Category</th>
                                <th>Name</th>
                                <th>SKU</th>
                                <th>Unit Price</th>
                                <th class="action_width">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="show_currency_modal" tabindex="-1" role="dialog">
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
        var info = {
        initialize: function () {
            this.methodLinks = jQuery('body');
            this.registerEvents();
        },
        registerEvents: function () {
            this.methodLinks.on('click', 'a[data-user-show]', this.handleMethod);
        },
        handleMethod: function (e) {
            e.preventDefault();
            var id = jQuery(this).attr("data-user-show");
            var url = "/currency/" + id + "?download=yes";
            jQuery.get(url, function (html) {
                jQuery('#show_currency_modal .modal-content').html(html);
                jQuery('#show_currency_modal').modal('show', {
                    backdrop: 'static'
                });
            });
        }
    };
    info.initialize();

        window.LaravelDataTables = window.LaravelDataTables || {};
        window.LaravelDataTables["dataTableBuilder"] = $("#dataTableBuilder").DataTable({
            "serverSide": true,
            "processing": true,
            "ajax": {
                data: function (d) {
                   d.name = jQuery(".datatable-form-filter input[name='filter_name']").val();
d.sign = jQuery(".datatable-form-filter input[name='filter_sign']").val();
                    d.status = jQuery("#filter_status").val();
                }
            },
            "columns": [
                {
                "name": "category_id",
                "data": "category_id",
                "class": "",
                "searchable": true,
                "orderable": true
            },
            {
                "name": "name",
                "data": "name",
                "class": "",
                "searchable": true,
                "orderable": true
            },
            {
                "name": "sku",
                "data": "sku",
                "class": "",
                "searchable": true,
                "orderable": true
            },
            {
                "name": "price",
                "data": "price",
                "class": "",
                "searchable": true,
                "orderable": true
            },

        {
            "name": "action",
            "data": "action",
            "class": "",
            "render": null,
            "searchable": false,
            "orderable": false,
            "width": "80px"
        },
],
            "searching": false,
            dom: "<\"wrapper\"B>frtilp",
            "buttons": [],
            "pageLength": 50,
            "order": [[0,'desc']]
        });
    })(window, jQuery);
     jQuery('.datatable-form-filter input').on('keyup', function (e) {
        window.LaravelDataTables["dataTableBuilder"].draw();
        e.preventDefault();
    });
     jQuery('.datatable-form-filter select').on('change', function (e) {
        window.LaravelDataTables["dataTableBuilder"].draw();
        e.preventDefault();
    });
    jQuery('.dataTables_length select').select2({
        minimumResultsForSearch: Infinity,
        width: '75px'
    });
</script>
@endpush