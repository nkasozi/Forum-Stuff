<?php

//THIS CLASS IS A CONTROLLER FOR A NORMAL USER
//IT WILL RESPOND TO ALL ACTIONS MADE A NORMAL USER
//A NORMAL USER CAN LOGIN,POST COMMENTS,
//VIEW HIS PROFILE,VIEW HIS ACTIVITY ON THE FORUM,
//CHANGE SETTINGS LIKE PASSWORDS ETC
//NOTE THAT A NORMAL USER CANT START A CONVERSATION
class UserController extends BaseController
{

  //ATTEMPTS TO LOGIN USER BASED ON CREDENTIALS PROVIDED
  public function TryToLoginUser()
  {
    //get input username and password
    $user = array(
        'username' => Input::get('username'),
        'password' => Input::get('password')
    );

    //if log in was sucessfull
    if (Auth::attempt($user))
    {
      //get approval setting
      $approval_setting            = Setting::where('name', '=', 'approval')->first();
      $email_confirmation_setting  = Setting::where('name', '=', 'send_email')->first();
      $payment_duration_setting    = Setting::where('name', '=', 'payment_duration')->first();
      $approval_required           = ($approval_setting->value) === 'Yes' ? TRUE : FALSE;
      $email_confirmation_required = ($email_confirmation_setting->value) === 'Yes' ? TRUE : FALSE;
      $payment_duration            = $payment_duration_setting->value;
      $user_status                 = Auth::user()->status;

      //if user has not yet been approved by admin and the admin must first approve
      if ($approval_required && $user_status === 'awaiting approval')
      {
        //log him out
        Auth::logout();

        //redirect with sorry message
        return Redirect::route('login')->withErrors('Sorry but your account has not yet been approved.Try again later')->withInput();
      }

      //if email confirmation is required and the user has not yet confirmed
      else if ($email_confirmation_required && $user_status === 'awaiting_confirmation')
      {
        //log him out
        Auth::logout();

        //redirect with sorry message
        return Redirect::route('login')->withErrors('Sorry but your email has not yet been confirmed.Check Your Email for a confirmation link')->withInput();
      }

      //if user is currently suspended or banned
      else if ($user_status === 'suspended')
      {
        //get the suspension duration setting
        $suspension_duration_setting = Setting::where('name', '=', 'suspension_duration')->first();

        //get the duration of a suspension
        $suspension_duration = $suspension_duration_setting->value;

        //get the date the suspension started(date of last update of user row)
        $updated_at = Auth::user()->updated_at;

        //get the days that have elapsed since then
        $days_elapsed = Utilities::GetDaysGoneBy($updated_at);

        echo 'days_elapsed=' . $days_elapsed;

        //if the days elapsed since then are greater than the duration of the suspension
        if ($days_elapsed >= ($suspension_duration))
        {
          //change users status to active
          Auth::user()->status = 'active';

          //save change
          Auth::user()->save();

          //log user in
          return Redirect::route('conversations');
        }

        //suspension days are not yet finished
        else
        {
          //log him out
          Auth::logout();

          //redirect with sorry message
          return Redirect::route('login')->withErrors('Sorry but your account has been suspended.Try again after ' . $suspension_duration . ' days')->withInput();
        }
      }

      //the users free period is done.time to pay up sucker
      else if (Utilities::GetYearsGoneBy(Auth::user()->created_at) >= $payment_duration)
      {
        //log him out
        Auth::logout();

        //redirect with sorry message
        return Redirect::route('login')->withErrors('Sorry but your days of free access are done.pliz proceed here and pay up sucker');
      }

      //else authentication sucess! take him to see conversations from account
      else
      {
        //if email confirmation and admin approval are turned off but user status is not active 
        if (!($user_status === 'active'))
        {
          //change users status to active
          Auth::user()->status = 'active';

          //save changes
          Auth::user()->save();
        }

        //noftify him too
        return Redirect::route('conversations');
      }
    }

    // else authentication failure! lets go back to the login page
    else
    {
      // with the users original input
      return Redirect::route('login')->withErrors('Your username/password combination was incorrect.')->withInput();
    }
  }

  //THIS LOGS A USER OUT AND TERMINATES HIS SESSION
  public function LogUserOut()
  {
    //log user out
    Auth::logout();

    //take user to login page and display sucess message
    return Redirect::route('home');
  }

  //THIS ATTEMPTS TO CREATE A NEW USER BASED ON PROVIDED INFO OR FAILS WITH ERRORS
  public function TryToRegisterUser()
  {
    //get input username and password
    $username           = Input::get('username');
    $password           = Input::get('password');
    $full_name          = Input::get('name');
    $Speciality         = Input::get('speciality');
    $hospital           = Input::get('hospital');
    $gender             = Input::get('gender');
    $email              = Input::get('email');
    $location           = Input::get('location');
    $confirmed_password = Input::get('confirmed_password');

    //create array with user input
    $user_input = array(
        'username'              => $username,
        'password'              => $password,
        'email'                 => $email,
        'name'                  => $full_name,
        'speciality'            => $Speciality,
        'hospital'              => $hospital,
        'gender'                => $gender,
        'password_confirmation' => $confirmed_password,
        'location'              => $location
    );

    //create array with validation rules
    $rules = array(
        'username'              => 'required|unique:users',
        'password'              => 'required|min:6|confirmed',
        'email'                 => 'required|email|unique:users',
        'password_confirmation' => 'required',
        'name'                  => 'required',
        'speciality'            => 'required',
        'hospital'              => 'required',
        'gender'                => 'required',
        'location'              => 'required'
    );

    //validate user input
    $validator = Validator::make(
        $user_input, $rules
    );

    //if validation fails
    if ($validator->fails())
    {
      //take user back to registration page with error messages
      return Redirect::route('register')->withInput()->withErrors($validator);
    }

    //create new user in database
    $now            = date('Y-m-d H:i:s');
    $user           = new User;
    $user->username = $username;

    //hash user password
    $user->password         = Hash::make($password);
    $user->email            = $email;
    $user->account_type     = 'member';
    $user->status           = 'inactive';
    $user->Location         = $location;
    $user->about_me         = '';
    $user->full_name        = $full_name;
    $user->current_hospital = $hospital;
    $user->speciality       = $Speciality; //add 1 becoz the array of specialities on the register page starts from 0
    $user->gender           = $gender;
    $user->name_of_pic      = 'guest.png';
    $user->created_at       = $now;
    $user->updated_at       = $now;
    $user->save();

    //authenticate user
    Auth::login($user);

    //get approval setting
    $approval_required   = Setting::where('name', '=', 'approval')->first();
    $send_email_required = Setting::where('name', '=', 'send_email')->first();

    //if  approval by admin is needed
    if ((($approval_required->value) === 'Yes'))
    {
      //change user status
      Auth::user()->status = 'awaiting_approval';

      //save changes
      Auth::user()->save();

      //log him out
      Auth::logout();

      //redirect with sorry message
      return Redirect::route('login')->with('flash_notice', 'Sucess!! Your new account is awaiting approval by an admin.Try again later');
    }

    //if sending a confirmation email is necessary
    else if (($send_email_required->value) === 'Yes')
    {
      //send user a confirmation email
      Utilities::SendConfirmationEmail(Auth::user());

      //change user status
      Auth::user()->status = 'awaiting_confirmation';

      //save changes
      Auth::user()->save();

      //log him out
      Auth::logout();

      return Redirect::route('login')->with('flash_notice', 'You Need to Confirm your email first before logging in.Check Your email for a confirmation link');
    }

    //if admin approval is not required and email confirmation is not required
    else
    {
      //change users status to active
      Auth::user()->status = 'active';

      //save changes
      Auth::user()->save();

      //take user to conversations page
      return Redirect::route('conversations')->with('flash_notice', 'You have sucessfully logged in for the first time');
    }
  }

  public function Test()
  {
    $user = User::find(1);
    echo $user . '<br/>';
    Utilities::SendConfirmationEmail($user);
    return 'email_sent= sucess<br/>';
  }

  //GIVEN A USER ID THIS RETURNS THE ID OF THE USER
  public function GetAUsersProfile()
  {
    //get id of user whose profile they want
    $user_id = Input::get('id');

    //data to validate
    $data = array(
        'id' => $user_id
    );

    //validation rules
    $rules = array(
        'id' => 'required|Integer'
    );

    //validate data
    $validator = Validator::make($data, $rules);


    //if validation fails
    if ($validator->fails())
    {
      //take user to safe page and tell hime bad news
      return Redirect::route('conversations')->withErrors('Sorry but we cant find the user');
    }

    //else find user with given id
    $user = User::find($user_id);

    //if no user found
    if ($user == null)
    {
      //take user to safe page and tell hime bad news
      return Redirect::route('conversations')->withErrors('Sorry but we cant find the user');
    }

    $time_elapsed = $this->TimeElapsed($user->updated_at);

    //create his profile page
    return View::make('layouts.profile')->with('user', $user)->with('time_elapsed', $time_elapsed);
  }

  //GIVEN AN ID OF THE USER THIS RETURNS THE USERS SETTINGS
  public function GetAUsersSettings()
  {
    //get id of user whose profile they want
    $user_id = Input::get('id');

    //data to validate
    $data = array(
        'id' => $user_id
    );

    //validation rules
    $rules = array(
        'id' => 'required|Integer'
    );

    //validate data
    $validator = Validator::make($data, $rules);


    //if validation fails
    if ($validator->fails())
    {
      //take user to safe page and tell hime bad news
      return Redirect::route('conversations')->withErrors('Sorry but we cant find the user');
    }

    //else find user with given id
    $user = User::find($user_id);

    //if no user found
    if ($user == null)
    {
      //take user to safe page and tell hime bad news
      return Redirect::route('conversations')->withErrors('Sorry but we cant find the user');
    }


    $time_elapsed = $this->TimeElapsed($user->updated_at);

    $all_specialities = Speciality::all();

    $specialities = array();

    foreach ($all_specialities as $speciality)
    {
      $specialities[$speciality->speciality] = $speciality->speciality;
    }
    //create his settings page
    return View::make('layouts.settings')->with('user', $user)->with('time_elapsed', $time_elapsed)->with('specialities', $specialities);
  }

  //THIS RETURNS A VIEW WITH ALL POSTS IN A GIVEN CONVERSATION
  public function GetPostsInConversation()
  {
    //get the id of the conversation 
    $conversation_id = Input::get('id');

    //store conversation id in session
    Session::put('conversation_id', $conversation_id);

    //get all the posts in the conversation
    $posts = Post::orderBy('created_at', 'asc')->where('conversation_id', '=', $conversation_id)->get();

    $users = array();

    foreach ($posts as $post)
    {
      //get id of user who made post
      $user_id = $post->user_id;

      //get user
      $user = User::find($user_id);

      //if no user found which is rare
      if ($user == null)
      {
        continue;
      }

      //add user to array
      array_push($users, $user);
    }
    //create a view with all the posts
    return View::make('layouts.posts')->with('posts', $posts)->with('id', $conversation_id)->with('users', $users);
  }

  //RETURNS THE POST THE USER HAS SELECTED TO EDIT
  public function GetPostToEdit()
  {
    //get the post id
    $post_id = Input::get('id');

    //validate the data
    $validator = Validator::make(array('id' => $post_id), array('id' => 'required|Integer'));

    //if the validator fails
    if ($validator->fails())
    {
      //send him back where ever he came from with errors
      return Redirect::back()->withErrors($validator);
    }

    //get the post 
    $post = Post::find($post_id);

    if ($post != NULL)
    {
      //get user who created post
      $user_id = $post->user_id;
      $user    = User::find($user_id);

      //if he isnt null
      if ($user != NULL)
      {
        //send him to edit page
        $posts = array($post);
        $users = array($user);
        return View::make('layouts.edit')->with('posts', $posts)->with('users', $users);
      }

      //send him back where ever he came from with errors
      return Redirect::back()->withErrors('Failed to find user associated with Post');
    }
    //send him back where ever he came from with errors
    return Redirect::back()->withErrors('Failed to find Post');
  }

  //THIS ATTEMPTS TO ADD A USERS POST TO A CONVERSATION
  public function TryToPostToConversation()
  {
    //create new post
    $post = new Post;

    //get user input
    $reply = Input::get('reply');

    //validate user reply
    $validator = Validator::make(
        array('reply' => $reply), array('reply' => 'required')
    );

    //if validation fails
    if ($validator->fails())
    {

      //return user to posts page and show errors
      return Redirect::back()->withErrors($validator);
    }

    //if user has uploaded an attachment
    if (Input::file('attachment') != null)
    {

      //get attachment
      $file = Input::file('attachment');

      //get file destination
      $destination = 'attachments/';

      //rename file
      $file_name = str_random(6) . '_' . $file->getClientOriginalName();

      //move file to destination
      $upload_sucess = $file->move($destination, $file_name);

      //save attachment
      $post->name_of_attachment = $file_name;
    }
    else
    {
      $post->name_of_attachment = '';
    }

    //get conversation id from session
    $conversation_id = Session::get('conversation_id');

    //create new post obj
    $now                   = date('Y-m-d H:i:s');
    $post->content         = $reply;
    $post->user_id         = Auth::user()->id;
    $post->conversation_id = $conversation_id;
    $post->link_to_video   = '';
    $post->created_at      = $now;
    $post->updated_at      = $now;

    //save post in database
    $post->save();

    //update user last active coloum
    Auth::user()->updated_at = $now;

    //save changes
    Auth::user()->save();

    //redirect user
    return Redirect::route('posts', array('id' => $conversation_id));
  }

  //THIS ATTEMPTS TO EDIT A USERS POST IN A CONVERSATION
  public function TryToEditPost()
  {
    //get user input
    $post_id  = Input::get('id');
    $new_post = Input::get('reply');

    //data to validate
    $data = array(
        'id'      => $post_id,
        'content' => $new_post
    );

    //validation rules
    $rules = array(
        'id'      => 'required|Integer',
        'content' => 'required'
    );

    //if validator fails
    $validator = Validator::make($data, $rules);

    //if validation fails
    if ($validator->fails())
    {
      //send user back from were ever he came from with erros
      return Redirect::back()->withInput()->withErrors($validator);
    }

    //get the post 
    $post = Post::find($post_id);

    //if post is not null 
    if ($post != NULL)
    {
      //update post content
      $now              = date('Y-m-d H:i:s');
      $post->content    = $new_post;
      $post->updated_at = $now;

      //save changes
      $post->save();

      //redirect user
      $conversation_id = Session::get('conversation_id');
      return Redirect::route('posts', array('id' => $conversation_id))->with('id', $conversation_id)->with('flash_notice', 'Post Updated');
    }

    //send user back from were ever he came from with erros
    return Redirect::back()->withInput()->withErrors('Failed to Update Post');
  }

  //THIS DELETES A POST FROM A CONVERSATION
  public function DeletePost()
  {
    //get id of post
    $post_id = Input::get('id');

    //validate id
    $validator = Validator::make(array('id' => $post_id), array('id' => 'required|Integer'));

    //if validation fails
    if ($validator->fails())
    {
      //send user back to whatever page he came from with errors
      return Redirect::back()->withErrors($validator);
    }

    //find the post
    $post = Post::find($post_id);

    //if post isnt null
    if ($post != NULL)
    {
      //get id of user who created post
      $user_id = $post->user_id;

      //make sure that the user who is deleting is the one currently logged in
      if ($user_id == (Auth::user()->id) || (Auth::user()->account_type) === 'Administrator')
      {
        //delete post
        $post->delete();

        //redirect user to posts page
        $conversation_id = Session::get('conversation_id');
        return Redirect::route('posts', array('id' => $conversation_id))->with('id', $conversation_id)->with('flash_notice', 'Post deleted successfully');
      }
    }

    //redirect user back from wherever he came from with errors
    return Redirect::back()->withErrors('Failed to delete Post');
  }

  //THIS RETURNS A VIEWTO ENABLE USER TO CHANGE HIS PASSWORD OR EMAIL
  public function showChangePasswordOrEmailView()
  {
    //get id of user whose profile they want
    $user_id = Input::get('id');

    //data to validate
    $data = array(
        'id' => $user_id
    );

    //validation rules
    $rules = array(
        'id' => 'required|Integer'
    );

    //validate data
    $validator = Validator::make($data, $rules);


    //if validation fails
    if ($validator->fails())
    {
      //take user to safe page and tell hime bad news
      return Redirect::route('conversations')->withErrors('Sorry but we cant find the user');
    }

    //else find user with given id
    $user = User::find($user_id);

    //if no user found
    if ($user == null)
    {
      //take user to safe page and tell hime bad news
      return Redirect::route('conversations')->withErrors('Sorry but we cant find the user');
    }


    $time_elapsed = $this->TimeElapsed($user->updated_at);

    //create his settings page
    return View::make('layouts.changePasswordOrEmail')->with('user', $user)->with('time_elapsed', $time_elapsed);
  }

  //THIS ATTEMPTS TO SAVE THE USERS NEW PASSWORD AND OR EMAIL
  public function TryToUpdateEmailOrPassword()
  {
    $old_password = Input::get('old_password');
    $new_password = Input::get('new_password');
    $new_email    = Input::get('email');


    //data to be validated
    $data = array(
        'old_password' => $old_password,
        'new_password' => $new_password,
        'email'        => $new_email
    );


    //validation rules
    $rules = array(
        'old_password' => 'required|min:6',
        'new_password' => 'min:6',
        'email'        => 'required|email'
    );

    //create validator
    $validator = Validator::make($data, $rules);

    //if validation fails
    if ($validator->fails())
    {
      //take him back to settings page with error message
      return Redirect::back()->withInput()->withErrors($validator);
    }

    //check to see if the old password matches the one in the database
    if (!Hash::check($old_password, Auth::user()->password))
    {
      //redirect back to settings page with error message
      return Redirect::back()->withInput()->withErrors('Your Old Password is incorrect');
    }

    //update user profile
    Auth::user()->password = Hash::make($new_password);
    Auth::user()->email    = $new_email;
    Auth::user()->save();

    //redirect to change password or email page with sucess message
    return Redirect::back()->with('flash_notice', 'Details Saved');
  }

  //THIS ATTEMPTS TO UPDATE THE USERS PROFILE WITH THE NEW INFO INCLUDING PROFILE PIC LOC AND ABOUT ME DATA
  public function TryToUpdateUserProfile()
  {
    //if user has uploaded an image
    if (Input::hasFile('image'))
    {
      //get image
      $file = Input::file('image');

      //create validation for image
      $validator = Validator::make(
          array('image' => $file), array('image' => 'image')
      );

      //if validation fails
      if ($validator->fails())
      {
        //take user back and display errors
        return Redirect::back()->withInput()->withErrors($validator);
      }

      //get file destination
      $destination = 'images/';

      //rename file
      $file_name = str_random(6) . '_' . $file->getClientOriginalName();

      //move file to destination
      $upload_sucess = $file->move($destination, $file_name);

      //update user profile pic path
      Auth::user()->name_of_pic = $file_name;
    }

    //get user input
    $location   = trim(Input::get('location'));
    $about      = trim(Input::get('about_me'));
    $hospital   = trim(Input::get('hospital'));
    $gender     = trim(Input::get('gender'));
    $speciality = trim(Input::get('speciality'));
    $name       = trim(Input::get('name'));


    //data to validate
    $data = array(
        'location'   => $location,
        'about'      => $about,
        'hospital'   => $hospital,
        'gender'     => $gender,
        'speciality' => $speciality,
        'name'       => $name
    );

    //validation rules
    $rules = array(
        'location'   => 'required',
        'hospital'   => 'required',
        'gender'     => 'required',
        'speciality' => 'required|min:1',
        'name'       => 'required'
    );

    //valiadte the data
    $validator = Validator::make($data, $rules);

    //if validation fails
    if ($validator->fails())
    {
      //redirect user with error message    
      // back to his settings page
      return Redirect::back()->withErrors($validator);
    }


    //update user profile
    Auth::user()->Location         = $location;
    Auth::user()->about_me         = $about;
    Auth::user()->current_hospital = $hospital;
    Auth::user()->gender           = $gender;
    Auth::user()->speciality       = $speciality;
    Auth::user()->full_name        = $name;
    Auth::user()->save();

    //redirect user to settings page with sucess message
    return Redirect::back()->with('flash_notice', 'Details Saved');
  }

  //THIS IS SETS A USERS ACCOUNT STATUS TO ACTIVE
  public function ConfirmUserAccount()
  {
    //get id of user whose profile they want
    $user_id = Input::get('id');

    //data to validate
    $data = array(
        'id' => $user_id
    );

    //validation rules
    $rules = array(
        'id' => 'required|Integer'
    );

    //validate data
    $validator = Validator::make($data, $rules);


    //if validation fails
    if ($validator->fails())
    {
      //take user to safe page and tell him the bad news
      return Redirect::route('conversations')->withErrors('Sorry but the user doesnt have an account here');
    }

    //else find user with given id
    $user = User::find($user_id);

    if ($user != NULL)
    {
      //change user status
      $user->status = 'active';

      //save changes in database
      $user->save();
    }

    return redirect::route('login')->with('flash_notice', 'Welcome,Login to get started');
  }

  //RETURNS A VIEW DETAILING THE USERS ACTIVITIES
  public function GetAMembersActivities()
  {
    //get id of user whose profile they want
    $user_id = Input::get('id');

    //data to validate
    $data = array(
        'id' => $user_id
    );

    //validation rules
    $rules = array(
        'id' => 'required|Integer'
    );

    //validate data
    $validator = Validator::make($data, $rules);


    //if validation fails
    if ($validator->fails())
    {
      //take user to safe page and tell hime bad news
      return Redirect::route('conversations')->withErrors('Sorry but we cant find the user');
    }

    //else find user with given id
    $user = User::find($user_id);

    //if no user found
    if ($user == null)
    {
      //take user to safe page and tell hime bad news
      return Redirect::route('conversations')->withErrors('Sorry but we cant find the user');
    }


    $time_elapsed = $this->TimeElapsed($user->updated_at);

    $posts = Post::where('user_id', '=', $user_id)->get();


    foreach ($posts as $post)
    {
      $conversation = Conversation::find($post->conversation_id);
      if ($conversation != null)
      {
        $post->conversation_id = $conversation->title;
      }
    }

    return View::make('layouts.activity')->with('user', $user)->with('time_elapsed', $time_elapsed)->with('posts', $posts);
  }

  //FINDS THE TIME ELAPSED FROM SPECIFIED DATE
  public static function TimeElapsed($date)
  {
    $now = date('Y-m-d H:i:s');
    return UserController::TimeDifference($now, $date);
  }

  //RETURNS TEXT INDICATING THE TIME BETWEEN 2 DATES RANGING FROM SECONDS TO DAYS TO YEARS
  public static function TimeDifference($from_date, $to_date)
  {

    $year_1    = substr($from_date, 0, 4);
    $months_1  = substr($from_date, 5, 2);
    $days_1    = substr($from_date, 8, 2);
    $hours_1   = substr($from_date, 11, 2);
    $minutes_1 = substr($from_date, 14, 2);
    $seconds_1 = substr($from_date, 17, 2);

    $years_2   = substr($to_date, 0, 4);
    $months_2  = substr($to_date, 5, 2);
    $days_2    = substr($to_date, 8, 2);
    $hours_2   = substr($to_date, 11, 2);
    $minutes_2 = substr($to_date, 14, 2);
    $seconds_2 = substr($to_date, 17, 2);

    $universal_time_1 = date('U', mktime($hours_1, $minutes_1, $seconds_1, $months_1, $days_1, $year_1));
    $universal_time_2 = date('U', mktime($hours_2, $minutes_2, $seconds_2, $months_2, $days_2, $years_2));

    //calculate seconds between 2 days
    $calculate_seconds = (int) ($universal_time_1 - $universal_time_2);

    //if the seconds are less than a minute
    if ($calculate_seconds <= 60)
    {
      return 'A few seconds Ago';
    }

    //Number of minutes between 2 dates
    $calculate_minutes = (int) ($calculate_seconds / 60);

    //if the minutes are less than an hour
    if ($calculate_minutes <= 60)
    {
      if ($calculate_minutes == 1)
      {
        return '1 minute ago';
      }
      return 'About ' . $calculate_minutes . ' minutes ago';
    }

    //Number of hours between 2 dates
    $calculate_hours = (int) ($calculate_minutes / 60);

    //if the hours are less than a day
    if ($calculate_hours <= 24)
    {
      if ($calculate_hours == 1)
      {
        return '1 hour ago';
      }
      return 'About ' . $calculate_hours . ' hours ago';
    }


    //Number of days between the 2 dates
    $calculate_days = (int) ($calculate_hours / 24);

    if ($calculate_days == 1)
    {
      return 'yesterday';
    }
    return $calculate_days . ' days ago';
  }

  //THIS USES A GIVEN SEARCH TERM TO LOOK FOR A MATCH IN CONVERSATIONS TABLE
  public function SearchConversations()
  {
    //get search term
    $criteria = Input::get('search_term');

    //data to validate
    $data = array(
        'search_term' => $criteria
    );

    //validation rules
    $rules = array(
        'search_term' => 'required'
    );

    //validate data
    $validator = Validator::make($data, $rules);

    //if valiadation fails
    if ($validator->fails())
    {
      //take user bck to conversations page with error
      return Redirect::back()->withErrors($validator);
    }

    //search for conversations mtching search term in database
    $conversations = Conversation::where('title', 'like', '%' . $criteria . '%')->get();

    if (count($conversations) > 0)
    {
      return View::make('layouts.conversations')->with('conversations', $conversations)->with('flash_notice', 'Results For : ' . $criteria);
    }
    else
    {
      return Redirect::back()->withErrors('Your Search Has Returned No results');
    }
  }

  //THIS USES A GIVEN SEARCH TERM TO LOOK FOR A MATCH IN POSTS TABLE
  public function SearchPosts()
  {
    //get conversation id from session
    $conversation_id = Session::get('conversation_id');

    //get search term enetered
    $criteria = Input::get('search_term');

    //data to validate
    $data = array(
        'search_term' => $criteria,
        'id'          => $conversation_id
    );

    //valiadtion rules
    $rules = array(
        'search_term' => 'required',
        'id'          => 'required|Integer'
    );

    //validate data
    $validator = Validator::make($data, $rules);

    //if validation fails
    if ($validator->fails())
    {
      //take user back to posts page with errors
      return Redirect::back()->withErrors($validator);
    }

    //get all posts matching search term
    $posts = Post::where('conversation_id', '=', $conversation_id, 'and')
        ->where('content', 'like', '%' . $criteria . '%')->get();

    $users = array();

    //for each post get the user who created it
    foreach ($posts as $post)
    {
      //get id of user who made post
      $user_id = $post->user_id;

      //find the user
      $user = User::find($user_id);

      //if no user found
      if ($user == null)
      {
        //go to next iteration
        continue;
      }

      //push to array
      array_push($users, $user);
    }
    if (count($posts) > 0)
    {
      //create view with the results
      return View::make('layouts.posts')->with('posts', $posts)->with('users', $users)->with('id', $conversation_id)->with('flash_notice', 'Search Results for : ' . $criteria);
    }
    else
    {
      return Redirect::back()->withErrors('Your Search Has Returned No results');
    }
  }

}
