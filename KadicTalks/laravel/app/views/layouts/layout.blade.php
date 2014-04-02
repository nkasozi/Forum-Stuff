<html>
  <head>
    <title>Kadic Hospital Forum</title>
    <link href="/KadicTalks/css/styles.css" rel="stylesheet" media="screen">
    <link href="/KadicTalks/css/administration.css" rel="stylesheet" media="screen">
    <link href="/KadicTalks/css/profile.css" rel="stylesheet" media="screen">
    <link href="/KadicTalks/css/button_switch.css" rel="stylesheet" media="screen">
  </head>
  <body>
    <div id="content_wrapper">
      <div id='header_styling'>
        <div id="header">
          <div id="logo">
            <h1>Kadic<span id="talks">TalkS</span></h1>
          </div>
          <div id="header_navigation">
            <ul>


              @if(Auth::check())
              <li><img height="20" width="20"src="/KadicTalks/images/{{Auth::user()->name_of_pic===''?'guest.png':Auth::user()->name_of_pic}}"/></li>                  
              <li>{{ link_to('conversations', 'Home', $attributes = array(), $secure = null);}}</li>
              <li>{{ link_to('profile?id='.Auth::user()->id, Auth::user()->username, $attributes = array(), $secure = null) }}</li>            
              <li>{{ link_to('settings?id='.Auth::user()->id, 'Settings', $attributes = array(), $secure = null) }}</li>
              @if((Auth::user()->account_type)==='Administrator')
              <li>{{ link_to('admin ', 'Administration', $attributes = array(), $secure = null) }}</li>
              @endif

              <li>{{ link_to('logout', 'Logout', $attributes = array(), $secure = null) }}</li>
              @else    
              <li>{{ link_to('conversations', 'Home', $attributes = array(), $secure = null);}}</li>
              <li>{{ link_to('login', 'Login', $attributes = array(), $secure = null)}}</li>
              <li>{{ link_to('register', 'Sign Up', $attributes = array(), $secure = null)}}</li>
              @endif
            </ul>
          </div>
        </div>
      </div>

      <!-- check for flash notification message -->
      @if(Session::has('flash_notice'))
      <div class="flash_notice">
        <p>
          {{ Session::get('flash_notice') }}
        </p>
      </div>
      @endif

      <!-- check for error notification message -->
      @if($errors->has())
      <div class="flash_error">
        <p>
          @foreach ($errors->all() as $error)
          {{ $error }}
          @endforeach
        </p>
      </div>
      @endif

      @yield('content')

      <div id="footer">
        <div id="nav">
          <ul>
            <li><a href="#">Go to top</a></li>
            <li><a href="#">{{Post::all()->count()}} Posts</a></li>
            <li><a href="#">{{Conversation::all()->count()}} Conversations</a></li>
            <li><a href="#">{{User::all()->count()}} Members</a></li>
          </ul>
        </div>

        <div id="developer">
          <ul>
            <li>Developed by <a href="https://www.facebook.com/nkasozi">Nsubuga Kasozi</a> and <a href="https://www.facebook.com/royalfredrick?fref=ts">Fredrick Royal</a></li>
          </ul>
        </div>
      </div>
    </div>
  </body>
</html>