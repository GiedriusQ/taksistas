<div class="form-group">
    {!! Form::label('email','Email') !!}
    {!! Form::text('email', null,['class'=>'form-control']) !!}
</div>
<div class="form-group">
    {!! Form::label('password','Password') !!}
    {!! Form::password('password',['class'=>'form-control']) !!}
</div>
@if(isset($name) && $name == 'Driver')
    <div class="form-group">
        {!! Form::label('dispatcher_id','Dispatcher') !!}
        {!! Form::select('dispatcher_id',$dispatchers_list ,null,['class'=>'form-control']) !!}
    </div>
@endif
<div class="form-group">
    {!! Form::label('name','Name') !!}
    {!! Form::text('name', null,['class'=>'form-control']) !!}
</div>
<div class="form-group">
    {!! Form::label('city','City') !!}
    {!! Form::text('city', null,['class'=>'form-control']) !!}
</div>