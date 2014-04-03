@extends('layouts.profile_page_title')
@section('content')
@parent


<!-- settings menu bar  -->
<div class="content_row">
  <div class="content_row_container">
    <div id="nav">
      <ul>
        <li>{{link_to('settings?id='.Auth::user()->id, 'Settings', $attributes = array(), $secure = null) }}</li>
        <li>{{ link_to('#', 'Change Password or Email', $attributes = array('class'=>'active'), $secure = null) }}</li>
      </ul>
    </div>
  </div>
</div>


<div id="settings_content">
  <div id="settings_wrapper">
    <div class="row">

      {{ Form::open(array('url'=>'change_password')) }}

      <!-- old password field -->
      <div class="col">
        <div class="settings_category_left">
          <h4>
            {{ Form::label('old_password', 'Old Password') }}
          </h4>
        </div>

        <div class="settings_category_right">
          <ul>
            {{ Form::password('old_password') }}
          </ul>
        </div>
      </div>


      <!-- new password field -->
      <div class="col">
        <div class="settings_category_left">
          <h4>
            {{ Form::label('new_password', 'New Password') }}
          </h4>
        </div>

        <div class="settings_category_right">
          <ul>
            {{ Form::password('new_password') }}
          </ul>
        </div>
      </div>

      <!-- email field -->
      <div class="col">
        <div class="settings_category_left">
          <h4>
            {{ Form::label('email', 'Email') }}
          </h4>
        </div>

        <div class="settings_category_right">
          <ul>
            {{ Form::text('email',Auth::user()->email) }}
          </ul>
        </div>
      </div>

      <!-- submit button -->
      <div class="col">
        <div class="settings_category_left">
        </div>
        <div class="settings_category_right">
          {{ Form::submit('Save Changes',array('id'=>'save_changes')) }}
        </div>
      </div>
      {{ Form::close() }}
    </div>
  </div>
</div>

@stop
