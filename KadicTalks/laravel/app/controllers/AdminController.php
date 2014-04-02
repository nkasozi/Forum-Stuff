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
    $new_members_in_wk       = 2;
    $new_conversations_in_wk = 2;
    $new_posts_in_wk         = 2;
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

  public function TryToChangeForumSettings()
  {
    //check if user is an admin
    //got u suckers
    if (!$this->IsAnAdmin())
    {
      return Redirect::route('conversations')->withErrors('Sorry But you are not an admin hence cant do this');
    }
  }

  public function GetForumAppearence()
  {
    //check if user is an admin
    //got u suckers
    if (!$this->IsAnAdmin())
    {
      return Redirect::route('conversations')->withErrors('Sorry But you are not an admin hence cant do this');
    }
    return View::make('layouts.admin.appearence');
  }

  //
  public function GetForumSettings()
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
