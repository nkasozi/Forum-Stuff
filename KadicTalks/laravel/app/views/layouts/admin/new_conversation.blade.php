@extends('layouts.admin.index')

@section('content')

@parent


<div id="settings_content">
  <div id="dashboard_content">
    <div class="row">
      <div class="col">
         <h4><b>Start A New Conversation Here</b></h4>
        {{Form::open(array('url'=>'new_conversation','files'=>true,'onsubmit'=>'return postForm()'))}}

        <!-- text field for title -->
        <div class="col">
          <div class="settings_category_left">
            <h4>
              {{ Form::label('title', 'Title') }}
            </h4>
          </div>

          <div class="settings_category_right">
            <ul>
              <li>{{ Form::text('title','',array('placeholder'=>'Title of conversation','required'=>'true')) }}</li>
            </ul>
          </div>
        </div>

        <!--text field for title -->
        <div class="col">
          <div class="settings_category_left">
            <h4>
              {{ Form::label('time', 'Expire After (time in days)') }}
            </h4>
          </div>

          <div class="settings_category_right">
            <ul>
              <li>{{ Form::text('time','10',array('placeholder'=>'Time in days:  Number','required'=>'true')) }}</li>
            </ul>
          </div>
        </div>

        <!--text field for time expiry field -->
        <div class="col">
          <div class="settings_category_left">
            <h4>
              {{ Form::label('link', 'Add Link To Video') }}
            </h4>
          </div>

          <div class="settings_category_right">
            <ul>
              <li><a href='https://www.youtube.com/upload' target="_blank">Upload Video From here</a></li>
              <li style="margin-top:1em;">{{ Form::text('link','',array('placeholder'=>'Paste Link to Youtube Video')) }}</li>
            </ul>
          </div>
        </div>

        <!-- text area for first post -->
        <div class="col">
          <div class="settings_category_left">
            <h4>
              {{ Form::label('post', 'First Post') }}
            </h4>
          </div>

          <div class="settings_category_right" style="width: 500px;">

            <!--comment/post of the profile -->
            <div class="post_comment_body" >
              <ul>
                <li id="admin_post_textarea"> {{ Form::textArea('post','',array('id'=>'summernote','placeholder'=>'Explain what this conversation is about')) }}<li>
                <li style="margin-top:1em;">{{ Form::submit('Post',array('id'=>'save_changes','onclick'=>'return this.form.submit')) }}
                  {{Form::file('attachment')}}
                </li>

              </ul>
            </div>
          </div>
        </div>

        {{ Form::close() }}
      </div>
    </div>
  </div>
</div>
</div

@stop