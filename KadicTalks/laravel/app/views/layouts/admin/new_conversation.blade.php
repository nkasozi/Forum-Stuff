@extends('layouts.admin.index')
@section('content')
@parent
<div id="settings_content">
  <div id="dashboard_content">
    <div class="row">

      {{Form::open(array('url'=>'new_conversation','files'=>true))}}


      <!-- text field for title -->
      <div class="col">
        <div class="settings_category_left">
          <h4>
            {{ Form::label('title', 'Title') }}
          </h4>
        </div>

        <div class="settings_category_right">
          <ul>
            {{ Form::text('title','',array('placeholder'=>'Title of conversation','required'=>'true')) }}
          </ul>
        </div>
      </div>

      <!--text field for title -->
      <div class="col">
        <div class="settings_category_left">
          <h4>
            {{ Form::label('time', 'Expire After') }}
          </h4>
        </div>

        <div class="settings_category_right">
          <ul>
            {{ Form::text('time','10',array('placeholder'=>'Time in days:  Number','required'=>'true')) }}
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

          <p><a href=''>Upload Video From here</a></p>
          <p>{{ Form::text('link','',array('placeholder'=>'Paste Link from Youtube')) }}</p>

        </div>
      </div>

      <!-- text area for first post -->
      <div class="col">
        <div class="settings_category_left">
          <h4>
            {{ Form::label('post', 'First Post') }}
          </h4>
        </div>

        <div class="content_row">
          <div class="profile_row_container">
            <div class="post_comment" id="post_comment_admin">
              <div class="post_comment_header">
                <ul>

                </ul>
              </div>

              <!--comment/post of the profile -->
              <div class="post_comment_body">
                <ul>
                  {{ Form::textArea('post','',array('class'=>'editable','placeholder'=>'Explain what this conversation is about','required'=>'true')) }}
                </ul>

              </div>
              <div class="post_comment_footer">

                <p>{{Form::file('attachment')}}</p>

                <ul>
                  <!-- submit button -->
                  <li> {{ Form::submit('Post',array('id'=>'submit')) }}</li>
                </ul>

              </div>

              {{ Form::close() }}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@stop