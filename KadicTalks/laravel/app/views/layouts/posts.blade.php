@extends('layouts.search')
@section('content')
@parent

@if(count($posts)>0)
@for($i=0; $i<count($posts); $i++)
  <!-- POST-->
  <div class="content_row">
    <div class="profile_row_container">
      <div class="profile_pic"> 
        <!--Profile pic -->
        <img src="images/{{$users[$i]->name_of_pic===''?'guest.png':$users[$i]->name_of_pic}}"/>
      </div>
      <!--comment/post of the profile -->
      <div class="profile_comment">
        <ul>
          <li><a href="">{{$users[$i]->username}}</a></li>
          <li>Mar 18</li>
          <li>{{$posts[$i]->created_at}}</li>
        </ul>
        <p>{{ $posts[$i]->content }}</p>
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

  <div class="content_row">
    <div class="profile_row_container">
      <div class="post_comment">
        <div class="post_comment_header">
          <ul>
            <li><a href='javascript:BBCode.bold("reply");void(0)' class="bbcode-b"></a></li>
            <li><a href='javascript:BBCode.bold("reply");void(0)' class="bbcode-i"></a></li>
            <li><a href='javascript:BBCode.bold("reply");void(0)' class="bbcode-h"></a></li>
            <li><a href='javascript:BBCode.bold("reply");void(0)' class="bbcode-s"></a></li>
            <li><a href='javascript:BBCode.bold("reply");void(0)' class="bbcode-link"></a></li>
            <li><a href='javascript:BBCode.bold("reply");void(0)' class="bbcode-img"></a></li>
            <li><a href='javascript:BBCode.bold("reply");void(0)' class="bbcode-fixed"></a></li>
          </ul>
        </div>
        <!--comment/post of the profile -->
        <div class="post_comment_body">
          <ul>
            {{ Form::open(array('url'=>'posts?id='.$id)) }}

            <!-- text area for reply -->
            <li>{{ Form::textArea('reply', Input::old('reply'),array('id'=>'reply','required'=>'true','cols'=>'')) }}</li>


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
  @else
  <!-- POST-->
  <div class="content_row">
    <div class="profile_row_container">
      <div class="profile_pic"> 
        <!--Profile pic -->
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