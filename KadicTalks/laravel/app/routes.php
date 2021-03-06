<?php

/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register all of the routes for an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the Closure to execute when that URI is requested.
  |
 */

//THIS IS A REQUEST TO SEE ALL CONVERSATIONS IN GOING ON
Route::get('conversations', array('as' => 'conversations', function()
  {

    //get all conversations
    $conversations = Conversation::all();

    //create view to display all conversations
    return View::make('layouts.conversations')->with('conversations', $conversations);
  }));

//THIS IS A REQUEST TO SEE THE HOME PAGE
Route::get('/', array('as' => 'home', function ()
  {
    //get all conversations
    $conversations = Conversation::all();

    //create view to display all conversations
    return View::make('layouts.home')->with('conversations', $conversations);
  }));

//THIS IS A GET REQUEST TO SEE THE LOGIN PAGE
Route::get('login', array('as' => 'login', function ()
  {
    //create login page 
    return View::make('layouts.login');
  }));

//THIS IS A POST REQUEST TO VALIDATE USER CREDENTIALS AND LOG USER IN
Route::post('login', 'UserController@TryToLoginUser');

//THIS IS A REQUEST BY THE USER TO LOGOUT OF HIS ACCOUNT
//HE MUST NOT BE ABLE TO DO THIS BEFORE LOGIN
Route::get('logout', array('uses' => 'UserController@LogUserOut', 'as' => 'logout'))->before('auth');

//THIS IS A REQUEST BY THE USER TO VIEW HIS PROFILE
//HE MAY BE ABLE TO SEE THIS BEFORE LOGIN
Route::get('profile', array('uses' => 'UserController@GetAUsersProfile', 'as' => 'profile'));

//THIS IS A REQUEST BY THE USER TO SEE THE POSTS IN A CONVERSATION
Route::get('posts', array('uses' => 'UserController@GetPostsInConversation', 'as' => 'posts'));

//THIS IS A REQUEST BY THE USER TO Add a new POST IN A CONVERSATION
Route::post('posts', 'UserController@TryToPostToConversation')->before('auth');

//THIS IS A GET REQUEST BY USER TO SEE SIGN UP PAGE
Route::get('register', array('as' => 'register', function ()
  {
  //get all specialities
    $all_specialities=Speciality::all();
    
    //put only the speciality field per object returned into an array
    $specialities=array();
    
    foreach ($all_specialities as $speciality)
    {
      $specialities[$speciality->speciality]=$speciality->speciality;
    }
    
    //create sign up page
    return View::make('layouts.register')->with('specialities',$specialities);
  }));

//THIS IS A POST REQUEST MADE TO CREATE A NEW USER
Route::post('register', 'UserController@TryToRegisterUser');

//THIS IS A GET REQUEST BY USER TO SEE SETTINGS PAGE
Route::get('settings', array('uses' => 'UserController@GetAUsersSettings', 'as' => 'settings'))->before('auth');

//THIS IS A POST REQUEST BY USER TO SAVE SETTINGS 
Route::post('settings', 'UserController@TryToUpdateUserProfile')->before('auth');

//THIS IS A POST REQUEST BY USER TO SAVE SETTINGS 
Route::get('change_password', array('uses' => 'UserController@showChangePasswordOrEmailView', 'as' => 'settings/password'))->before('auth');

//THIS IS A POST REQUEST BY USER TO SAVE SETTINGS 
Route::post('change_password', 'UserController@TryToUpdateEmailOrPassword')->before('auth');

///THIS IS TEST METHOD
Route::get('test', array('uses' => 'UserController@Test', 'as' => 'test'));

///THIS IS A REQUEST CONFIRM AN EMAIL ADDRESS NORMALLY SENT BY A CLICK OF LINK IN CONFIRMATION EMAIL
Route::get('confirmation', array('uses' => 'UserController@ConfirmUserAccount', 'as' => 'confirmation'));

///THIS IS POST REQUEST TO SEARCH THE CONVERSATIONS FOR A TERM
Route::post('search_conversations', array('uses' => 'UserController@SearchConversations'));

//THIS IS GET REQUEST TO SEARCH THE CONVERSATIONS FOR A TERM
Route::get('search_conversations', array('uses' => 'UserController@SearchConversations', 'as' => 'search_conversations'));

//THIS IS GET REQUEST TO SEARCH THE POSTS FOR A PARTICULAR TERM
Route::get('search_posts', array('uses' => 'UserController@SearchPosts', 'as' => 'search_posts'));

///THIS IS POST REQUEST TO SEARCH THE POSTS FOR A PARTICULAR TERM
Route::post('search_posts', array('uses' => 'UserController@SearchPosts'));

//THIS IS REQUEST TO VIEW A MEMBERS ACTIVITIES
Route::get('activity', array('uses' => 'UserController@GetAMembersActivities', 'as' => 'activity'))->before('auth');

//THIS IS REQUEST TO VIEW A MEMBERS ACTIVITIES
Route::get('edit', array('uses' => 'UserController@GetPostToEdit', 'as' => 'edit'))->before('auth');

//THIS IS REQUEST TO VIEW A MEMBERS ACTIVITIES
Route::post('edit', array('uses' => 'UserController@TryToEditPost'))->before('auth');

//THIS IS REQUEST TO VIEW A MEMBERS ACTIVITIES
Route::get('delete_post', array('uses' => 'UserController@DeletePost', 'as' => 'delete_post'))->before('auth');


//THIS IS A REQUEST TO VIEW THE ADMINISTRATION PANEL
Route::get('admin', array('uses' => 'AdminController@GetNewConversationView', 'as' => 'admin'))->before('admin');

//THIS IS REQUEST TO VIEW THE ADMIN DASHBOARD PANEL CONTENT
Route::get('dashboard', array('uses' => 'AdminController@GetForumStatistics', 'as' => 'dashboard'))->before('admin');

//THIS IS REQUEST TO VIEW THE ADMIN MEMBER PANEL CONTENT
Route::get('users', array('uses' => 'AdminController@GetAllMembers', 'as' => 'users'))->before('admin');

//THIS IS REQUEST TO VIEW THE ADMIN NEW CONVERSATION PANEL CONTENT
Route::get('new_conversation', array('uses' => 'AdminController@GetNewConversationView', 'as' => 'new_conversation'))->before('admin');

//THIS IS REQUEST TO CREATE A NEW CONVERSATION
Route::post('new_conversation', array('uses' => 'AdminController@TryToCreateANewConversation'))->before('admin');

//THIS IS REQUEST TO VIEW THE ADMIN FORUM SETTINGS PANEL CONTENT
Route::get('forum_settings', array('uses' => 'AdminController@GetForumSettingsView', 'as' => 'forum_settings'))->before('admin');

//THIS IS REQUEST TO SAVE CHANGES IN FORUM SETTINGS
Route::post('forum_settings', array('uses' => 'AdminController@TryToChangeForumSettings'))->before('admin');

//THIS IS REQUEST TO VIEW THE ADMIN APPROVE MEMBERS PANEL CONTENT
Route::get('approve', array('uses' => 'AdminController@GetAllMembersToApprove', 'as' => 'approve'))->before('admin');

//THIS IS REQUEST TO VIEW THE ADMIN APPROVE MEMBERS PANEL CONTENT
Route::post('approve', array('uses' => 'AdminController@TryToApproveMember', 'as' => 'approve'))->before('admin');

////THIS IS A REQUEST TO DELETE A MEMBER
Route::get('delete', array('uses' => 'AdminController@DeleteMember', 'as' => 'delete'))->before('admin');

///THIS IS REQUEST TO SUSPEND A USER
Route::post('suspend', array('uses' => 'AdminController@TryToSuspendMember', 'as' => 'suspend'))->before('admin');

//THIS IS REQUEST TO DELETE A CONVERSATION
Route::get('delete_conversation', array('uses' => 'AdminController@DeleteConversation', 'as' => 'delete_conversation'))->before('admin');

//THIS IS REQUEST TO MAKE A USER AN ADMIN
Route::post('make_admin', array('uses' => 'AdminController@MakeUserAdmin', 'as' => 'make_admin'))->before('admin');