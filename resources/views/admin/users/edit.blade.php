@extends($theme)
@section('title', $title)
<style type="text/css">
    div.panel-body > div.proof{
        padding-bottom:10px;
    }
</style>
@section('content')
<div class="content-wrapper">
    <div class="panel panel-white">
        <div class="panel-heading">
            <div class="col-sm-9"><h5 class="panel-title">Edit User</h5></div>
            @if(Request::get("download",false))
                <div class="pull-right">
                    <button type="button" class="close" ng-click="cancel($event)" aria-label="Close">
                    <span aria-hidden="true" ><i class="icon-cross2"></i></span>
                    </button>
                </div>
            @else
                <div class="heading-elements">
                    @if(!empty($module_action))
                        @foreach($module_action as $key=>$action)
                        {!! Html::decode(Html::link($action['url'],$action['title'],$action['attributes'])) !!}
                        @endforeach
                    @endif
                </div>
            @endif
            <div class="clearfix"></div>
        </div>
        <div class="panel-body">
            {!! Form::model($user, ['method' => 'PATCH','route' => ['users.update', $user->id],'class' => 'form-horizontal','files'=>'true']) !!}
                @include('admin.users.form')
            <br/>
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-4 text-center">
                    {!! Form::submit(trans('comman.save'), ['name' => 'save','class' => 'btn btn-primary']) !!}
                    {!! Form::submit(trans('comman.save_exit'), ['name' => 'save_exit','class' => 'btn btn-primary']) !!}
                    {!! link_to(URL::full(), trans('comman.cancel'),array('class' => 'btn btn-warning')) !!}
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@push('scripts')
<script type="text/javascript">
    jQuery('.select-size-sm').select2();
    jQuery('.select-size').select2({ width: '200px' });
    function readUserURL(input){
        $.imageChanger(input,"staff");
    }    
</script>
@endpush
{{-- Popup File --}}
@include('admin.users.popup')
@endsection