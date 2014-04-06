@extends('layouts.profile_page_title')

@section('content')
@parent

<!-- settings menu bar  -->
<div class="content_row">
  <div class="content_row_container">
    <div id="nav">
      <ul>
        <li>{{link_to('profile?id='.$user->id, 'About', $attributes = array('class'=>'active'), $secure = null) }}</li>
        <li>{{ link_to('activity?id='.$user->id, 'Activity', $attributes = array(), $secure = null) }}</li>
      </ul>
    </div>
  </div>
</div>


<div id="settings_content">
  <div id="settings_wrapper">
    <div class="row">

      <!-- full name field   -->
      <div class="col">
        <div class="settings_category_left">
          <h4>
            {{ Form::label('name', 'Name') }}
          </h4>
        </div>

        <div class="settings_category_right">
          <ul>
            {{ Form::label($user->full_name) }}
          </ul>
        </div>
      </div>

      <!-- about me field   -->
      <div class="col">
        <div class="settings_category_left">
          <h4>
            {{ Form::label('about', 'About Me') }}
          </h4>
        </div>

        <div class="settings_category_right">
          <ul>
            {{ Form::label($user->about_me) }}
          </ul>
        </div>
      </div>

      <!-- Current Hospital field   -->
      <div class="col">
        <div class="settings_category_left">
          <h4>
            {{ Form::label('hospital', 'Current Hospital') }}
          </h4>
        </div>

        <div class="settings_category_right">
          <ul>
            {{ Form::label($user->current_hospital) }}
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
            {{ Form::label($user->speciality) }}
          </ul>
        </div>
      </div>

      <!-- location field   -->
      <div class="col">
        <div class="settings_category_left">
          <h4>
            {{ Form::label('location', 'Location of hospital') }}
          </h4>
        </div>

        <div class="settings_category_right">
          <ul>
            {{ Form::label($user->Location) }}
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
            {{ Form::label($user->gender) }}
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
</div>

@stop