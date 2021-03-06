@extends($theme)
@section('title', $title)

@section('content')
<div class="content-wrapper">
    <div class="panel panel-white">
        <div class="panel-heading">
            <h6>Edit {{ $title }}</h6>
            <div class="heading-elements">
                    @if(!empty($module_action))
                        @foreach($module_action as $key=>$action)
                        {!! Html::decode(Html::link($action['url'],$action['title'],$action['attributes'])) !!}
                        @endforeach
                    @endif
            </div>
        </div>
        <div class="panel-body">

            {!! Form::model($currency, ['method' => 'PATCH','route' => ['currency.update', $currency->id],'class' => 'form-horizontal']) !!}

            @include('Currency.currency.form')
            <div class="col-md-10 text-center">
                    {!! Form::submit(trans('comman.save'), ['name' => 'save','class' => 'btn btn-primary']) !!}
                    {!! Form::submit(trans('comman.save_exit'), ['name' => 'save_exit','class' => 'btn btn-primary']) !!}
                    {!! link_to(URL::full(), trans('comman.cancel'),array('class' => 'btn btn-warning')) !!}
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection