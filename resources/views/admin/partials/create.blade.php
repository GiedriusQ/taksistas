<h1>Create {{$name}}</h1>
{!! Form::open() !!}
@include('admin.admins.form')
{!! Form::submit('Add',['class'=>'btn btn-success']) !!}
{!! Form::close() !!}