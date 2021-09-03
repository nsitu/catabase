<?
class Layout{

  // Each page is made up of many different parts.
  // This class holds functions that render various HTML code snippets
  // We call these functions from index.php depending on the user's requests

  // Watch for PHP Output buffering:  ob_start() and ob_get_clean()
  // This allows us to capture HTML snippets and store them in a variable.
  // In this way we can skip an immediate rendering, and instead render everything at the end
  // See also: https://www.php.net/manual/en/function.ob-get-clean.php

  function __construct(){
      global $db;
      $this->db = $db;
      // start off with some default values.
      // we will override these later on.
      $this->title = 'Catabase';
      $this->notices = [];
      $this->warnings = [];

      // the content array starts off empty,
      // then gets populated by various HTML snippets added by other Layout functions.
      // finally it gets rendered by the content() function further down.
      $this->content= [];
  }

  function setTitle($titleText){ $this->title = $titleText; }
  function addContent($newContent){ $this->content[]= $newContent; }
  function addNotice($newNotice){
    if (is_array($newNotice)){
      $this->notices = array_merge($this->notices, $newNotice );
    }
    else{
      $this->notices[]= $newNotice;
    }
  }
  function addWarning($newWarning){
    if (is_array($newWarning)){
      $this->warnings = array_merge($this->warnings, $newWarning );
    }
    else{
      $this->warnings[]= $newWarning;
    }
  }

  function header(){ ?>
    <html>
    <head>
      <title><?=$this->title?></title>
      <link href="favicon.ico" rel="icon" type="image/x-icon" />

      <!-- JQuery https://code.jquery.com/ -->
      <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

      <!-- Bootstrap  https://v5.getbootstrap.com/ -->
      <!-- Bootstrap CSS -->
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-CuOF+2SnTUfTwSZjCXf01h7uYhfOBuxIhGKPbfEJ3+FqH/s6cIFN9bGr1HmAg4fQ" crossorigin="anonymous">


      <link rel="stylesheet" type="text/css" href="assets/css/styles.css?v=4">


      <!-- Bootstrap JavaScript Bundle with Popper.js -->
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-popRpmFF9JQgExhfw5tZT4I9/CI5e2QcuUZPOVXb1m7qUmeR2b50u+YFEYe1wgzy" crossorigin="anonymous"></script>
      <!-- FontAwesome (get your own "Kit" at https://fontawesome.com )-->
      <script src="https://kit.fontawesome.com/5535203e19.js" crossorigin="anonymous"></script>
      <!-- jquery / ajax for the like button.-->
      <script>
        function likepost(post_id){
          $.ajax({ url: "<?=site_root?>?like="+post_id	}).done(function( likes ) {
              $( "#post_" + post_id + " .likes").html( likes );
              $( "#post_" + post_id + " .like_button").toggleClass( "btn-primary" );
          });
        }
      </script>
    </head>
    <body>
<? } // end function header



  // Build a menu bar.
  // This is based on the bootstrap NavBar.
  // https://getbootstrap.com/docs/5.0/components/navbar/
function navigation(){ global $user; ob_start(); ?>
  <nav class="navbar navbar-expand-sm navbar-light fixed-top justify-content-center">

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggler" aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
    </button>
      <a class="navbar-brand pl-2" href="<?= site_root; ?>">catabase.</a>

      <div class="collapse navbar-collapse w-auto" id="navbarToggler">
        <ul class="navbar-nav mt-2 mt-lg-0 justify-content-center">
          <li class="nav-item <?= $this->linkClass( $user->link() ); ?>">
            <a class="nav-link" href="<?= $user->link(); ?>">
              <i class="fas fa-paw"></i> <?= $user->fullName; ?>
            </a>
          </li>
          <li class="nav-item <?= $this->linkClass('?explore'); ?>">
            <a class="nav-link" href="?explore">
              <i class="fas fa-users"></i> Explore
            </a>
          </li>
          <li class="nav-item <?= $this->linkClass('?messages'); ?>">
            <a class="nav-link" href="?messages">
              <i class="fas fa-envelope"></i> Messages <?= $user->getMessageCount(); ?>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="?logout">  <i class="fas fa-sign-out-alt fa-lg"></i> Logout</a>
          </li>
        </ul>
      </div>
  </nav>
  <? $this->content[]= ob_get_clean();
 }

/* If the current url contains the given string
* return "active", for use in CSS. */
// See also: https://www.php.net/manual/en/reserved.variables.server.php
function linkClass($scriptName){
    if (strpos($_SERVER['REQUEST_URI'], $scriptName ) !== false) {
        return 'active';
    }
}


// build the overall layout for the explore section.
function explore($user){ ob_start(); ?>
  <div id="mainContent" class="container">
    <div class="row">
      <div class="col-md-3">
        <?
          $user->displayProfile();   // find this in the User class.
          $user->friendsPanel();    // find this in the User class.
        ?>
      </div>
      <div class="col-md-9">
        <div class="catlist">
          <h2>cats of catabase</h2>
          <?php
            // On the explore section we want all the OTHER cats (not the one who is logged in)
            $users = $this->db->q("SELECT * FROM users WHERE id !='$user->id'");
            while (  $user = $users->fetch_object("User" ) ){
                $user->displayListing(); // find this in the User class.
            }
            ?>
        </div>
      </div>
    </div>
  </div>
<? $this->content[] = ob_get_clean();
}


// build the overall layout logic  for the messages area
function messages(){
  global $user;
  ob_start(); ?>
  <div id="mainContent" class="container">
  	<div class="row">
  		<div class="col-md-3">
        <div class="profile pt-3">
    			<h2 class="mt-3">messaging</h2>
          <!-- Buttons to navigate around the messaging area.  -->
    			<ul style="list-style-type: none; padding: 0px;">
    					<li><a href="?messages=compose"
                class="mb-1 btn btn-secondary <?= $this->linkClass('?messages=compose');?>">
                <i class="fas fa-pen"></i> Compose</a>
              </li>
    					<li><a href="?messages=inbox"
                class="mb-1 btn btn-secondary <?= $this->linkClass('?messages=inbox');?>">
                <i class="fas fa-envelope"></i> Inbox</a>
              </li>
    					<li><a href="?messages=sent"
                class="mb-1 btn btn-secondary <?= $this->linkClass('?messages=sent');?>">
                <i class="fas fa-paper-plane"></i> Sent</a>
              </li>
    			</ul>
    		</div>
  		</div>
  		<div class="col-md-9">
        <div class="catlist">
          <?
            // Here we render the actual content.
            // validate user requests (i.e. only respond to buttons that actually exist )
            if (in_array($_REQUEST['messages'], ['inbox', 'sent', 'compose'])){
              $action = $_REQUEST['messages'];
            }
            else{
              $action = 'inbox';
            }
            // each button has it's own corresponding function .
            // keep scrolling and you'll find them below.

            if ($action == 'compose'){  $this->compose();  }
            elseif ($action == 'inbox'){ $this->inbox(); }
            elseif ($action == 'sent'){ $this->sent(); }

          ?>
        </div>
      </div>
  	</div>
  </div>
<?
 // add this block to the overall layout. It will get rendered at the end.
$this->content[] = ob_get_clean();
}


// build the inbox
function inbox(){
    // note: there is no need for ob_start here, because we already ran ob_start in the messages() function
  global $user; ?>
  <h2>inbox for <?=$user->fullName?></h2>
  <?
    // query for messages addressed TO the logged in user.
    // sort them by the time they were sent.
    $messages = $this->db->q(
            "SELECT * FROM messages
            WHERE to_id = $user->id
            ORDER BY sent_at DESC");
    if ($messages->num_rows > 0){
      while (  $message = $messages->fetch_object("Message") ){
          $message->display();  // find this in the Message class.
      }
    }
    else{ ?>
      <p>No messages to show.</p>
    <? }
 } // end function inbox()

 //build the sent messages area.
 function sent(){
   // note: there is no need for ob_start here, because we already ran ob_start in the messages() function
   global $user; ?>
   <h2>messages sent by <?=$user->fullName?></h2>
   <?
   // query for messages addressed FROM the logged in user.
   // sort them by the time they were sent.
     $messages = $this->db->q(
             "SELECT * FROM messages
             WHERE from_id = $user->id
             ORDER BY sent_at DESC");
     // pass along the desired class name to fetch_object.
     // see also https://www.php.net/manual/en/mysqli-result.fetch-object.php
     while (  $message = $messages->fetch_object("Message")){
         $message->display(); // find this in the Message class.
     }
  }// end function sent()

// build the compose area.
  function compose(){
    // note: there is no need for ob_start here, because we already ran ob_start in the messages() function
    global $user; ?>
    <h2>send a private message</h2>
    <? if (! $user->friends() > 0) { ?>
      <p>To send a message, </a href="?explore">connect with your friends</a>. </p>
    <? } else { ?>
    <form id="message_form" action="<?=site_root?>" method="POST" enctype="multipart/form-data">
      <input type="hidden" name="messages" value="send">
      <input type="hidden" name="from" value="<?=$user->id?>">
      <div class="form-group">
        <label for="to"> To: </label>
        <select class="form-select mb-3" id="to" name="to" >
          <?php foreach ($user->friends() as $friendship){
            $friend = $friendship->friend_of($user->id);
            // if we clicked an envelope button, we already know the recipeint
            // in this case we can  pre-populate the dropdown based on the request.
            // to do this we  mark the requested recipient as "selected"
            $selected = ($_REQUEST['to'] == $friend->id)? 'selected' : '';
            ?>
            <option value="<?=$friend->id?>" <?=$selected?>>
                <?=$friend->fullName?>
            </option>
          <?php }	?>
        </select>
      </div>
      <div class="form-group">
        <textarea class="form-control" id="body" name="body" placeholder="Hey it's me, <?=$user->fullName;?>."></textarea>
      </div>
      <div class="row">
        <div class="col">
          <label class="btn btn-default btn-lg btn-file text-white">
              <i class="fas fa-paperclip" aria-hidden="true"></i> <input onchange="showFileName(this)" type="file" name="attachment" id="attachment" style="display: none;"> <span id="attachment_file_name"></span>
          </label>
          <script>
            function showFileName(elm) {
               var fn = $(elm).val();
               var filename = fn.match(/[^\\/]*$/)[0]; // remove C:\fakename
               $('#attachment_file_name').html(filename);
            }
          </script>
        </div>
        <div class="col text-right">
          <button type="submit" name="send_message" id="send_message" class="btn btn-lg btn-primary mt-2"><i class="fas fa-paper-plane"></i> Send</button>
        </div>
      </div>
    </form>
  <? }
} //end function compose

// build a overall layout for a user profile.
// the particular user is passed along as a parameter
// user-specific sections are rendered in the user class.
function profile($user){ ob_start(); ?>
  <div id="mainContent" class="container">
  	<div class="row">
  		<div class="col-md-3">
  			<?
          // if the user wants to edit the profile show the edit form
          // otherwiser display the profile normally.
          if (isset($_REQUEST['edit'])){
            $user->editProfile();     // find this in the User class
          }
          else{
            $user->displayProfile();   // find this in the User class
          }
          // show the friend list of the requested profile.
  				$user->friendsPanel();      // find this in the User class
  			?>
  		</div>
  		<div class="col-md-9">
        <div class="catlist">
          <?
            $this->meowform();        // form for adding a new meow/post. Scroll down to find it!
    			  $this->meowsBy($user);    // show the posts by the current user.
          ?>
        </div>
      </div>
  	</div>
  </div>
<?
$this->content[]= ob_get_clean();
}

// this is a helper function for building a user profile
function meowsBy($user){  ?>
  <h2>meows by <?=$user->fullName?></h2>
  <?
    // query for posts with the given user as author.
    $posts = $this->db->q(
            "SELECT * FROM posts
            WHERE user_id = $user->id
            ORDER BY id DESC ");
    while (  $post = $posts->fetch_object("Post" ) ){
        $post->display();
    }
 }

// build the newsfeed (i.e. the default / homepage layout)
// it's very similar to the "profile" page,
// it shows  all the latest meows instead of the meows particular to one user.
function newsfeed($user){ ob_start(); ?>
  <div id="mainContent" class="container">
  	<div class="row">
  		<div class="col-md-3">
  			<?
  				$user->displayProfile();
  				$user->friendsPanel();
  			?>
  		</div>
  		<div class="col-md-9">
        <div class="catlist">
          <?
            $this->meowform();
    			  $this->latestMeows($user);  // scroll down to find this helper funciton.
          ?>
        </div>
      </div>
  	</div>
  </div>
<?
$this->content[]= ob_get_clean();
}

// this is a helper function to build the newsfeed.
function latestMeows($user){  ?>
  <h2>meowfeed</h2>
  <?
    $posts = $this->db->q("SELECT * FROM posts WHERE user_id != $user->id ORDER BY id DESC LIMIT 15");
    while (  $post = $posts->fetch_object("Post" ) ){
        $post->display(); /// go look at the post class
    }
}

// render a form for adding a new meow/post
// this is a "helper" function  called by the newsfeed() and profile() functions above
function meowform(){
  global $user;
  ?>
  <form id="meow_form" action="<?=site_root?>" method="POST" enctype="multipart/form-data">
    <!--When adding a new post show the profile of the logged-in user -->
    <input type="hidden" name="profile" value="<?=$user->id?>">
    <h2>post a meow</h2>
    <div class="form-group">
      <textarea class="form-control" id="meow_text" name="meow_text" placeholder="Anything meowable, <?=$user->fullName;?>?"></textarea>
    </div>
    <div class="row">
      <div class="col">
          <!--
          the default file upload element is hidden (display: none)
          It has been  replaced with a paperclip icon from fontawesome.
          see also: https://fontawesome.com/icons/paperclip?style=solid
         -->
        <label class="btn btn-default btn-lg btn-file text-white">
            <i class="fas fa-paperclip" aria-hidden="true"></i> <input onchange="showFileName(this)" type="file" name="meow_file" id="meow_file" style="display: none;"> <span id="meow_file_name"></span>
        </label>
        <script>
          function showFileName(elm) {
             var fn = $(elm).val();
             var filename = fn.match(/[^\\/]*$/)[0]; // remove C:\fakename
             $('#meow_file_name').html(filename);
          }
        </script>
      </div>
      <div class="col text-right">
        <!-- TIP: note how index.php responds to the "meow_button" request -->
        <button type="submit" name="meow_button" id="meow_button" class="btn btn-lg btn-primary mt-2"><i class="fas fa-cat"></i> Meow</button>
      </div>
    </div>
  </form>
<? }

// not currently using this version but it's available if needed.
// note the use of two WHERE ... IN clauses.
function friendsMeows($user){ ob_start(); ?>
  <h2>meows by friends</h2>
  <? $posts = $this->db->q(
        "SELECT * FROM posts
        WHERE user_id IN
          (SELECT user_one_id FROM friendships WHERE user_two_id = $user->id)
        OR user_id IN
          (SELECT user_two_id FROM friendships WHERE user_one_id = $user->id)");
  while (  $post = $posts->fetch_object("Post") ){
      $post->display();
  }
  $this->content[]= ob_get_clean();
}


// build a registration form
// follow the form processing logic on index.php where it listens for the "reg_button"
function regForm(){ ?>
  <form class="mt-2 p-4 text-center" id="regForm" action="<?=site_root?>" method="POST">
    <h2>new account</h2>
    <input class="mt-2 form-control" type="text" name="reg_fullName" placeholder="Name" value="<?=$_SESSION['reg_fullName'] ?? '' ?>" required>
    <input class="mt-2 form-control" type="email" name="reg_email" placeholder="Email" value="<?=$_SESSION['reg_email'] ?? '' ?>" required>
    <input class="mt-2 form-control" type="password" name="reg_password" placeholder="Password" required>
    <input class="mt-2 form-control" type="text" name="reg_quote" placeholder="Favourite Quote" value="<?=$_SESSION['reg_quote'] ?? '' ?>">
    <button  class="mt-4 btn btn-primary" type="submit" name="reg_button">Register</button>
      <p  class="mt-4">
        Already have an account? <a href="#" id="signin" class="signin">Sign in here!</a>
      </p>
  </form>
<? }

// build a login form
// follow the form processing logic on index.php where it listens for a "login_button" request.
function loginForm(){ ?>
  <form class="mt-2 p-4 text-center" id="loginForm" action="<?= site_root ?>" method="POST">
      <h2>login</h2>
      <input class="mt-2 form-control" type="email" name="login_email" placeholder="Email Address" value="<?=$_SESSION['login_email']?>" required>
      <input class="mt-2 form-control" type="password" name="login_password" placeholder="Password">
      <button class="mt-4 btn btn-primary" type="submit" name="login_button">Login</button>
      <p  class="mt-4">
        Need an account? <a href="#" id="signup" class="signup">Register here!</a>
      </p>
  </form>
<? }

// this funciton  builds the general layout logic for onboarding
// note that both forms are rendered
// javascript then shows and hides them with animation.
// note also that warnings and notices are displayed prior to the forms.
// look for "addNotice"  in index.php to see how these get populated.
function onboarding(){ ob_start(); ?>
<div class="container">
  <div class="row">
    <div class="onboarding col-md-6 p-2 mt-5">
  		<h1>catabase.</h1>
  		<?
        $this->notices();
        $this->warnings();
    		$this->loginForm();
        $this->regForm();
      ?>
  	</div>
    <div class="col-md-6">
    </div>
  </div>
</div>
  <!-- jQuery animation  to toggle login and registration forms. -->
	<script>
  	$(document).ready(function() {
  		$("#signup").click(function() {
        $(".alert").slideUp("slow", function(){
          $(this).remove();
        });
  			$("#loginForm").slideUp("slow", function(){
  				$("#regForm").slideDown("slow");
  			});
  		});
  		$("#signin").click(function() {
        $(".alert").slideUp("slow", function(){
          $(this).remove();
        });
  			$("#regForm").slideUp("slow", function(){
  				$("#loginForm").slideDown("slow");
  			});
  		});
  		<? if (isset($_REQUEST['login_form'])){ ?>
        $("#loginForm").show();
        $("#regForm").hide();
      <? }	else { ?>
  			$("#loginForm").hide();
  			$("#regForm").show();
  		<? } ?>
  	});
	</script>
<? $this->content[]= ob_get_clean();
 }  // end function onboarding

 // helper function to build the onboarding section.
  function warnings(){
    if ( empty($this->warnings) )  return; ?>
    <div id="warnings" class="container mt-2">
        <? foreach ( $this->warnings  as $warning ){ ?>
          <div class="alert alert-danger mt-2" role="alert">
              <?= $warning ?>
          </div>
        <? }?>
    </div>
  <? }

// helper function to build the onboarding section.
  function notices(){
    if ( empty($this->notices) )  return; ?>
    <div id="notices" class="container mt-2">
        <? foreach ( $this->notices  as $notice ){ ?>
          <div class="alert alert-success mt-2" role="alert">
              <?= $notice ?>
          </div>
        <? }?>
    </div>
  <? }

// This is where all the page content actually gets rendered.
// note that it is called near the end of index.php
// it is intentional that we leave rendering until the end.
// in this way we can attend to the logic first (and redirect the user if needed)
  function content(){ ?>
      <main id="content" class="container-fluid">
          <?= implode($this->content); ?>
      </main>
  <? }

  // output a footer and closing tags for the site.
  function footer(){ ?>
    <footer class="footer text-white bg-dark p-5 text-muted text-center">
       <div class="container">
         Created with <a class="text-muted" href="https://v5.getbootstrap.com/">Bootstrap</a>, PHP, and MySQL by <a class="text-muted" href="https://www.nsitu.ca">Harold Sikkema</a>. Photo by <a class="text-muted" href="https://unsplash.com/@purzlbaum">Claudio Schwarz</a>.
       </div>
     </footer>
    </body>
    </html>
  <?
  }

}  // end of Layout Class.
?>
