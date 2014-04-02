@extends('layouts.admin.index')

@section('content')
@parent
<div id="settings_content">
  <div id="dashboard_content">
    <div class="row">
      <div class="col">
        <h4>Forum Settings</h4>
        {{ Form::open(array('url'=>'forum_settings')) }}
        <ul>
          <!-- text area for reply -->
          <li>
            {{ Form::label('forum_title', 'Title') }}<br/>
            {{ Form::text('forum_title') }}
          </li>

          <!-- text area for reply -->
          <li>
            {{ Form::label('home_page', 'Home Page') }}<br/>
            {{ Form::label('home_page','Choose what people will see when they first visit your forum.') }}
          </li>

          <!-- text area for reply -->
          <li>
            {{ Form::label('registration_status', 'Is Registration [For New members] Open') }}<br/>
            {{ Form::label('registration_status','Customize how users can become members of your forum') }}
          </li>

          <!-- submit button -->
          <li>{{ Form::submit('Save Changes') }}</li>
        </ul>
        {{ Form::close() }}
      </div>
    </div>
  </div>
</div>
</div>

@stop