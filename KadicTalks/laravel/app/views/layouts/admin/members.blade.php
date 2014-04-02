@extends('layouts.admin.index')

@section('content')
@parent
<div id="settings_content">
  <div id="dashboard_content">
    <div class="row">
      <div class="col">
        <h4>All Members</h4>
        @if(count($users)>0)
        @foreach($users as $user)
        <div class="col">
          <div class="settings_category_left">
            {{Form::open(array('url'=>'delete?id='.$user->id,'onsubmit'=>"return confirm('Do you really want to delete this user account.This cant be undone');"))}}
            <p><a href="profile?id={{$user->id}}">{{$user->username}}</a> with the email {{$user->email}} </p>
          </div>
          <div class="settings_category_right">
            <p> {{ Form::submit('Delete',array('id'=>'save_changes')) }}</p>
            {{Form::close()}}
            {{Form::open(array('url'=>'suspend?id='.$user->id,'onsubmit'=>"return confirm('Do you really want to suspend this user account.This cant be undone');"))}}
            <p><input type="submit" value="Suspend / Ban" id='save_changes'/></p>
            {{Form::close()}}
          </div>
        </div>
        @endforeach
        @else
        <p>Sorry But your forum has no members</p>
        @endif
        
      </div>
    </div>
  </div>
</div>
</div>

@stop