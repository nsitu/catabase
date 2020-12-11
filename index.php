<?php

// welcome to catabase 

//start managing the user session.
session_start();

define('site_root', '/'.basename(__DIR__).'/');

if( isset($_REQUEST['logout'])){
  session_destroy(); // logout
  header("Location: ?login_form"); //redirect to another page.
}

// autoload all required classes
spl_autoload_register(function ($class) {
    include 'classes/'.$class . '.php';
});

$db = new DB();
$page = new Layout();  // pass $db along so layout can run queries!

//if the user is not logged in, onboard them.
if ( !isset($_SESSION['user_id']) ){
	if ( isset($_REQUEST['reg_button'])){
		$status = $db->register();
		$page->addWarning($status); //warnings show up in red
	}
	if( isset($_REQUEST['login_button'])){
		$status = $db->login();
		$page->addWarning($status);  //warnings show up in red
    $_REQUEST['login_form'] = true; //if the login fails, try again.
	}
	if (isset($_REQUEST['reg_success'])){
    //notices show up in green
		$page->addNotice ('Thanks '.$_REQUEST['reg_success'].', you are now registered!');
	}
	$page->onboarding();
}

else{
  // if the user is logged in track them and provide options.
  // set a global variable to contain the logged in user.
  // this variable can be accessed anywhere via $GLOBALS['user']
	global $user;
	$user = new User( $_SESSION['user_id']);

  // manage bio
  if (isset($_REQUEST['save_profile'])){
		$user->saveProfile();
	}
  //comment: post_id , body: body
  if (isset($_REQUEST['comment'])){
		  $post = new Post ( $_REQUEST['for_post']);
		  $comment = new Comment ( $post );
      $comment->submit($_REQUEST['comment']);
		  $comment->display() ;
      exit; // comments are requested via ajax. no need to render anything else
	}

  // deal with like button.
	if (isset($_REQUEST['like'])){
		  $post = new Post ( $_REQUEST['like']);
		  $like = new Like ( $user, $post);
		  $like->toggle();
		  echo $post->likes();
      exit; // a like is requested via ajax. no need to render anything else
	}
  // process new meows (i.e. posts)
	if(isset($_REQUEST['meow_button'])){
		$post = new Post();
		$post->uploadFile($_FILES['meow_file']);
		$post->submit($_REQUEST['meow_text']);
	}

  // manage friend requests
	if(isset($_REQUEST['friend_button'])){
		$friends = [ $user->id, $_REQUEST['profile'] ];
		$friendship = new Friendship($friends );
		$friendship->request();
	}
  // approve friend requests
	if(isset($_REQUEST['approve_button'])){
		$friends = [ $user->id, $_REQUEST['profile'] ];
		$friendship = new Friendship(  $friends );
		$friendship->approve($user);
	}

  $page->navigation();

  // look for new friends
	if (isset($_REQUEST['explore'])){
		$page->explore($user); // let's no render this until the end.
	}

  // Show messages interface
  elseif (isset($_REQUEST['messages'])){
    if ($_REQUEST['messages'] == 'send'){
      $message = new Message();
  		$message->uploadFile($_FILES['attachment']);
  		$message->send($_REQUEST['to'], $_REQUEST['body']);
    }
    else {
        $page->messages();
    }
  }

  // show a profile of a cat
	elseif (isset($_REQUEST['profile'])){
		//if a profile is requested, show it.
		$someone = new User($_REQUEST['profile']);
		$page->profile($someone);
	}
	else{
		// otherwise show the logged-in user's profile.
		$page->newsfeed($user);
	}

}

// logic before here.
// render

$page->header();
$page->content();
$page->footer();

?>
