<html>
  <head>
    <title>Kadic Hospital Forum</title>
    <link href="css/styles.css" rel="stylesheet" media="screen">
    <link href="css/login_style.css" rel="stylesheet" media="screen">
    <link href="css/home_styles.css" rel="stylesheet" media="screen">
    <script src="js/jquery.min.js"></script>
    <script src="js/home.js"></script>
  </head>
  <body>
    <div id="content_wrapper">
      <div id="header_styling">
        <div id="header">
          <div id="logo">
            <h1>Kadic<span id="talks">TalkS</span></h1>
          </div>
          <div id="header_navigation">
            <ul>
              <li><a href="#" id="home_buttom">Home</a></li>
              <li><a href="register">Sign Up</a></li>
              <li><a href="login">Log In</a></li>
            </ul>
          </div>
        </div>
      </div>

      <div id="home_content">
        <div class="billboard">
          <div id="home_header">
            <footer>
              <a href="" class="button style2 scrolly scrolly-centered" id="start">Doctor? We need to talk</a>
            </footer>
          </div>
          <div id="home_footer">
            <ul class="icons">
              <li><a href="#" class="fa fa-facebook solo"><span>Facebook</span></a></li>
              <li><a href="#" class="fa fa-twitter solo"><span>Twitter</span></a></li>
              <li><a href="#" class="fa fa-google-plus solo"><span>Google+</span></a></li>
              <li><a href="#" class="fa fa-pinterest solo"><span>Pinterest</span></a></li>
              <li><a href="#" class="fa fa-linkedin solo"><span>LinkedIn</span></a></li>
            </ul>
          </div>
        </div>
      </div>
      <!-- End billboard -->
      <!-- Header -->





      <div id='content'>
        <div class="content_row">
          <div class="content_row_container">
            <div id="nav">

            </div>
            <div id="conversation_search">
              <form action="search_conversations" method="post">
                <fieldset>
                  <input type="text" name="search_term" placeholder='Search conversations...'/>
                </fieldset>
              </form>
            </div>
          </div>
        </div>
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
                $time = UserController::TimeElapsed($user->created_at);
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
        <p>Sorry But There Are No Conversations To Display</p>
        @endif
      </div>

    </div>
  </body>
</html>