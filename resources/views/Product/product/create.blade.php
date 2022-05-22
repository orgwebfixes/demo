@extends($theme)
@section('title', $title)

@section('content')
<div class="content-wrapper">
    <div class="panel panel-white">
        <div class="panel-heading">
            <div class="col-sm-9"><h5 class="panel-title">Add New {{ $title }}</h5></div>
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
        {!! Form::open(array('route' => 'product.store','class'=>'form-horizontal','files'=>true,'role'=>"form")) !!}

        @include('Product.product.form')

        <div class="col-md-10 text-center">
                {!! Form::submit(trans('comman.save'), ['name' => 'save','class' => 'btn btn-primary']) !!}
                @if(!Request::get("download",false))
                    {!! Form::submit(trans('comman.save_exit'), ['name' => 'save_exit','class' => 'btn btn-primary']) !!}
                @endif
                {!! link_to(URL::full(), trans('comman.cancel'),array('class' => 'btn btn-warning cancel')) !!}
        </div>
        {!! Form::close() !!}
</div>
    </div>
</div>
@endsection