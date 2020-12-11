<?
class Comment {

	function __construct( $data = NULL){
    global $db;
    $this->db = $db;
    global $user;

		// NOTE: when using fetch_object properties are loaded automatically

    // Import existing comment by provided ID
    if(is_numeric($data)){
      $data = $this->db->q("SELECT * FROM comments WHERE id = '$data'")->fetch_object();
      foreach ($data as $key => $value){  $this->$key = $value; }
    }

    // Construct a new commment based on a parent post
    if(is_object($data) && get_class($data) == "Post"   ){
      $this->post = $data;
      $this->post_id = $data->id;
      $this->user = $user;
      $this->user->id = $user->id;
    }
    // Setup child objects, Assuming data already imported, above, or via fetch_object()
		else {
			$this->user = new User($this->user_id);
      $this->post = new Post($this->post_id);
		}

	}


	function submit($body) {
    $this->body = $this->db->safety($body); // prevent SQL injection
		if($body != "") {
			// prepare post data to be inserted
      $data = [
        'user_id' => $this->user->id,
				'post_id' => $this->post->id,
        'body' => $this->body,
        'posted_at' => date("Y-m-d H:i:s")
      ];
      // wrap structure with `backticks` and content with regular "quotemarks"
      $columns = '`'.implode('`,`',array_keys($data)).'`';
      $values = '"'.implode('","', $data).'"';
      $sql = "INSERT INTO `comments` ($columns) VALUES ($values) ";
      $result = $this->db->q($sql); // run query
			$this->id = $this->db->iid(); // get last inserted id
		}
	}

	function niceDate(){
		return $this->db->niceDate( $this->posted_at );
	}

	function display(){ 
		//remove slashes so that javascript will render text output properly
		$commentText = stripslashes ( $this->body ); ?>
		<div id="comment_<?=$this->id?>" class="row border-top">
      <div class="col-1">
				<a href="<?=$this->user->link();?>">
						<img src="<?= $this->user->avatar; ?>" class="mr-3" alt="<?=$this->user->fullName;?>"  title="<?=$this->user->fullName;?>">
				</a>
      </div>
			<div class="col-11">
				    <p class="my-2">
              <a href="<?=$this->user->link();?>"><?=$this->user->fullName;?></a><br/><?= $commentText ?><br/>
              <span class="label text-muted"><?= $this->niceDate(); ?></span>
            </p>
      </div>
    </div>
		<?
	}

  function displayForm(){ ?>

		<form id="comment_for_<?= $this->post->id ?>" class="comment_form row border-top" >
      <div class="col-1 mt-2 ">
						<img src="<?= $this->user->avatar; ?>"  class="mr-0" alt="<?=$this->user->fullName;?>" title="<?=$this->user->fullName;?>">
      </div>
			<div class="col-9 mt-2 ">
        <textarea class="form-control" rows="1" placeholder="Type a comment"></textarea>
      </div>
      <div class="col-2 mt-2 ">
				<button type="submit" class="btn btn-primary">Submit</button>
      </div>
    </form>
		<script>
				$("#comment_for_<?= $this->post->id ?>").submit(function( event ) {
						// prevent page reload and submit via ajax instead
						event.preventDefault();
						// send the comment to be stored in the database
	          $.post( <?=site_root?>, {
	              comment: $('#comment_for_<?= $this->post->id ?> textarea').val(),
	              for_post: <?= $this->post->id ?>
	          }).done(function( response ) {
	              $( "#post_<?= $this->post->id ?> .comments").append( response );
	          });
				});
		</script>
	<? }

} // end Class Comment

?>
