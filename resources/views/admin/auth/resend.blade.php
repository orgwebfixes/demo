@extends($theme)

@section('title', 'Resend Activation Instructions')

@section('content')
<div class="row">
    <div class="col-md-4 col-md-offset-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">{{trans("comman.resend_activation")}}</h3>
            </div>
            <div class="panel-body">
                <form accept-charset="UTF-8" role="form" method="post" action="{{ route('auth.activation.resend') }}">
                    <fieldset>
                        <div class="form-group {{ ($errors->has('email')) ? 'has-error' : '' }}">
                            <input class="form-control" placeholder={{trans("comman.email")}} name="email" type="text" value="{{ old('email') }}">
                            {!! ($errors->has('email') ? $errors->first('email', '<p class="text-danger">:message</p>') : '') !!}
                        </div>
                        <input name="_token" value="{{ csrf_token() }}" type="hidden">
                        <input class="btn btn-lg btn-primary btn-block" type="submit" value=trans("comman.save")>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>
@stop