@extends('layouts.admin.index')

@section('content')
@parent
<div id="settings_content">
  <div id="dashboard_content">
    <div class="row">


      {{ Form::open(array('url'=>'forum_settings')) }}


      <!-- drop down field for appearance -->
      <div class="col">
        <h4>Change Forum Settings Here</h4>
        <div class="settings_category_left">
          <h4>
            {{ Form::label('appearance', 'Appearance [Theme]') }}
          </h4>
        </div>

        <div class="settings_category_right">
          <ul>
            <?php
            $appearance          = Setting::where('name', '=', 'appearance')->first();
            ?>
            {{ Form::select('appearance',array('Light'=>'Light','Dark'=>'Dark'),$appearance->value) }}
          </ul>
        </div>
      </div>

      <!-- forum title field  -->
      <div class="col">
        <div class="settings_category_left">
          <h4>
            {{ Form::label('forum_title', 'Forum Title') }}
          </h4>
        </div>

        <div class="settings_category_right">
          <ul>
            <?php
            $title               = Setting::where('name', '=', 'forum_title')->first();
            ?>
            {{ Form::text('forum_title',$title->value,array('placeholder'=>'Leave Blank For Default Value')) }}
          </ul>
        </div>
      </div>

      <!-- forum payment duration field  -->
      <div class="col">
        <div class="settings_category_left">
          <h4>
            {{ Form::label('payment_duration', 'Ask For Payment After (in years)') }}
          </h4>
        </div>

        <div class="settings_category_right">
          <?php
          $payment_duration    = Setting::where('name', '=', 'payment_duration')->first();
          ?>
          <ul>
            {{ Form::text('payment_duration',$payment_duration->value,array('required')) }}
          </ul>
        </div>
      </div>

      <!-- user attachment field  -->
      <div class="col">
        <div class="settings_category_left">
          <h4>
            {{ Form::label('user_attachment', 'Are normal users allowed to attach documents') }}
          </h4>
        </div>

        <div class="settings_category_right">
          <ul>
            <?php
            $attachment          = Setting::where('name', '=', 'user_attachment')->first();
            ?>
            {{ Form::select('user_attachment',array('Yes'=>'Yes','No'=>'No'),$attachment->value) }}
          </ul>
        </div>
      </div>

      <!-- User Approval field  -->
      <div class="col">
        <div class="settings_category_left">
          <h4>
            {{ Form::label('approval', 'User must be approved before login') }}
          </h4>
        </div>

        <div class="settings_category_right">
          <ul>
            <?php
            $approval            = Setting::where('name', '=', 'approval')->first();
            ?>
            {{ Form::select('approval',array('Yes'=>'Yes','No'=>'No'),$approval->value) }}
          </ul>
        </div>
      </div>

      <!-- Confirm email field -->
      <div class="col">
        <div class="settings_category_left">
          <h4>
            {{ Form::label('send_email', 'User Must Confirm Email') }}
          </h4>
        </div>

        <div class="settings_category_right">
          <ul>
            <?php
            $send_email          = Setting::where('name', '=', 'send_email')->first();
            ?>
            {{ Form::select('send_email',array('Yes'=>'Yes','No'=>'No'),$send_email->value) }}
          </ul>
        </div>
      </div>

      <!-- Add speciality field  -->
      <div class="col">
        <div class="settings_category_left">
          <h4>
            {{ Form::label('speciality', 'Add A New Doctor Speciality') }}
          </h4>
        </div>

        <div class="settings_category_right">
          <ul>
            {{ Form::text('speciality') }}
          </ul>
        </div>
      </div>

      <!-- suspension duration field -->
      <div class="col">
        <div class="settings_category_left">
          <h4>
            {{ Form::label('suspension_duration', 'Duration of Member Suspension (in days)') }}
          </h4>
        </div>

        <div class="settings_category_right">
          <ul>
            <?php
            $suspension_duration = Setting::where('name', '=', 'suspension_duration')->first();
            ?>
            {{ Form::text('suspension_duration',$suspension_duration->value,array('required')) }}
          </ul>
        </div>
      </div>

      <!-- Registration status drop down -->
      <div class="col">
        <div class="settings_category_left">
          <h4>
            {{ Form::label('registration', 'Is Registration (Sign Up) of New Members still Ongoing') }}
          </h4>
        </div>

        <div class="settings_category_right">
          <ul>
            <?php
            $registration        = Setting::where('name', '=', 'registration')->first();
            ?>
            {{ Form::select('registration',array('Yes'=>'Yes','No'=>'No'),$registration->value) }}
          </ul>
        </div>
      </div>

      <!-- submit button -->
      <div class="col">
        <div class="settings_category_left">

        </div>

        <div class="settings_category_right">
          <ul>
            {{ Form::submit('Save Changes',array('id'=>'save_changes')) }}
          </ul>
        </div>
      </div>

      {{ Form::close() }}

    </div>
  </div>
</div>
</div>

@stop