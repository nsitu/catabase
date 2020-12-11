<?php
class Like{

  function __construct($user, $post){
    global $db;
    $this->db = $db;
    $this->user = $user;
    $this->post = $post;
  }

  function exists(){
    $u = $this->user->id;
    $p = $this->post->id;
    $sql = "SELECT * FROM `likes` WHERE `user_id` = '$u' AND `post_id` = '$p' ";
    if ( $this->db->q($sql)->num_rows > 0 ){ return true; }
    return false;
  }

  function toggle(){
    if ( $this->exists() ){ $this->delete(); }
    else{ $this->save(); }
  }

  function save(){
    $u = $this->user->id;
    $p = $this->post->id;
    $sql = "INSERT INTO `likes` (`user_id`, `post_id`) VALUES ('$u', '$p');";
    $this->db->q($sql);
  }

  function delete(){
    $u = $this->user->id;
    $p = $this->post->id;
    $sql = "DELETE FROM `likes` WHERE `user_id` = '$u' AND `post_id` = '$p' ";
    $this->db->q($sql);
  }

}
?>
