<?php
class User {

	// NOTE: when constructed by fetch_object("User")
	// properties will be loaded automatically in advance

	function __construct( $data = NULL){
    global $db;
		$this->db = $db;

		// Import existing user by provided ID
		if(is_numeric($data)){
			$data = $this->db->q("SELECT * FROM users WHERE id = '$data'")->fetch_object();
			foreach ($data as $key => $value){  $this->$key = $value; }
		}

	}

	// generate a url for this url.
	function link(){
		return  site_root .'?profile='.$this->id;
	}

	// check if this user is logged in.
	function isLoggedIn(){
		global $user;
		return ($user->id == $this->id)? true : false;
	}

	// given another user object, return a Friendship object
	// Note: this does not affect the status of the friendship.
	function friendshipWith($friend){
		$users = [$this->id, $friend->id] ;
		return new Friendship($users);
	}

	// given another user object
	// check if there is an active friendship between this user and the other.
	function isFriendOf($friend){
		$status = $this->friendshipWith($friend)->status();
		if ($status == 'Active') { return true; }
		return false;
	}

	// figure out mow many posts this user has  authored.
	function getPostCount() {
    $sql = "SELECT COUNT(*) AS `post_count` ".
           "FROM `posts` ".
           "WHERE `user_id` = '".$this->id."'";
    $result = $this->db->q($sql);
    $row = $result->fetch_object();
		return $row->post_count;
	}

	// invoked when a user saves their profile.
	// this function updates the database to reflect submitted changes in the profile.
	function saveProfile(){
		$quote = $this->db->safety($_REQUEST['quote']);
		$avatar = $this->db->safety($_REQUEST['avatar']);
		$sql = "UPDATE `users` SET `quote`= '$quote', `avatar` = '$avatar' WHERE `id` = '$this->id'";
		$this->db->q($sql);
		// redirect to the user's profile after changes have been saved.
		header('Location: '.site_root.'?profile='.$this->id);
	}

  // this function generates a sidebar panel for this user.
	function displayProfile(){ global $user;
		?>
		<div class="profile">
			<a class="avatar" href="<?= $this->link(); ?>">
				<img src="<?= $this->avatar; ?>" alt="<?=$this->username;?>">
			</a>
			<h2><a class="catname" href="<?= $this->link(); ?>"><?=$this->fullName;?></a></h2>
			<span class="label">joined:</span>
			<span><?= date( 'M d, Y', strtotime($this->signup_date) ); ?></span>
			<hr/>
			<p class="quote"><i class="fas fa-quote-left"></i> <?=$this->quote;?></p>
			<?php
					if(! $this->isLoggedIn() ){
						// on other profiles show a status button for this relationship
						$this->friendStatusButton();
					}
					else{
						$this->editButton(); // see helper function below.
					}
			 ?>
		</div>
		<?
	}

	// helper function for an edit profile button.
	function editButton(){ ?>
				<a href="<?=site_root?>?profile=<?=$this->id?>&edit" class="btn btn-primary">
					<i class="fas fa-edit"></i>Edit</a>
	<?}

	//display a form for editing the user profile.
	function editProfile(){ global $user;
		?>
		<div class="profile">
			<a class="avatar" href="<?= $this->link(); ?>">
				<img src="<?= $this->avatar; ?>" alt="<?=$this->username;?>">
			</a>
			<h2><a class="catname" href="<?= $this->link(); ?>"><?=$this->fullName;?></a></h2>
			<span class="label">joined:</span>
			<span><?= date( 'M d, Y', strtotime($this->signup_date) ); ?></span>
			<hr/>
			<form action="<?= site_root ?>" method="post" class="p-3">
				<input type="hidden" id="avatar" name="avatar" value="<?=$this->avatar?>">

					<div class="avatars">
						<?php for ($i = 1; $i<17 ; $i++){
								// iterate through a list of numbers and make a button for each one.
								// if the current avatar matches, mark it as selected i.e. "btn-primary"
							$class = ($this->avatar == 'assets/avatars/'.$i.'.png')?
									'btn btn-primary' : 'btn';
							?>
							<button class="avatar-button <?=$class?>" type="button"
								value="<?=$i?>"
								<?=$selected?>
								style="height: 50px; width: 50px; background-image: url('assets/avatars/<?=$i?>.png');">
							</button>
						<?php }	?>
					</div>
					<script>
						// when you click on a button, use jQuery to:
						//  1. set the large profile picture to match.
						//  2. record the number of the chosen avatar in a hidden field to be stored in DB
						//  3. remove the blue "btn-primary" class from all buttons
						//  4. set the blue "btn-primary" class for the clicked button
						$('.avatar-button').on("click", function(e){
							$('.avatar img').attr('src', 'assets/avatars/'+$(e.target).attr('value') +'.png');
							$('#avatar').attr('value', 'assets/avatars/'+$(e.target).attr('value') +'.png' );
							$('.avatar-button').removeClass('btn-primary');
							$(e.target).addClass('btn-primary');
					  });
					</script>

				<div class="form-group py-3">
					<label for="quote" class="text-muted">What's your thing?</label>
					<textarea name="quote" class="form-control" id="quote" rows="3"><?=$this->quote?></textarea>
				</div>
				<div class="form-group">
					<button type="submit" class="btn btn-primary" name="save_profile"><i class="fas fa-save"></i> Save</button>
				</div>
			</form>
		</div>
		<?
	}


	// output a minimal profile for this user
	// to be displayed in the context of the "explore" section.
		function displayListing(){ ?>
			<div class="container userListing mt-2" style="background: rgba(0,0,0,0.1);">
				<div class="row">
					<div class="col-2 mb-4" >
						<img style="width: 100%;" src="<?= $this->avatar; ?>" class="align-self-end mr-3" alt="<?=$this->username;?>">
					</div>
					<div class="col-10">
						<h5 class="mt-2" >
							<a style="color: #fff;" href="<?=$this->link();?>"><?=$this->fullName;?></a>
						</h5>
						<?php
							$this->friendStatusButton();   // button changes depending on the logged in user.
						?>
						<p>
							<span class="label">joined:</span>
							<span><?= date( 'M d, Y', strtotime($this->signup_date) ); ?></span>
						</p>
					</div>
				</div>
			</div>
			<?
		}


// display details about friendships.
// this funciton is called from the user profile.
	function friendsPanel(){
		global $user;

		// if you dont have any friends
		if ( empty($this->friends()) ){
			// link to the explore page but only if you're logged in.
			// if you're not logged in, do nothing.
			if ($this->isLoggedIn() ) { ?>
				<div class="profile pt-3">
					<?= $this->friendRequests();?>
					<h2 class="mt-3">friends</h2>
					<p>Time to <a href="?explore">make some friends</a>.</p>
				</div>
			<?}
		}
		//if you do have friends
		else{ ?>
			<div class="profile pt-3">
				<?
					// show friend requests but only if you're logged in.
					// on other people's profiles, do nothing.
					if($this->isLoggedIn() ){	$this->friendRequests(); }
					$this->friendsList();
				?>
			</div>
		<? }
	}

// generate a list of friends to show in the friends Panel.
// see also the friendLink helper function below
function friendsList(){ ?>
	<h2 class="mt-3">friends</h2>
	<ul style="list-style-type: none; padding: 0px;"><?php
		foreach ($this->friends() as $friendship){
			$friend = $friendship->friend_of($this->id); ?>
			<li>
				<?=$friend->friendLink()?>
			</li>
		<?php }	?>
	</ul>
<? }

// a helper funciton to make a styled link to this user in the context of a list of friends.
function friendLink(){ ?>
	<a class="cat_link" style="background-image: url(<?=$this->avatar;?>);" href="<?=$this->link();?>">
		<?=$this->fullName;?>
	</a>
<? }

// display a friendship action button
// depending on the status of the friendship.
function friendStatusButton(){
	global $user;
	$friendship = $this->friendshipWith($user);
	$status = $friendship->status();
	if ($status == 'Active') {
		echo $this->activeButton();
	}
	elseif ($status == 'Requested'){
		// show either an "approve" or "pending" button
		// depending on whether this user is the requestor or requestee.
	 	echo ( $this->id == $friendship->requestedBy()->id) ?
		 $this->approveButton() : $this->pendingButton();
	}
	elseif ($status == 'Inactive'){
		echo $this->friendButton();
	}
}

// count how many unread messages  this user has.
// generate a bold number in brackets to return in the context of the nav bar.
function getMessageCount(){
    $sql = "SELECT COUNT(*) AS `message_count`
						FROM `messages`
						WHERE `to_id` = '$this->id'
						AND `recieved_at` IS NULL ";

    $result = $this->db->q($sql);
    $row = $result->fetch_object();
		if ($row->message_count > 0 ){
			return '<b>('.$row->message_count.')</b>';
		}
		return '';
}

// A button to indicate an active friendship
function activeButton(){ ob_start(); ?>
	<button type="button" class="btn btn-success">
			<i class="fas fa-check"></i><i class="fas fa-user-friends"></i> Friends
	</button>
	<a class="btn btn-primary" href="?messages=compose&to=<?=$this->id?>"><i class="fas fa-envelope"></i></a>
<? return ob_get_clean();
}

// button to request a friendship with this user
function friendButton(){ ?>
	<form action="<?= site_root ?>">
			<input type="hidden" name="profile" value="<?=$this->id?>">
			<div class="form-group">
			<button name="friend_button" type="submit" class="btn btn-primary">
				<i class="fas fa-user-friends"></i>+ Add Friend
			</button>
			</div>
	</form>
<? }

// a button to indicate a "pending" status for a friendship with this user
function pendingButton(){
	return '<button type="button" class="btn btn-warning">'.
		'<i class="fas fa-user-friends"></i>+ Pending Approval'.
		'</button>';
}

// button to approve a friend request from this user
function approveButton(){
	?>
	<form action="<?= site_root ?>">
			<input type="hidden" name="profile" value="<?=$this->id?>">
			<div class="form-group">
			<button name="approve_button" type="submit" class="btn btn-primary btn-success">
				<i class="fas fa-user-friends"></i>+ Approve
			</button>
			</div>
	</form>
	<?php
}

// show a list of friend requests pending approval for this user
// THE USER MUST BE LOGGED IN
function friendRequests(){
	if ($this->username != $_SESSION['username']) return;

	$sql = "SELECT * FROM friendships
			WHERE user_two_id = '$this->id'
			AND requested_at IS NOT NULL
			AND approved_at IS NULL ";

	$requests = $this->db->q($sql);
	if ($requests->num_rows > 0){
		?> <h2>friend requests</h2> <?php

		while (  	$friendship = $requests->fetch_object("Friendship")){
        $friend = $friendship->friend_of($this->id);
				$friend->friendLink();
	 		  $friend->approveButton();
    }
	}
}

	// return an array of all approved friendships
	function friends(){
		$friends = []; // start with an empty array
		$sql = "SELECT * FROM friendships
					WHERE (user_one_id = '$this->id' OR user_two_id = '$this->id' )
					AND approved_at IS NOT NULL ";

		if ( $friendships = $this->db->q($sql) ){
			while ( $friendship = $friendships->fetch_object("Friendship") ){
        $friends[] = $friendship;
      }
		}
		else{	echo $this->db->err() ; }
		return $friends;
	}

		// given a post determine whether this user likes it or not.
    function likesPost($post){
      $like = new Like($this, $post);
      return $like->exists();
    }

}

?>
