<?
class Message {

	function __construct( $data = NULL){
		global $db;
		global $user;
    $this->db = $db;

		// Import existing message by provided ID
		if(is_numeric($data)){
			$data = $this->db->q("SELECT * FROM messages WHERE id = '$data'")->fetch_object();
			foreach ($data as $key => $value){  $this->$key = $value; }
		}
		// Setup child objects, Assume data already imported, above, or via fetch_object()
		if (is_numeric($this->id) ){
			$this->from = new User($this->from_id);
      $this->to = new User($this->to_id);
		}
		// Construct a new message with logged-in user as author.
		else{
			$this->from = $user;
		}

	}

	function isRead(){
			return ($this->recieved_at != '')? true : false;
	}
	function isTo($id){
			return ($this->to_id == $id)? true : false;
	}

	function send($to, $body) {
    if (!is_numeric($to)){ return false; }
    $body = $this->db->safety($body); // prevent SQL injection
		if($body != "") {
			// prepare post data to be inserted
      $data = [
        'from_id' => $this->from->id,
        'to_id' => $to,
        'body' => $body,
        'image' => $this->fileName,
        'sent_at' => date("Y-m-d H:i:s")
      ];
      // wrap structure with `backticks` and content with regular "quotemarks"
      $columns = '`'.implode('`,`',array_keys($data)).'`';
      $values = '"'.implode('","', $data).'"';
      $sql = "INSERT INTO `messages` ($columns) VALUES ($values) ";
      $result = $this->db->q($sql); // run query
      if ($result->error) { var_dump($result->error); }
			$this->id = $this->db->iid(); // get last inserted id
		}
    header('Location: '.site_root.'?messages=sent');
	}

  function markAsRead(){
    $now = date("Y-m-d H:i:s");
    $sql = "UPDATE messages SET `recieved_at` = '$now'
            WHERE `id` = '$this->id' ";
    return $this->db->q($sql);
  }

	function uploadFile($upload){
		if($upload['name'] != ''){
			$file = strtolower( $upload['name'] );
			$folder = "/catabase/assets/images/messages/";
      // we can make this more secure
			$destination =  $folder . uniqid() . '_' . basename( $file );
			$fileType = pathinfo($file, PATHINFO_EXTENSION);
      // could open this up to any type of file
      // but this would require effort on the rendering side.
			if (in_array($fileType, ["jpg", "jpeg", "png", "gif"] )){
				if(move_uploaded_file($upload['tmp_name'], $_SERVER['DOCUMENT_ROOT'].$destination)) {
					$this->fileName = $destination;
				}
			}
		}
	}

// See also:  function niceDate in DB.php
	function niceDate(){
			return $this->db->niceDate( $this->sent_at );
	}

	function display(){ global $user; ?>
	<div class="meow mb-4">
		<div id="message_<?=$this->id?>" class="row">
      <div class="col-2">
				<a href="<?=$this->from->link();?>">
						<img src="<?= $this->from->avatar; ?>" class="mr-3" alt="<?=$this->from->username;?>">
				</a>
      </div>
			<div class="col-10">
				<div class="card">
					<div class="card-header">
               <? if (! $this->isRead() && $this->isTo($user->id) ){?>
                 <span class="badge bg-success">New</span>
               <?}?>
				   		 <span class="label text-muted">
                 Sent <?= $this->niceDate(); ?> by
               </span>
               <a href="<?=$this->from->link();?>">
                 <?=$this->from->fullName;?>
               </a>
              <span class="label text-muted"> to </span>
              <a href="<?=$this->to->link();?>">
                 <?= $this->to->fullName; ?>
              </a>
				  </div>

					<? if ($this->image != ''){ ?>
						<img src="<?= $this->image; ?>" class="card-img-top">
					<? } ?>
					<div class="card-body">
						<p class="card-text"><?=$this->body?><p>
					</div>
					<div class="card-footer">
            <? if ($this->isTo($user->id) ) {
              $replyTo = $this->from->id;
            } else{
              $replyTo = $this->to->id;
            }?>
              <form>
               <input type="hidden" name="to" value="<?=$replyTo?>">
  						 <button type="submit" name="messages" value="compose" class="btn btn-primary" ><i class="fas fa-paw"></i> Reply</button>
             </form>

					</div>
				</div>
      </div>
    </div>
	</div>
		<?
    // only mark as read when viewed by the recipient.
    // when viewed in the sender's "sent items" it doesn't count.
    if ($user->id == $this->to->id){
      $this->markAsRead();
    }

	} // end function display

}

?>
