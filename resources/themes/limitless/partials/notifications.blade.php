<style type="text/css">
.alert{
    margin-left: 0px;
    margin-right: 0px;
    margin-top: 1%;
}
</style>
{{--
 --@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif--}}
@if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissable ">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <strong>Success:</strong> {!! $message !!}
        </div>
@php Session::forget('success'); @endphp
@endif

@if ($message = Session::get('error'))
<div class="alert alert-danger alert-dismissable ">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <strong>Error:</strong> {!! $message !!}
</div>
@php Session::forget('error'); @endphp
@endif

@if ($message = Session::get('warning'))
<div class="alert alert-warning alert-dismissable ">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <strong>Warning:</strong> {!! $message !!}
</div>
@php Session::forget('warning'); @endphp
@endif

@if ($message = Session::get('info'))
<div class="alert alert-info alert-dismissable ">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <strong>FYI:</strong> {!! $message !!}
</div>
@php Session::forget('info'); @endphp
@endif

 @if (Session::has('onzup.flash.message'))

<div class="alert alert-{{ Session::get('onzup.flash.level') }}">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    {!! Html::decode(Session::get('onzup.flash.message')) !!}
</div>
@endif