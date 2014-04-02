@extends('layouts.layout')

@section('content')

<div id="login_content">
  <div class="pannel">
    <div class="title"> 
      <h2><a href="login">Login</a></h2>
     
    </div> 
    <div class="form">


      {{ Form::open(array('url'=>'login')) }}

      <ul>
        <li>
          {{ Form::label('username', 'Username') }}
          {{ Form::text('username', Input::old('username'),array('required'=>'true','placeholder'=>'Username or Email')) }}
        </li>

        <!-- password field -->
        <li>
          {{ Form::label('password', 'Password') }}
          {{ Form::password('password',array('required'=>'true','placeholder'=>'Password')) }}
        </li>

        <!-- submit button -->
        <li>{{ Form::submit('Login',array('id'=>'submit')) }}</li>
      </ul>

      {{ Form::close() }}
    </div>
  </div>
</div>
@stop
