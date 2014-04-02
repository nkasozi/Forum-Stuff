@extends('layouts.admin.index')

@section('content')
@parent
<div id="settings_content">
  <div id="dashboard_content">
    <div class="row">
      <div class="col">
        <h4>Forum Settings</h4>
        {{ Form::open(array('url'=>'appearance')) }}

        <!-- text area for reply -->
        <div class="col">
          <div class="settings_category_left">
            <p>
              {{ Form::label('theme', 'Change Theme') }}
            </p>
          </div>
          <div class="settings_category_right">
            <p>
              {{ Form::select('theme',array('Light'=>'light','Dark'=>'dark'),array('class'=>'select')) }}
            </p>
          </div>
        </div>



        <!-- submit button -->
        <div class="col">
          <div class="settings_category_left">
            <p></p>
          </div>
          <div class="settings_category_right">
            <p>
              {{ Form::submit('Save Changes',array('id'=>'save_changes')) }}</p>
          </div>
        </div>
        {{ Form::close() }}
      </div>
    </div>
  </div>
</div>
</div>

@stop