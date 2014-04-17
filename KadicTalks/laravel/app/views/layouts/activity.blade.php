@extends('layouts.profile_page_title')

@section('content')

@parent

<!-- settings menu bar  -->
<div class="content_row">
  <div class="content_row_container">
    
    <div id="nav">
      <ul>
        <li>{{link_to('profile?id='.$user->id, 'About', $attributes = array(), $secure = null) }}</li>
        <li>{{ link_to('activity?id='.$user->id, 'Activity', $attributes = array('class'=>'active'), $secure = null) }}</li>
      </ul>
    </div>
    
  </div>
</div>

@if(count($posts)>0)

@foreach($posts as $post)

<!-- ROW 1-->
<div class="content_row">
  <div class="profile_row_container">
    
    <!--Profile pic -->
    <div class="profile_pic">     
      <img src='images/{{$user->name_of_pic}}'/>
    </div>
    
    <!--comment/post of the profile -->
    <div class="profile_comment">
      <ul>
        <li><b>Posted in conversation {{$post->conversation_id}}</b></li>
        <li>on : {{$post->created_at}}</li>
      </ul>
      <p>{{$post->content}}</p>
    </div>
    
  </div>
</div>
<!-- END OF ROW 1-->

@endforeach

@else
<p> You have not yet participated in any conversation yet.Click <a href="conversations">here</a> to start</p>
@endif
</div>

@stop