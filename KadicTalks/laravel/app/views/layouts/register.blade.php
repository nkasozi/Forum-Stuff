@extends('layouts.layout')

@section('content')
<div id="login_content">
  <div class="pannel">
    <div class="title"> 
      <h2><a href="register">Sign Up</a></h2>
    </div> 
    <div class="form">

      <!-- check for login error flash var -->
      @if (Session::has('flash_error'))
      <div id="flash_error">{{ Session::get('flash_error') }}</div>
      @endif

      {{ Form::open(array('url'=>'register')) }}


      <ul>

        <!-- username field -->
        <li>
          {{ Form::label('username', 'Username') }}
          {{ Form::text('username', Input::old('username'),array('required'=>'true')) }}
        </li>

        <!-- email field -->
        <li>
          {{ Form::label('email', 'Email') }}
          {{ Form::text('email', Input::old('email'),array('required'=>'true')) }}
        </li>
        
         <!-- Full name field -->
        <li>
          {{ Form::label('name', 'Full Name') }}
          {{ Form::text('name', Input::old('name'),array('required'=>'true')) }}
        </li>
        
         <!-- Speciality field -->
        <li>
          {{ Form::label('speciality', 'Speciality') }}
          {{ Form::select('speciality',$specialities ) }}
        </li>
        
         <!-- current hospital field -->
        <li>
          {{ Form::label('hospital', 'Current Hospital') }}
          {{ Form::text('hospital', Input::old('hospital'),array('required'=>'true')) }}
        </li>
        
        <!-- location field -->
        <li>
          {{ Form::label('location', 'Hospital Location') }}
          {{ Form::text('location', Input::old('location'),array('required'=>'true')) }}
        </li>
        
         <!-- Gender field -->
        <li>
          {{ Form::label('gender', 'Gender') }}
          {{ Form::select('gender',array('Male'=>'Male','Female'=>'Female')) }}
        </li>


        <!-- password field -->
        <li>
          {{ Form::label('password', 'Password') }}
          {{ Form::password('password',array('required'=>'true')) }}
        </li>

        <!-- confirm password field -->
        <li>
          {{ Form::label('confirmed_password','Confirm Password') }}
          {{ Form::password('confirmed_password',array('required'=>'true')) }}
        </li>

        <!-- submit button -->
        <li>{{ Form::submit('Sign Up',array('id'=>'submit')) }}</li>

        {{ Form::close() }}
    </div>
  </div>
</div>
@stop