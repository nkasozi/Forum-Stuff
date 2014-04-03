<?php

class AdminController extends BaseController
{

  // THIS RETURNS COMMON FORUM STATISTICS
  public function GetForumStatistics()
  {
    //check if user is an admin
    //got u suckers
    if (!$this->IsAnAdmin())
    {
      return Redirect::route('conversations')->withErrors('Sorry But you are not an admin hence cant do this');
    }
    
    $number_of_members       = User::all()->count();
    $number_of_conversations = Conversation::all()->count();
    $number_of_posts         = Post::all()->count();
    $new_members_in_wk       = $this->NumberOfNewMembersInWeek();
    $new_conversations_in_wk = $this->NumberOfNewConversationsInWeek();
    $new_posts_in_wk         = $this->NumberOfNewPostsInWeek();
    $statistics              = array(
        0 => $number_of_members,
        1 => $number_of_conversations,
        2 => $number_of_posts,
        3 => $new_members_in_wk,
        4 => $new_conversations_in_wk,
        5 => $new_posts_in_wk
    );
    return View::make('layouts.admin.dashboard')->with('statistics', $statistics);
  }

  public function NumberOfNewMembersInWeek()
  {
    //get all users
    $users = User::all();
    
    //create array for new member
    $new_members=array();
    
    //for each user determine if he created within the past week
   
    foreach ($users as $user)
    {
      if (($this->GetWeeksGoneBy($user->created_at)) == 1)
      {
        array_push($new_members, $user);
      }
      
    }
    return count($new_members);
  }
  
  public function NumberOfNewConversationsInWeek()
  {
    //get all users
    $conversations = Conversation::all();
    
    //create array for new member
    $new_conversations=array();
    
    //for each user determine if he created within the past week
   
    foreach ($conversations as $conversation)
    {
      if (($this->GetWeeksGoneBy($conversation->created_at)) == 1)
      {
        array_push($new_conversations, $conversation);
      }
      
    }
    return count($new_conversations);
  }
  
  public function NumberOfNewPostsInWeek()
  {
    //get all users
    $posts =  Post::all();
    
    //create array for new member
    $new_posts=array();
    
    //for each user determine if he created within the past week
   
    foreach ($posts as $post)
    {
      if (($this->GetWeeksGoneBy($post->created_at)) == 1)
      {
        array_push($new_posts, $post);
      }
      
    }
    return count($new_posts);
  }

  //ATTEMPTS TO SAVE CHANGES IN THE FORUM SETTINGS
  public function TryToChangeForumSettings()
  {
    //check if user is an admin
    //got u suckers
    if (!$this->IsAnAdmin())
    {
      return Redirect::route('conversations')->withErrors('Sorry But you are not an admin hence cant do this');
    }

    //get user input
    $appearance          = Input::get('appearance');
    $forum_title         = Input::get('forum_title');
    $payment_duration    = Input::get('payment_duration');
    $approval            = Input::get('approval');
    $speciality          = Input::get('speciality');
    $send_email          = Input::get('send_email');
    $suspension_duration = Input::get('suspension_duration');
    $registration_status = Input::get('registration');

    //data to validate
    $data = array(
        'appearance'          => $appearance,
        'title'               => $forum_title,
        'payment_duration'    => $payment_duration,
        'approval'            => $approval,
        'send_email'          => $send_email,
        'suspension_duration' => $suspension_duration,
        'registration_status' => $registration_status
    );

    //validation rules
    $rules = array(
        'appearance'          => 'required',
        'title'               => 'required',
        'payment_duration'    => 'required|Integer',
        'approval'            => 'required',
        'send_email'          => 'required',
        'suspension_duration' => 'required|Integer',
        'registration_status' => 'required'
    );

    //validate the data
    $validator = Validator::make($data, $rules);

    //if valiadation fails
    if ($validator->fails())
    {
      //take user back to forum settings page with errors
      return Redirect::back()->withInput()->withErrors($validator);
    }

    //save appearance settings
    $appearance_model = Setting::where('name', '=', 'appearance')->first();
    if ($appearance_model != NULL)
    {
      $appearance_model->value = $appearance;
      $appearance_model->save();
    }

    //save forum title setting
    $title_model = Setting::where('name', '=', 'forum_title')->first();
    if ($title_model != NULL)
    {
      $title_model->value = $forum_title;
      $title_model->save();
    }

    //save payment duration setting
    $payment_model = Setting::where('name', '=', 'payment_duration')->first();
    if ($payment_model != NULL)
    {
      $payment_model->value = $payment_duration;
      $payment_model->save();
    }

    //save approval setting
    $approval_model = Setting::where('name', '=', 'approval')->first();
    if ($approval_model != NULL)
    {
      $approval_model->value = $approval;
      $approval_model->save();
    }

    //create a new speciality
    if ($speciality != NULL)
    {
      $speciality_model             = new Speciality;
      $now                          = date('Y-m-d H:i:s');
      $speciality_model->speciality = $speciality;
      $speciality_model->created_at = $now;
      $speciality_model->updated_at = $now;
      $speciality_model->save();
    }

    //save suspesion duration model
    $suspension_model = Setting::where('name', '=', 'suspension_duration')->first();
    if ($suspension_model != NULL)
    {
      $suspension_model->value = $suspension_duration;
      $suspension_model->save();
    }

    //save send email setting
    $send_email_model = Setting::where('name', '=', 'send_email')->first();
    if ($send_email_model != NULL)
    {
      $send_email_model->value = $send_email;
      $send_email_model->save();
    }

    //save registration status
    $registration_status_model = Setting::where('name', '=', 'registration')->first();
    if ($send_email_model != NULL)
    {
      $registration_status_model->value = $registration_status;
      $registration_status_model->save();
    }

    //take user back to forum settings back with sucess message
    return Redirect::back()->with('flash_notice', 'Changes Saved');
  }

  //RETURNS A VIEW WITH A FORUM SETTINGS
  public function GetForumSettingsView()
  {
    //check if user is an admin
    //got u suckers
    if (!$this->IsAnAdmin())
    {
      return Redirect::route('conversations')->withErrors('Sorry But you are not an admin hence cant do this');
    }
    return View::make('layouts.admin.forum_settings');
  }

  //THIS RETURNS ALL USERS WITH ACCOUNTS ON THE SITE
  public function GetAllMembers()
  {
    //check if user is an admin
    //got u suckers
    if (!$this->IsAnAdmin())
    {
      return Redirect::route('conversations')->withErrors('Sorry But you are not an admin hence cant do this');
    }
    //get all people with accounts
    $users = User::all();
    //redirect admin to members page
    return View::make('layouts.admin.members')->with('users', $users);
  }

  //THIS RETURNS A VIEW WITH ALL THE USERS TO BE APPROVED
  public function GetAllMembersToApprove()
  {
    //check if user is an admin
    //got u suckers
    if (!$this->IsAnAdmin())
    {
      return Redirect::route('conversations')->withErrors('Sorry But you are not an admin hence cant do/view this');
    }
    //get all users whose status is inactive
    $users = User::where('status', '=', 'inactive')->get();
    //redirect admin to approval page
    return View::make('layouts.admin.approve')->with('users', $users);
  }

  // THIS SETS THE USERS ACCOUNT STATUS TO ACTIVE
  public function TryToApproveMember()
  {
    //check if user is an admin
    //got u suckers
    if (!$this->IsAnAdmin())
    {
      return Redirect::route('conversations')->withErrors('Sorry But you are not an admin hence cant do this');
    }

    //get the id of the user to approve
    $user_id = Input::get('id');
    //find the user
    $user    = User::find($user_id);

    if ($user != NULL)
    {
      //change his status to active
      $user->status = 'active';
      //save changes 
      $user->save();
    }
    //get all users whose statud is inactive
    $users = User::where('status', '=', 'inactive')->get();
    //send the user a confirmation email
    $this->SendConfirmationEmail($user);
    //redirect user back to approval page
    return View::make('layouts.admin.approve')->with('users', $users)->with('flash_notice', 'Member Approved');
  }

  // THIS RETURNS ALL MEMBERS WHOSE STATUS IS INACTIVE
  public function GetInactiveMembers()
  {
    $count = User::where('status', '=', 'inactive')->get()->count();
    return $count;
  }

  // THIS RETURNS THE NEW CONVERSATION VIEW
  public function GetNewConversationView()
  {
    if (!$this->IsAnAdmin())
    {
      return Redirect::route('conversations')->withErrors('Sorry But you are not an admin hence cant do this');
    }
    return View::make('layouts.admin.new_conversation');
  }

  // THIS CHECKS IF THE CURRENT USER IS AN ADMIN
  public function IsAnAdmin()
  {
    if (Auth::user()->account_type === 'Administrator')
    {
      return true;
    }
    return false;
  }

  //THIS ATTEMPTS TO CREATE A NEW CONVERSATION
  public function TryToCreateANewConversation()
  {
    //check if user is an admin
    //got u suckers
    if (!$this->IsAnAdmin())
    {
      return Redirect::route('conversations')->withErrors('Sorry But you are not an admin hence cant do this');
    }

    //create a new post for the conversation
    $post = new Post;

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


      $post->name_of_attachment = $file_name;
    }


    //get user input
    $title          = Input::get('title');
    $days_to_expiry = Input::get('time');
    $first_post     = Input::get('post');


    //data to validate
    $data = array(
        'title'       => $title,
        'expiry date' => $days_to_expiry,
        'post'        => $first_post
    );

    //validation rules
    $rules = array(
        'title'       => 'required|unique:conversations',
        'expiry date' => 'required|Integer',
        'post'        => 'required'
    );

    //validate data
    $validator = Validator::make($data, $rules);

    //if validaion fails
    if ($validator->fails())
    {
      //return user back to new conversations page and display error message
      return Redirect::back()->withInput()->withErrors($validator);
    }

    //validation has passed
    //so create new conversation in database
    $conversation                 = new Conversation;
    $conversation->title          = $title;
    $conversation->days_to_expiry = $days_to_expiry;
    $conversation->thread_id      = 1;
    $conversation->save();

    //save the first post into the database
    $now                   = date('Y-m-d H:i:s');
    $post->conversation_id = $conversation->id;
    $post->user_id         = Auth::user()->id;
    $post->content         = $first_post;
    $post->created_at      = $now;
    $post->updated_at      = $now;
    $post->save();


    //return user  to new conversation page and display sucess message
    return Redirect::back()->with('flash_notice', 'New Conversation created');
  }

  //RETURNS TEXT INDICATING THE TIME BETWEEN 2 DATES RANGING FROM SECONDS TO DAYS TO YEARS
  public function TimeDifference($from_date, $to_date)
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

    return $calculate_seconds;
  }

  //RETURNS THE WEEKS THAT HAT HAVE ELAPSED FROM GIVEN DATE
  public function GetWeeksGoneBy($from_date)
  {
    $now               = date('Y-m-d H:i:s');
    $calculate_seconds = $this->TimeDifference($from_date, $now);
    //if the seconds are less than a minute
    if ($calculate_seconds <= 60)
    {
      return 1;
    }

    //Number of minutes between 2 dates
    $calculate_minutes = (int) ($calculate_seconds / 60);

    //if the minutes are less than an hour
    if ($calculate_minutes <= 60)
    {
      return 1;
    }

    //Number of hours between 2 dates
    $calculate_hours = (int) ($calculate_minutes / 60);

    //if the hours are less than a day
    if ($calculate_hours <= 24)
    {
      return 1;
    }


    //Number of days between the 2 dates
    $calculate_days = (int) ($calculate_hours / 24);

    //if the days are less than a week
    if ($calculate_days <= 7)
    {
      return 1;
    }

    return $calculate_days;
  }

  // THIS DELETES A MEMBER FROM THE DATABASE
  public function DeleteMember()
  {
    //check if user is an admin
    //got u suckers
    if (!$this->IsAnAdmin())
    {
      return Redirect::route('conversations')->withErrors('Sorry But you are not an admin hence cant do this');
    }

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

    if ($user != NULL)
    {
      //delete him
      $user->delete();
    }
    //get all posts made by user
    $posts = Post::where('user_id', '=', $user_id)->get();
    //delete each post
    foreach ($posts as $post)
    {
      $post->delete();
    }

    //redirect user with sucess message
    return Redirect::back()->with('flash_notice', 'User deleted sucessfully!!');
  }

  //ATTEMPTS TO SEND CONFIRMATION EMAIL
  public function SendConfirmationEmail($user)
  {
    if ($user == NULL)
    {
      return;
    }
    //send email
    Mail::send('emails.auth.confirmation', array('username' => $user->username, 'id' => $user->id), function($message)use(&$user)
    {
      //attempt to acess the outer var in inner function
      $message->to($user->email, $user->username)->subject('Welcome to the kadic health forum');
    });
  }

  //ATTEMPTS TO SUSPEND A MEMBER FROM FORUM
  public function TryToSuspendMember()
  {
    //check if user is an admin 
    //got u suckers!!
    if (!$this->IsAnAdmin())
    {
      return Redirect::route('conversations')->withErrors('Sorry But you are not an admin hence cant do this');
    }

    //get user id
    $user_id = Input::get('id');

    //validate the data
    $data      = array('id' => $user_id);
    $rules     = array('id' => 'required|Integer');
    $validator = Validator::make($data, $rules);

    //if validation fails
    if ($validator->fails())
    {

      //get all users
      $users = User::all();
      //redirect  admin back to members page with error message
      return Redirect::back()->withErrors($validator);
    }

    //find the user 
    $user = User::find($user_id);

    if ($user != NULL)
    {
      //suspend user
      $user->status = 'suspended';
      //save data in database
      $user->save();
    }
    //get all users
    $users = User::all();

    //redirect user back to members page with sucess message
    return Redirect::back()->with('flash_notice', 'The User Has Been Suspended');
  }

  //ATTEMPTS TO DELETE A CONVERSATION
  public function DeleteConversation()
  {
    //check if user is admin
    //got u suckers!!
    if (!$this->IsAnAdmin())
    {
      return Redirect::route('conversations')->withErrors('Sorry But you are not an admin hence cant do this');
    }

    //get conversation id
    $conversation_id = Input::get('id');

    //valiadate data
    $data      = array('id' => $conversation_id);
    $rules     = array('id' => 'required|Integer');
    $validator = Validator::make($data, $rules);

    //if valiadtion fails
    if ($validator->fails())
    {

      //redirect back to conversations page with error messages
      return Redirect::back()->withErrors($validator);
    }

    //get the conversation
    $conversation = Conversation::find($conversation_id);

    if ($conversation != NULL)
    {
      //delete it
      $conversation->delete();
    }

    //get all posts in conversation
    $posts = Post::where('conversation_id', '=', $conversation_id)->get();
    //delete all posts in conversation
    foreach ($posts as $post)
    {
      $post->delete();
    }
    //get all conversations
    $conversations = Conversation::all();

    //redirect with sucess message
    return View::make('layouts.conversations')->with('conversations', $conversations)->with('flash_notice', 'Conversation deleted');
  }

}
