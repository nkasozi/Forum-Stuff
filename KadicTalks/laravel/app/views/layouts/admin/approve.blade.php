@extends('layouts.admin.index')

@section('content')
@parent
<div id="settings_content">
  <div id="dashboard_content">
    <div class="row">
      <div class="col">
        <h4>Members to Approve</h4>
        @if(count($users)>0)
        @for($i=0;$i<count($users);$i++)
          {{Form::open(array('url'=>'approve?id='.$users[$i]->id))}}
          <div class="col">
            <div class="settings_category_left">

              <p>{{$users[$i]->username}} with the email {{$users[$i]->email}} </p>
            </div>
            <div class="settings_category_right">
              <div class="onoffswitch">

                <input type="checkbox" name="approve_switch" class="onoffswitch-checkbox" id="myonoffswitch{{$i}}" value="1"  onclick="this.form.submit()" onchange="this.form.submit()">
                <label class="onoffswitch-label" for="myonoffswitch{{$i}}">
                  <div class="onoffswitch-inner"></div>
                  <div class="onoffswitch-switch"></div>
                </label>
              </div>
            </div>
          </div> 
          {{Form::close()}}
          @endfor
          @else
          <p> No Members To Approve Today</p>
          @endif

      </div>
    </div>
  </div>
</div>
</div>

@stop