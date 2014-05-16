<html>
  <head>

    <title>Kadic Hospital Forum</title>

    <link href="css/styles.css" rel="stylesheet" media="screen">
    <link href="css/administration.css" rel="stylesheet" media="screen">
    <link href="css/profile.css" rel="stylesheet" media="screen">
    <link href="css/button_switch.css" rel="stylesheet" media="screen">
    <link href="css/home_styles.css" rel="stylesheet" media="screen">

    
    <!-- include libraries(jQuery, bootstrap, font awesome) -->
    <script src="//code.jquery.com/jquery-1.9.1.min.js"></script> 
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.no-icons.min.css" rel="stylesheet"/> 
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script> 
    <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.min.css" rel="stylesheet"/>
    <!-- include summer note css/js-->
    <link href="css/summernote.css"  rel="stylesheet"/>
    <script src="js/summernote.min.js"></script>

    <script type="text/javascript">

      $(document).ready(function() {


        $('#summernote').summernote({
          toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['link']]
          ],
          height: "300px",
          focus: true
        });
      });
      var postForm = function() {
        var content = $('textarea[name="post"]').html($('#summernote').code());
      }
    </script>  
    
  </head>
  <body>
    <div id="content_wrapper">
      <div id='header_styling'>

        <div id="header">

          <div id="logo">
            <?php
            $forum_title_setting = Setting::where('name', '=', 'forum_title')->first();
            $forum_title         = $forum_title_setting->value;
            ?>
            @if($forum_title==='')
            <h1>Kadic<span id="talks">TalkS</span></h1>
            @else
            <h1><span >{{$forum_title}}</span></h1>
            @endif
          </div>

          <div id="header_navigation">
            <ul>

              @if(Auth::check())
              <li><img height="20" width="20" src="images/{{Auth::user()->name_of_pic===''?'guest.png':Auth::user()->name_of_pic}}"/></li>                  
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
              <?php
              //get the registration setting
              $sign_up_setting     = Setting::where('name', '=', 'registration')->first();

              $sign_up_allowed = ($sign_up_setting->value) === 'Yes' ? TRUE : FALSE;
              ?>
              @if($sign_up_allowed)
              <li>{{ link_to('register', 'Sign Up', $attributes = array(), $secure = null)}}</li>
              @endif
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
            <li><a href="conversations">{{Post::all()->count()}} Posts</a></li>
            <li><a href="conversations">{{Conversation::all()->count()}} Conversations</a></li>
            <li><a href="conversations">{{User::all()->count()}} Members</a></li>
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