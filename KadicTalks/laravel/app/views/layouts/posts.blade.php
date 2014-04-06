@extends('layouts.search')
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

<script type="text/javascript">
  function init()
  {
    document.getElementById("summernote").focus();
  }
</script>

@if(count($posts)>0)

@for($i=0; $i<count($posts); $i++)

  <!-- POST-->
  <div class="content_row" >
    <div class="profile_row_container">

      <!--Profile pic -->
      <div class="profile_pic"> 
        <img src="images/{{$users[$i]->name_of_pic===''?'guest.png':$users[$i]->name_of_pic}}"/>
      </div>

      <!--header of the post -->
      <div class="profile_comment">
        <div class="profile_comment_header">
          <ul>
            <li><a href="profile?id={{$users[$i]->id}}">{{$users[$i]->username}}</a></li>
            <li>@ {{$posts[$i]->created_at}}</li>
            <li></li>
          </ul>
        </div>

        <!--body of post -->
        <div class="profile_comment_body">
          <p>{{$posts[$i]->content}}</p>
        </div>

        <!--footer of post -->

        <div class="profile_comment_attachment">
          <ul>  
            @if(($posts[$i]->name_of_attachment)!='')
            <li><a href="attachments/{{$posts[$i]->name_of_attachment}}" target="_blank"><img src="images/docs.png" /></a></li>
            @endif
            @if(($posts[$i]->link_to_video)!='')
            <li><a href="{{$posts[$i]->link_to_video}}" target="_blank">Watch Video Here</a></li>   
            @endif
          </ul>
        </div>


      </div>
    </div>
  </div>
  <!-- END OF POST-->

  @endfor
  @else
  <div class="flash_error" >
    <p>Sorry But There Are no posts to display</p>
  </div>
  @endif






  @if(Auth::check())

  <div class="content_row" >
    <div class="profile_row_container">
      <div class="post_comment">
        {{ Form::open(array('url'=>'posts?id='.$id,'onload'=>'init()')) }}

        <div class="post_comment_header">      
        </div>

        <!--comment/post of the profile -->
        <div class="post_comment_body">
          <ul>
            <!-- text area for reply -->
            <li>{{ Form::textArea('reply','',array('id'=>'summernote','autofocus'=>'true','placeholder'=>'Just start typing a response')) }}</li>
          </ul>
        </div>

        <div class="post_comment_footer">
          <ul>
            <!-- submit button -->
            <li> {{ Form::submit('Post',array('id'=>'submit')) }}</li>
          </ul>
        </div>

        {{ Form::close() }}

      </div>
    </div>
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
      var content = $('textarea[name="reply"]').html($('#summernote').code());
    }
  </script>

  @else
  <!-- POST-->
  <div class="content_row">
    <div class="profile_row_container">

      <!--Profile pic -->
      <div class="profile_pic">      
        <img src="images/guest.png"/>
      </div>

      <!--comment/post of the profile -->
      <div class="profile_comment">
        <ul>
          <li><a href="">Guest User</a></li>
          <li>Mar 18</li>
          <li>{{date('Y-m-d')}}</li>
        </ul>
        <p>To reply you have to <a href="login">login</a> or <a href="register">sign up</a></p>
      </div>

    </div>
  </div>
  <!-- END OF POST-->
  @endif

</div>
@stop