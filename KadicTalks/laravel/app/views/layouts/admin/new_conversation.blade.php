@extends('layouts.admin.index')
@section('content')
@parent
<!-- include libraries(jQuery, bootstrap, font awesome) -->
<script src="//code.jquery.com/jquery-1.9.1.min.js"></script> 
<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.no-icons.min.css" rel="stylesheet"> 
<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script> 
<link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.min.css" rel="stylesheet">
<!-- include summer note css/js-->
<link href="css/summernote.css"  rel="stylesheet">
<script src="js/summernote.min.js"></script>
<div id="settings_content">
  <div id="dashboard_content">
    <div class="row">

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
            {{ Form::text('title','',array('placeholder'=>'Title of conversation','required'=>'true')) }}
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

          <p><a href='https://www.youtube.com/upload' target="_blank">Upload Video From here</a></p>
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

        <div class="settings_category_right" style="width: 500px;">

          <!--comment/post of the profile -->
          <div class="post_comment_body" >
            <ul>
              {{ Form::textArea('post','',array('id'=>'summernote','placeholder'=>'Explain what this conversation is about')) }}
            </ul>

          </div>
          <div class="post_comment_footer">
            <ul>
            <li >{{Form::file('attachment')}}
             {{ Form::submit('Post',array('id'=>'save_changes','onclick'=>'return this.form.submit')) }}</li>
            </ul>

          </div>
          <script type="text/javascript">

$(document).ready(function() {


  $('#summernote').summernote({
    toolbar: [
      ['style', ['bold', 'italic', 'underline', 'clear']],
      ['para', ['ul', 'ol', 'paragraph']],
      ['table', ['table']],
      ['insert', ['link']]
    ],
    height: "300px",
    focus: true
  });
});
var postForm = function() {
  var content = $('textarea[name="post"]').html($('#summernote').code());
}
          </script>       
        </div>
      </div>
      <!-- submit button -->
      <div class="settings_category_right" style='float:right;margin-left: 2em;'> </div>

      {{ Form::close() }}
    </div>
  </div>
</div>

@stop