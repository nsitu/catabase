<?
class Post {

	function __construct( $data = NULL){
		global $db;
    $this->db = $db;
		global $user;

  	// Import existing post by provided ID
		if(is_numeric($data)){
			$data = $this->db->q("SELECT * FROM posts WHERE id = '$data'")->fetch_object();
			foreach ($data as $key => $value){  $this->$key = $value; }
		}
		// Setup child object, Assume data already imported, above, or via fetch_object()
		if (is_numeric($this->id) ){
			$this->user = new User( $this->user_id);
		}
		// Construct a new post with logged-in user as author.
		else{
			$this->user = $user;
		}

	}


	// fetch an array of all comments for this post
	function comments(){
		global $user;
		$comments = []; // start with an empty array
		$sql = "SELECT * FROM comments WHERE post_id = '$this->id' ";
		if ( $result = $this->db->q($sql) ){
			while ( $comment = $result->fetch_object("Comment") ){
				$comments[] = $comment;
			}
		}
		else{	echo $this->db->err() ; }
		return $comments;
	}

  function likes(){
    $sql = "SELECT * FROM `likes` WHERE `post_id` = '".$this->id."' ";
    return $this->db->q($sql)->num_rows;
  }

	function submit($body) {
    $body = $this->db->safety($body); // prevent SQL injection
		if($body != "") {
			// prepare post data to be inserted
      $data = [
        'user_id' => $this->user->id,
        'body' => $body,
        'image' => $this->fileName,
        'date_added' => date("Y-m-d H:i:s")
      ];
      // wrap structure with `backticks` and content with regular "quotemarks"
      $columns = '`'.implode('`,`',array_keys($data)).'`';
      $values = '"'.implode('","', $data).'"';
      $sql = "INSERT INTO `posts` ($columns) VALUES ($values) ";
      $result = $this->db->q($sql); // run query
			$this->id = $this->db->iid(); // get last inserted id
		}
	}

	function uploadFile($upload){
		if($upload['name'] != ''){
			$file = strtolower( $upload['name'] );
			$folder = site_root.'assets/images/meows/';
			$destination =  $folder . uniqid() . '_' . basename( $file );
			$fileType = pathinfo($file, PATHINFO_EXTENSION);
			if (in_array($fileType, ["jpg", "jpeg", "png", "gif"] )){
				if(move_uploaded_file($upload['tmp_name'], $_SERVER['DOCUMENT_ROOT'].$destination)) {
					$this->fileName = $destination;
				}
			}
		}
	}

	function niceDate(){
			return $this->db->niceDate( $this->date_added );
	}



	function display(){
		global $user;  ?>
		<div class="meow mb-4">
			<div id="post_<?=$this->id?>" class="row">
	      <div class="col-2">
					<a href="<?=$this->user->link();?>">
							<img src="<?= $this->user->avatar; ?>" class="mr-3" alt="<?=$this->user->username;?>">
					</a>
	      </div>
				<div class="col-10">
					<div class="card">
						<div class="card-header">
					   		<a href="<?=$this->user->link();?>"><?=$this->user->fullName;?></a> <span class="label text-muted">meowed <?= $this->niceDate(); ?></span>
					  </div>

						<? if ($this->image != ''){ ?>
							<img src="<?= $this->image; ?>" class="card-img-top">
						<? } ?>
						<div class="card-body">
							<p class="card-text"><?=$this->body?><p>
						</div>
						<div class="card-footer">
								<div class="likes_area mb-2">
									<? $btnClass = ( $user->likesPost($this) ) ? 'btn-primary' : ''; ?>
									 <button class="like_button btn <?=$btnClass?>" onclick="likepost(<?=$this->id?>);">
										 <i class="fas fa-paw"></i>
									 </button> <span class="likes"><?=$this->likes();?></span>
						 		</div>
							  <div class="comments" class="mt-2">
								 <?php foreach ( $this->comments() as $comment){
										 $comment->display();
								 } ?>
							 	</div>
								 <?php
									 $comment = new Comment( $this);
									 $comment->displayForm();
							 		?>

						</div>
					</div>	<!--end card-->





	      </div>
	    </div>
		</div>
		<?
	}





}

?>
