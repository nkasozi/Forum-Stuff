@extends('layouts.layout')
@section('content')
<!-- check for flash notification message -->
<div id="content">
  <div class="content_row">
    <div class="content_row_container">
      <div id="nav">

        @if(Session::has('conversation_id'))
        @if(!Request::is('conversations'))
        <ul>
          <li id="menu_icon"><a href="#"></a></li>
          <li ><a href="conversations" id="active_nav">Conversations</a></li>
          <li><a href="posts?id={{Session::get('conversation_id')}}">{{Conversation::find(Session::get('conversation_id'))->title}}</a></li>
        </ul>
        @endif
      </div>

      <div id="conversation_search">
        @if(Request::is('conversations')||Request::is('search_conversations'))
        <form action="search_conversations" method="post">
          <fieldset>
            <input type="text" name="search_term" placeholder='Search conversations...'/>
          </fieldset>
        </form>
        @endif
        @if(Request::is('posts')||Request::is('search_posts'))
        <form action="search_posts" method="post">
          <fieldset>
            <input type="text" name="search_term" placeholder='Search posts...'/>
          </fieldset>
        </form>
        @endif
        @endif
      </div>
    </div>
  </div>
  @stop