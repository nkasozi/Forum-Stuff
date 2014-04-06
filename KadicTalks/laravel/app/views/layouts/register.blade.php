@extends('layouts.layout')

@section('content')
<div id="login_content">
  <div class="pannel">
    <div class="title"> 
      <h2><a href="register">Sign Up</a></h2>
    </div> 
    <div class="form">

      {{ Form::open(array('url'=>'register')) }}


      <ul>

        <!-- username field -->
        <li>
          {{ Form::label('username', 'Username') }}
          {{ Form::text('username', '',array('placeholder'=>'Enter a creative username','required'=>'true')) }}
        </li>

        <!-- email field -->
        <li>
          {{ Form::label('email', 'Email') }}
          {{ Form::text('email', '',array('placeholder'=>'Enter your email','required'=>'true')) }}
        </li>
        
         <!-- Full name field -->
        <li>
          {{ Form::label('name', 'Full Name') }}
          {{ Form::text('name','',array('placeholder'=>'Enter your full name','required'=>'true')) }}
        </li>
        
         <!-- Speciality field -->
        <li>
          {{ Form::label('speciality', 'Speciality') }}
          {{ Form::select('speciality',$specialities ) }}
        </li>
        
         <!-- current hospital field -->
        <li>
          {{ Form::label('hospital', 'Current Hospital') }}
          {{ Form::text('hospital','',array('placeholder'=>'Enter name of your current hospital','required'=>'true')) }}
        </li>
        
        <!-- location field -->
        <li>
          {{ Form::label('location', 'Hospital Location') }}
          {{ Form::text('location', '',array('placeholder'=>'Enter location of your current hospital','required'=>'true')) }}
        </li>
        
         <!-- Gender field -->
        <li>
          {{ Form::label('gender', 'Gender') }}
          {{ Form::select('gender',array('Male'=>'Male','Female'=>'Female'),'',array('style'=>'padding-right:5px;')) }}
        </li>


        <!-- password field -->
        <li>
          {{ Form::label('password', 'Password') }}
          {{ Form::password('password',array('placeholder'=>'Password should be atleast 6 characters ','required'=>'true')) }}
        </li>

        <!-- confirm password field -->
        <li>
          {{ Form::label('confirmed_password','Confirm Password') }}
          {{ Form::password('confirmed_password',array('placeholder'=>'Renter your password','required'=>'true')) }}
        </li>

        <!-- submit button -->
        <li>{{ Form::submit('Sign Up',array('id'=>'submit')) }}</li>

        {{ Form::close() }}
    </div>
  </div>
</div>
@stop