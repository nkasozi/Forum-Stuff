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

    //get the total number of members
    $number_of_members = User::all()->count();

    //get the total number of conversations on going
    $number_of_conversations = Conversation::all()->count();

    //get the total number of posts ever made
    $number_of_posts = Post::all()->count();

    //get the number of new membersin the week
    $new_members_in_wk = $this->NumberOfNewMembersInWeek();
    
    //get the total number of new conversations in the week
    $new_conversations_in_wk = $this->NumberOfNewConversationsInWeek();

    //get the total number of new posts in the week
    $new_posts_in_wk = $this->NumberOfNewPostsInWeek();
    
    //create array for all the stats
    $statistics = array(
        0 => $number_of_members,
        1 => $number_of_conversations,
        2 => $number_of_posts,
        3 => $new_members_in_wk,
        4 => $new_conversations_in_wk,
        5 => $new_posts_in_wk
    );

    //redirect user
    return View::make('layouts.admin.dashboard')->with('statistics', $statistics);
  }

  //RETURNS THE NUMBER OF NEW MEMBERS IN THE WEEK
  public function NumberOfNewMembersInWeek()
  {
    //get all users
    $users = User::all();

    //create array for new member
    $new_members = array();

    //for each user determine if he created within the past week
    foreach ($users as $user)
    {

      if ((Utilities::GetWeeksGoneBy($user->created_at)) <= 1)
      {
        array_push($new_members, $user);
      }
    }
    
    return ''.count($new_members);
  }
  
  //RETURNS THE NUMBER OF NEW CONVERSATIONS IN THE WEEK
  public function NumberOfNewConversationsInWeek()
  {
    //get all users
    $conversations = Conversation::all();

    //create array for new member
    $new_conversations = array();

    //for each user determine if he created within the past week
    foreach ($conversations as $conversation)
    {
     
      if ((Utilities::GetWeeksGoneBy($conversation->created_at)) <= 1)
      {
        array_push($new_conversations, $conversation);
      }
    }
    
    
    return ''.count($new_conversations);
  }

  //RETURNS THE NUMBER OF NEW POSTS IN THE WEEK
  public function NumberOfNewPostsInWeek()
  {
    //get all users
    $posts = Post::all();

    //create array for new member
    $new_posts = array();

    //for each user determine if he created within the past week
    foreach ($posts as $post)
    {
      
      if ((Utilities::GetWeeksGoneBy($post->created_at)) <= 1)
      {
        array_push($new_posts, $post);
      }
    }
    
    return ''.count($new_posts);
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

    //get appearance settings
    $appearance_model = Setting::where('name', '=', 'appearance')->first();

    if ($appearance_model != NULL)
    {
      //update the appearance setting 
      $appearance_model->value = $appearance;

      //save appearance setting
      $appearance_model->save();
    }

    //get forum title setting
    $title_model = Setting::where('name', '=', 'forum_title')->first();

    if ($title_model != NULL)
    {
      //update forum title
      $title_model->value = $forum_title;

      //save forum title
      $title_model->save();
    }

    //get payment duration setting
    $payment_model = Setting::where('name', '=', 'payment_duration')->first();

    if ($payment_model != NULL)
    {
      //update payment duration setting
      $payment_model->value = $payment_duration;

      //save changes
      $payment_model->save();
    }

    //get approval setting
    $approval_model = Setting::where('name', '=', 'approval')->first();

    if ($approval_model != NULL)
    {
      //update the approval setting
      $approval_model->value = $approval;

      //save approval setting
      $approval_model->save();
    }


    if ($speciality != NULL)
    {
      //create a new speciality
      $speciality_model             = new Speciality;
      $now                          = date('Y-m-d H:i:s');
      $speciality_model->speciality = $speciality;
      $speciality_model->created_at = $now;
      $speciality_model->updated_at = $now;

      //save speciality
      $speciality_model->save();
    }

    //get suspesion duration setting
    $suspension_model = Setting::where('name', '=', 'suspension_duration')->first();

    if ($suspension_model != NULL)
    {
      //update the suspension duration setting
      $suspension_model->value = $suspension_duration;

      //save in database
      $suspension_model->save();
    }

    //get send email setting
    $send_email_model = Setting::where('name', '=', 'send_email')->first();

    if ($send_email_model != NULL)
    {
      //update the setting
      $send_email_model->value = $send_email;

      //save changes
      $send_email_model->save();
    }

    //get registration status
    $registration_status_model = Setting::where('name', '=', 'registration')->first();

    if ($send_email_model != NULL)
    {
      //update the setting
      $registration_status_model->value = $registration_status;

      //save changes
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
    $users = User::where('status', '=', 'awaiting_approval')->orWhere('status', '=', 'inactive')->get();

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
    $user = User::find($user_id);

    if ($user != NULL)
    {
      //change his status to active
      $user->status = 'awaiting_confirmation';

      //save changes 
      $user->save();

      //send the user a confirmation email
      Utilities::SendConfirmationEmail($user);
    }

    //redirect user back to approval page
    return Redirect::route('approve')->with('flash_notice', 'Member Approved');
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
    //check if user is an admin
    if (!$this->IsAnAdmin())
    {
      //bye bye sucker
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

      //save attachment
      $post->name_of_attachment = $file_name;
    }


    //get user input
    $title          = Input::get('title');
    $days_to_expiry = Input::get('time');
    $first_post     = Input::get('post');
    $link_to_video  = Input::get('link');


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
      return Redirect::route('new_conversation')->withInput()->withErrors($validator);
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
    $post->link_to_video   = $link_to_video;
    $post->save();


    //return user  to new conversation page and display sucess message
    return Redirect::route('new_conversation')->with('flash_notice', 'New Conversation created');
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

  //ATTEMPTS TO SUSPEND A MEMBER FROM FORUM
  public function TryToSuspendMember()
  {
    //check if user is an admin   
    if (!$this->IsAnAdmin())
    {
      //got u suckers!!
      return Redirect::route('conversations')->withErrors('Sorry But you are not an admin hence cant do this');
    }

    //get user id
    $user_id = Input::get('id');

    //data to validate
    $data = array('id' => $user_id);

    //validation rules
    $rules = array('id' => 'required|Integer');

    //validate data
    $validator = Validator::make($data, $rules);

    //if validation fails
    if ($validator->fails())
    {
      //redirect  admin back to members page with error message
      return Redirect::route('users')->withErrors($validator);
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

    //redirect user back to members page with sucess message
    return Redirect::route('users')->with('flash_notice', 'The User Has Been Suspended');
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

    //data to validate
    $data = array('id' => $conversation_id);

    //validation rules
    $rules = array('id' => 'required|Integer');

    //validate data
    $validator = Validator::make($data, $rules);

    //if valiadtion fails
    if ($validator->fails())
    {
      //redirect back to conversations page with error messages
      return Redirect::route('conversations')->withErrors($validator);
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

    //redirect with sucess message
    return Redirect::route('conversations')->with('flash_notice', 'Conversation deleted');
  }

  public function MakeUserAdmin()
  {
    $admin = Input::get('admin');

    $data = array('admin' => $admin);

    $rules = array('admin' => 'required');

    $validator = Validator::make($data, $rules);

    if ($validator->fails())
    {
      return Redirect::route('users')->withErrors($validator);
    }

    $user = User::where('username', '=', $admin)->orWhere('email', '=', $admin)->first();

    if ($user != NULL)
    {

      $user->account_type = 'Administrator';

      $user->save();

      return Redirect::route('users')->with('flash_notice', $user->username . ' has been made an Administrator at KadicTalks');
    }
    return Redirect::route('users')->withErrors('Sorry but we couldnt find the user[' . $admin . '] associated with the Username/Email');
  }

}
