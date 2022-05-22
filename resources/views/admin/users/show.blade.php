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
                  <td rowspan="4" width="200" class="border_top">
                    @if(isset($userData->image) && !empty($userData->image))
                      @php $file = "/uploads/user/" . $userData->image; @endphp
                      @if(file_exists(public_path().$file))
                          @php $img = AppHelper::path('/uploads/user/')->size('100x100')->getImageUrl($userData->image); @endphp
                      @else
                          @php $img = AppHelper::path('uploads/')->size('100x100')->getImageUrl('default.jpg');  @endphp
                      @endif
                      {{Html::image($img,'User Photo',array("class"=>"img-circle"))}}
                    @else
                      {{Html::image(AppHelper::path('uploads/')->size('100x100')->getImageUrl('default.jpg'),'User Photo',array("class"=>"img-circle"))}}
                    @endif
                  </td>
                </tr>
                <tr>
                  <th class="border_top">Name:</th>
                  <td class="border_top">{{$userData->name}}</td>
                </tr>
                <tr>
                  <th>E-mail:</th>
                  <td>{{$userData->email}}</td>
                </tr>
                <tr>
                  <th>Mobile No:</th>
                  <td>{{$userData->mobile_no}}</td>
                </tr>
              </tbody>
          </table>
          <table class="table table-user-information">
              <tbody>
                <tr>
                    <th class="col-md-2">Status:</th>
                    <td>@if($userData->activations == true) Inactvie @else Actvie @endif</td>
                </tr>
                <tr>
                    <th class="col-md-2">Role:</th>
                    <td>{{ $userData->role }}</td>
                </tr>
              </tbody>
          </table>
    </div>
</div>
@stop
