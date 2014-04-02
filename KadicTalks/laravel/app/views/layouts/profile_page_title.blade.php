@extends('layouts.layout')
@section('content')

<!-- profile picture section  -->
<div id="content">
  <div class="content_row">
    <div class="content_row_container">
      <div class="profile_picture">
        <img src="/KadicTalks/images/{{$user->name_of_pic===''?'guest.png':$user->name_of_pic}}"/>
      </div>
      <div class="profile_information">
        <h4>{{$user->username}}</h4>
        <p>{{$user->account_type}}</p>
        <p>Last Active : {{$time_elapsed}}</p>
      </div>
    </div>
  </div>
  @stop