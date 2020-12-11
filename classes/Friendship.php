<?php
class Friendship{

  // This class is used to administer friendships
  // it corresponds a MySQL table with the following columns:
  // user_one_id: Foreign key for the user who requests the friendship
  // user_two_id: Foreign key for the user who confirms the friendship
  // requested_at: time of the request
  // approved_at: time of approval (may be NULL, to indicate not yet approved)


  function __construct( $data = NULL){
    global $db;
    $this->db = $db;

    // Define a friendship by provided array of IDs
		if(is_array($data)){
      $this->user_one_id = $data[0];
      $this->user_two_id = $data[1];
		}
		// Setup child objects, Assume data already imported, above, or earlier via fetch_object()
		if ( is_numeric($this->user_one_id) ){
      $this->user_one = new User(  $this->user_one_id);
      $this->user_two = new User(  $this->user_two_id);
		}
    // Determine the status of the friendship
    $this->status = $this->status();
  }

  function requestedBy(){
    // The user who requests the friendship is designated "user_one"
    return $this->user_one;
  }

  function friend_of($user_id){
    // given the id of one party in the friendship,
    // identify the opposite party.
    return ($user_id == $this->user_one->id)?
           $this->user_two : $this->user_one;
  }

  function status(){
      // Query to discover the status of the friendship

      // you can't be friends with yourself.
      if ($this->user_one->id == $this->user_two->id){    return false;   }

      // there are three possible statuses:
      // "Inactive" - Friendship does not exist
      // "Requested" - Friendship has been requested.
      // "Active" - Friendship has been approved.

      $u1 = $this->user_one->id;
      $u2 = $this->user_two->id;
    	$sql = "SELECT * FROM friendships
              WHERE (user_one_id = '$u1' AND user_two_id = '$u2')
              OR (user_one_id = '$u2' AND user_two_id = '".$u1."') ";
      $result = $this->db->q($sql);
      while ($data = $result->fetch_object() ){
        // Requestor is first; Requestee is second
        $this->user_one = new User( $data->user_one_id);
        $this->user_two = new User( $data->user_two_id);
        if($data->requested_at != NULL){
          if($data->approved_at != NULL){  return 'Active';  }
          return 'Requested';
        }
      }
      return 'Inactive';
  }

  function request(){
    // adds a new friend request to the database.
    // order is significant here, as user_one is the "requestor".
    if ($this->status() == 'Inactive'){
      $sql = "INSERT INTO friendships ".
             "(`user_one_id`,`user_two_id`,`requested_at`,`approved_at`) ".
             "VALUES ".
             "('".$this->user_one->id."', '".$this->user_two->id."', '".date("Y-m-d H:i:s")."', NULL )";
      $result = $this->db->q($sql);
    }
  }

  function approve($user){
    // approve a friend request by setting a date/time
    // for "approved_at" in the database
    // only friendships that have been requested can be approved
    // only the 2nd party can approve a friendship
    $u1 = $this->user_one->id;
    $u2 = $this->user_two->id;
    $now = date("Y-m-d H:i:s");
    if ($this->status() == 'Requested' ){
      if( $user->id == $this->user_two->id ){
        $sql = "UPDATE friendships SET `approved_at` = '$now'
                WHERE (`user_one_id` = '$u1' AND `user_two_id` = '$u2')
                OR (`user_one_id` = '$u2' AND `user_two_id` = '$u1') ";
        return $this->db->q($sql);
      }
    }
  } // end function approved


} //end Class Friendship

?>
