@extends('layouts.profile_page_title')
@section('content')
@parent

<!-- settings menu bar  -->
<div class="content_row">
  <div class="content_row_container">
    <div id="nav">
      <ul>
        <li>{{link_to('#', 'Settings', $attributes = array('class'=>'active'), $secure = null) }}</li>
        <li>{{ link_to('settings/password?id='.Auth::user()->id, 'Change Password or Email', $attributes = array(), $secure = null) }}</li>
      </ul>
    </div>
  </div>
</div>


<div id="settings_content">
  <div id="settings_wrapper">
    <div class="row">

      {{ Form::open(array('route'=>'settings','files'=>true)) }}

      <!-- profile pic  -->
      <div class="col">
        <div class="settings_category_left">
          <h4>
            {{ Form::label('profile', 'Profile Pic') }}
          </h4>
        </div>

        <div class="settings_category_right">
          <div class="wrapper">
            <img src="/KadicTalks/images/{{Auth::user()->name_of_pic}}"/>
            <ul>
              {{ Form::file('image',array('id'=>'save_changes')) }}
            </ul>
          </div>
        </div>
      </div>

      <!-- location field -->
      <div class="col">
        <div class="settings_category_left">
          <h4>
            {{ Form::label('location', 'Location') }}
          </h4>
        </div>

        <div class="settings_category_right">
          <ul>
            {{ Form::text('location',Auth::user()->Location) }}
          </ul>
        </div>
      </div>


      <!-- full name field   -->
      <div class="col">
        <div class="settings_category_left">
          <h4>
            {{ Form::label('name', 'Full Name') }}
          </h4>
        </div>

        <div class="settings_category_right">
          <ul>
            {{ Form::text('name',Auth::user()->full_name) }}
          </ul>
        </div>
      </div>

      <!-- speciality field   -->
      <div class="col">
        <div class="settings_category_left">
          <h4>
            {{ Form::label('speciality', 'Speciality') }}
          </h4>
        </div>

        <div class="settings_category_right">
          <ul>
           
            {{ Form::select('speciality',$specialities,Auth::user()->speciality,array('style'=>'width:300px')) }}
          </ul>
        </div>
      </div>

      <!-- current hospital field   -->
      <div class="col">
        <div class="settings_category_left">
          <h4>
            {{ Form::label('hospital', 'Current Hospital') }}
          </h4>
        </div>

        <div class="settings_category_right">
          <ul>
            {{ Form::text('hospital',Auth::user()->current_hospital) }}
          </ul>
        </div>
      </div>

      <!-- gender field   -->
      <div class="col">
        <div class="settings_category_left">
          <h4>
            {{ Form::label('gender', 'Gender') }}
          </h4>
        </div>

        <div class="settings_category_right">
          <ul>
            {{ Form::select('gender',array('Male'=>'Male','Female'=>'Female'),Auth::user()->gender) }}
          </ul>
        </div>
      </div>

      <!-- about me field   -->
      <div class="col">
        <div class="settings_category_left">
          <h4>
            {{ Form::label('about_me', 'About') }}
          </h4>
        </div>

        <div class="settings_category_right">
          <ul>
            {{ Form::textArea('about_me',Auth::user()->about_me) }}
          </ul>
        </div>
      </div>

      <!-- submit button -->
      <div class="col">
        <div class="settings_category_left">
        </div>
        <div class="settings_category_right">
          <p>{{ Form::submit('Save Changes',array('id'=>'save_changes')) }}</p>
        </div>
      </div>
      {{ Form::close() }}
    </div>
  </div>
</div>

@stop