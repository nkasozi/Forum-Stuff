@extends('layouts.layout')
@section('content')
<div id="administration_content">
  <div id="settings_menu">
    <ul>
      <li class='{{ Request::is('new_conversation')||Request::is('admin') ? 'active' :''  }}'>{{ link_to('new_conversation', 'New Conversation', $attributes = array(), $secure = null) }}</li>
      <li class='{{ Request::is('approve') ? 'active' :'' }}'>{{ link_to('approve', 'Members To Approve', $attributes = array(), $secure = null) }}</li>
      <li class='{{ Request::is('dashboard') ? 'active' :''}}'>{{ link_to('dashboard', 'Dashboard', $attributes = array(), $secure = null) }}</li>
      <li class='{{ Request::is('forum_settings') ? 'active' :'' }}'>{{ link_to('#forum_settings', 'Forum Settings', $attributes = array(), $secure = null) }}</li>
      <li class='{{ Request::is('appearance') ? 'active' :'' }}'>{{ link_to('appearance', 'Appearance', $attributes = array(), $secure = null) }}</li>  
      <li class='{{ Request::is('users') ? 'active' :'' }}'>{{ link_to('users', 'Members', $attributes = array(), $secure = null) }}</li>
      <li class='{{ Request::is('billings') ? 'active' :'' }}'>{{ link_to('#', 'Billing', $attributes = array(), $secure = null) }}</li>
    </ul>
  </div>
  @stop