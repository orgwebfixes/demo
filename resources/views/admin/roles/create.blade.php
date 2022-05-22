@extends($theme)

@section('title', $title)

@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-white">
                <div class="panel-heading">
                    <h5 class="panel-title">Add Role</h5>
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
                </div>
                <div class="panel-body">
                    {!! Form::open(array('route' => 'roles.store','class'=>'form-horizontal','role'=>"form",'method'=>'post')) !!}
                        <input name="_token" value="{{ csrf_token() }}" type="hidden">
                        @include('admin.roles.form')
                        <div class="panel-footer clearfix">   
                            <div class="col-md-6 text-center">
                                {!! Form::submit("Save", ['name'=>'save','class' => 'btn btn-primary']) !!}
                                {!! Form::submit("Save & Exit", ['name'=>'save_exit','class' => 'btn btn-primary']) !!}
                                {!! link_to(URL::full(), "Cancel",array('class' => 'btn btn-warning')) !!}
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@stop