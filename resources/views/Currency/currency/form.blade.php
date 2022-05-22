<style type="text/css">
  .event-name-field{
    display: flex;
    align-items: center;
    justify-content: center;
  }
</style>
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
    <div class="form-group event-name-field {{ $errors->has('status') ? 'has-error' : ''}}">
      {!! Html::decode(Form::label('status', 'Status:<span class="has-stik">*</span> ', ['class'
      =>'col-sm-1 control-label'])) !!}
      <div class="col-sm-5">
        {!! Form::select('status', array('1' => 'Active', '0' => 'Inactive'), null, ['class' =>
        'form-control '
        ,'autofocus'=>'autofocus', 'required' => true]) !!}
        {!! $errors->first('status', '<p class="text-danger">:message</p>') !!}
      </div>
    </div>
</div>
