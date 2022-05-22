@extends('limitless.ajax')
@section('title', $title)
<style>
 .border_top{border-top:0px solid #ddd}
 .close_btn{margin: 5px;}
</style>
@section('content')
<div class="row">
    <div class="col-md-12" align="center">
        <button type="button" class="close close_btn" data-dismiss="modal">&times;</button>
        <table class="table table-user-information">
            <h1>{{ $title }} {{trans("comman.details")}}</h1>
            <tbody>
                <tr>
                  <th class="border_top col-sm-3">ID:</th>
                  <td class="border_top">{{ $currency->id }}</td>
                </tr>
                <tr>
                  <th class="border_top col-sm-3">Name:</th>
                  <td class="border_top">{{ $currency->name }}</td>
                </tr>
                <tr>
                  <th class="border_top col-sm-3">Sign:</th>
                  <td class="border_top">{{ $currency->sign }}</td>
                </tr>
                <tr>
                    <th class="border_top"></th>
                    <td class="border_top"></td>
                </tr>
              </tbody>
          </table>
      <div class="text-center">
      </div>
    </div>
</div>
@stop
