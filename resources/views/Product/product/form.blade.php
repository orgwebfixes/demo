<style type="text/css">
  .event-name-field{
    display: flex;
    align-items: center;
    justify-content: center;
  }
</style>
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>

<div class="row">
  <div class="form-group event-name-field {{ $errors->has('category_id') ? 'has-error' : ''}}">
    {!! Html::decode(Form::label('category_id', 'Category:<span class="has-stik">*</span> ', ['class'
    =>'col-sm-1 control-label'])) !!}
    <div class="col-sm-5">
      {!! Form::select('category_id',array("Select Status" => "Select Category")+$category, null, ['class' =>
      'form-control '
      ,'autofocus'=>'autofocus', 'required' => true]) !!}
      {!! $errors->first('category_id', '<p class="text-danger">:message</p>') !!}
    </div>
  </div>
</div>

          <div class="row">
            <div class="form-group  event-name-field {{ $errors->has('name') ? 'has-error' : ''}}">
                {!! Html::decode(Form::label('name', 'Name:<span class="has-stik">*</span> ', ['class' => 'col-sm-1 control-label'])) !!}
                <div class="col-sm-5">
                    {!! Form::text('name', null, ['class' => 'form-control ' ,'autofocus'=>'autofocus', 'required' => true ]) !!}
                    {!! $errors->first('name', '<p class="text-danger">:message</p>') !!}
                </div>
            </div>
          </div>

          <div class="row">
            <div class="form-group  event-name-field {{ $errors->has('sku') ? 'has-error' : ''}}">
                {!! Html::decode(Form::label('sku', 'SKU:<span class="has-stik">*</span> ', ['class' => 'col-sm-1 control-label'])) !!}
                <div class="col-sm-5">
                    {!! Form::text('sku', null, ['class' => 'form-control ' ,'autofocus'=>'autofocus', 'required' => true ]) !!}
                    {!! $errors->first('sku', '<p class="text-danger">:message</p>') !!}
                </div>
            </div>
          </div>

          <div class="row">
            
            <div class="form-group  event-name-field {{ $errors->has('image') ? 'has-error' : ''}}">
                {!! Html::decode(Form::label('image', 'Image: ', ['class' => 'col-sm-1 control-label'])) !!}
                <div class="col-sm-5">
                        <input type="file" class="file-styled" name="image_product" onchange="readURL(this)" accept='image/*'>
                  {!! ($errors->has('image') ? $errors->first('image', '<p class="text-danger">:message</p>') : '') !!}
                  <span class="help-block">Accepted formats: gif, png, jpg. Max file size 2Mb</span>

                  @if(isset($image) && !empty($image))
                  <a href="/{{AppHelper::size('')->getImageUrl($image)}}" data-popup="lightbox">
                        {{Html::image(AppHelper::path('uploads/user/')->size('100x100')->getImageUrl($image),'User Photo',array("class"=>"img-circle",'id'=>'staff','height'=>'100','width'=>'100'))}}
                    </a>
                    <a href="/{{AppHelper::size('')->getImageUrl($image)}}" download "><i class="fa fa-download"></i></a>
                @else
                  {{HTML::image(AppHelper::size('100x100')->getImageUrl(),'User Photo',array("class"=>"img-circle staff",'height'=>'100px','width'=>'100px','id'=>'staff'))}}
                @endif
                </div>
            </div>
          </div>

         

          <div class="row">
            <div class="form-group  event-name-field {{ $errors->has('date') ? 'has-error' : ''}}">
                {!! Html::decode(Form::label('date', 'Date Of Manufacture: ', ['class' => 'col-sm-1 control-label'])) !!}
                <div class="col-sm-5">
                    {!! Form::text('date', null, ['class' => 'form-control datepicker' ,'autofocus'=>'autofocus', 'required' => true ]) !!}
                    {!! $errors->first('date', '<p class="text-danger">:message</p>') !!}
                </div>
            </div>
          </div>

          <div class="row">
            <div class="form-group  event-name-field {{ $errors->has('price') ? 'has-error' : ''}}">
                {!! Html::decode(Form::label('price', 'Unit Price: ', ['class' => 'col-sm-1 control-label'])) !!}
                <div class="col-sm-5">
                    {!! Form::text('price', null, ['class' => 'form-control ' ,'autofocus'=>'autofocus', 'required' => true ]) !!}
                    {!! $errors->first('price', '<p class="text-danger">:message</p>') !!}
                </div>
            </div>
          </div>
         


          <script type="text/javascript">
            $( ".datepicker" ).datepicker({
            dateFormat: "yy-mm-dd"
          });
          </script>