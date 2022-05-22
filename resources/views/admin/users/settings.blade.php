@extends($theme)
@section('title', $title)
@section('content')
<div class="row">
{{-- {{ dump(Config::get('srtpl.settings')) }} --}}
{{-- {{ dump(head(json_decode(json_encode(DB::select("SELECT @@@system_time_zone")), true))['@@@system_time_zone']) }} --}}
    <style>
        .panel.programs-list
        {
            border: 0px;
        }
        .programs-list .list-group
        {
            padding: 0px 5px;
        }
        .fa-blue { color: #3D92F3; }
    </style>

    {!! Form::model($settings, ['route' => ['settingsStore'],'class' => 'form-horizontal']) !!}
    <div class="col-md-12">
       <div class="panel panel-white">
            <div class="panel-heading">
                <h4 class="panel-title">Settings Tool</h4>
                <div class="clearfix"></div>
            </div>
            <div class="panel-body">
                <div class="form-group {{ $errors->has('project_title') ? 'has-error' : ''}}">
                    {!! Html::decode(Form::label('project_title', 'Site Name'. ':<span class="has-stik">*</span>', ['class' => 'col-sm-3 control-label'])) !!}
                    <div class="col-sm-4">
                        {!! Form::text('project_title', null, ['class' => 'form-control','placeholder' => 'Site Name' ]) !!}
                        {!! $errors->first('project_title', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>
                <div class="form-group {{ $errors->has('company_name') ? 'has-error' : ''}}">
                    {!! Html::decode(Form::label('company_name', 'Site Url'. ':', ['class' => 'col-sm-3 control-label'])) !!}
                    <div class="col-sm-4">
                        {!! Form::text('company_name', url('/'), ['class' => 'form-control','placeholder' => 'Site Url','readonly' => true ]) !!}
                        {!! $errors->first('company_name', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>
                <div class="form-group {{ $errors->has('site_copyright') ? 'has-error' : ''}}">
                    {!! Html::decode(Form::label('site_copyright', 'Copyright:<span class="has-stik">*</span>', ['class' => 'col-sm-3 control-label'])) !!}
                    <div class="col-sm-4">
                        {!! Form::text('site_copyright', null, ['class' => 'form-control','placeholder' => 'Copyright', 'required' => 'true' ]) !!}
                        {!! $errors->first('site_copyright', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>
                <div class="panel-heading">
                    <div class="form-group">
                        <div class="col-sm-5 text-right">
                            {!! Form::submit("Update", ['name' => 'save','class' => 'btn btn-primary']) !!}
                            {!! link_to(URL::full(), "Cancel",array('class' => 'btn btn-warning cancel')) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
</div>
@endsection
@push('scripts')
<script>
    $(".clickable.panel-heading").on('click', function () {
        var icon = $(this).find('.fa-blue');
        if(icon.hasClass('icon-circle-down2')) {
            icon.removeClass('icon-circle-down2');
            icon.addClass('icon-circle-up2');
        } else {
            icon.addClass('icon-circle-down2');
            icon.removeClass('icon-circle-up2');
        }

    });

</script>
@endpush