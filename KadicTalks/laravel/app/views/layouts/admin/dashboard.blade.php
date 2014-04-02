@extends('layouts.admin.index')
@section('content')
@parent
<div id="settings_content">
  <div id="dashboard_content">
    <div class="row">
      <div class="col">
        <h4>Forum Statistics</h4>

        @for($i=0;$i<count($statistics);$i++)
          <!-- old password field -->
          <div class="col">
            <div class="settings_category_left">
              <p>
                @if($i==0)
                {{ Form::label('members', 'Members') }}
                @endif
                @if($i==1)
                {{ Form::label('converstations', 'Conversations') }}
                @endif
                @if($i==2)
                {{ Form::label('posts', 'Posts') }}
                @endif
                @if($i==3)
                {{ Form::label('new_members', 'New Members this Week') }}
                @endif
                @if($i==4)
                {{ Form::label('new_conversations', 'New Conversations this Week') }}
                @endif
                @if($i==5)
                {{ Form::label('new_posts', 'New Posts this Week') }}
                @endif
              </p>
            </div>

            <div class="settings_category_right">
              <p>
                {{ Form::label('label',$statistics[$i]) }}
              <p>
            </div>
          </div>
          @endfor


      </div>
    </div>
  </div>
</div>
</div>
@stop
