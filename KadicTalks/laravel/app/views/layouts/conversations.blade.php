@extends('layouts.search')
@section('content')
@parent

@if(count($conversations)>0)
@foreach($conversations as $conversation)

<!-- ROW 1-->
<div class="content_row">
  <div class="content_row_container">
    <div class="post"> 
      <ul>
        <li class="first"><a href="#">General Discussion</a></li>
        <li class="last"><a href="posts?id={{$conversation->id}}">{{ $conversation->title }}</a></li>
      </ul>
    </div>
    <div class="post_info">
      <ul>
        <li class="first"><a href="posts?id={{$conversation->id}}">{{(Post::where('conversation_id','=',$conversation->id)->count())}} replies</a></li>

        <?php
        //GET THE NAME OF THE LAST USER AND THE TIME FROM THE LAST POST
        //first organise model in descending order
        //then get the first row
        $post = Post::orderBy('created_at', 'desc')->where('conversation_id', '=', $conversation->id)->first();
        //find the user with the corresponding user_id
        $user = User::find($post->user_id);
        //get the name of the user
        $name = $user->username;
        $time=  UserController::TimeElapsed($user->created_at);
        ?>

        <li class="last"><a href="#">{{$name}} posted {{$time}}</a></li>
        @if(Auth::check())
        @if((Auth::user()->account_type)==='Administrator')
        <li class="delete_post"><a href="delete_conversation?id={{$conversation->id}}" onclick="return confirm('Do You Really Want To Delete This Conversation?')"><img src="images/delete.png"></a></li>
        @endif
        @endif
      </ul>
    </div>
  </div>
</div>
@endforeach
@else
<p>Sorry But There Are Conversations To Display</p>
@endif
</div>
@stop