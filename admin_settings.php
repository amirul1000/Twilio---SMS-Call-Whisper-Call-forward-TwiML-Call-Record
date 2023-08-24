<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<?php
  if($_POST)
  {
	 $twilliosettings_meta  =  $_POST;
	// Add values of $twilliosettings_meta as custom fields
	
	foreach ($twilliosettings_meta as $key => $value) { // Cycle through the $twilliosettings_meta array!
		$post_id = $_POST['post_id'];
		if(get_post_meta($post_id, $key, FALSE)) { // If the custom field already has a value
			update_post_meta($post_id, $key, $value);
		} else { // If the custom field doesn't have a value
			
			  $args = array('post_type' => 'twilliosettings');
			  $posts = get_posts($args);
			  if(empty($posts)){
				 $page_slug = 'test-page-title'; // Slug of the Post
					$new_post = array(
						'post_type'     => 'twilliosettings', 				// Post Type Slug eg: 'page', 'post'
						'post_title'    => 'Settings Twillio',	// Title of the Content
						'post_status'   => 'publish',			// Post Status
						'post_author'   => 1,					// Post Author ID
						'post_name'     => 'Settings Twillio'			// Slug of the Post
					);
					$post_id = wp_insert_post($new_post);
			  }
			
			add_post_meta($post_id, $key, $value);
		}
	}
    
  
  }
  
  //load data
  $post_id = 0;
  $args = array('post_type' => 'twilliosettings');
  $posts = get_posts($args);
  if($posts){
   $post_id =  $posts[0]->ID;
  }
?>

<h3>
    <a href="edit.php?post_type=twilliosettings">
    TWILIO Settings
    </a>
</h3>
<form method="post" action="admin.php?page=theme-options">
  <div class="form-group">
    <label for="TWILIO_ACCOUNT_SID">TWILIO ACCOUNT SID</label>
    <input type="text" class="form-control" name="TWILIO_ACCOUNT_SID" id="TWILIO_ACCOUNT_SID" value="<?=get_post_meta($post_id, "TWILIO_ACCOUNT_SID", true)?>" placeholder="TWILIO ACCOUNT SID">
  </div>
  <div class="form-group">
    <label for="TWILIO_AUTH_TOKEN">TWILIO AUTH TOKEN</label>
    <input type="text" class="form-control" name="TWILIO_AUTH_TOKEN" id="TWILIO_AUTH_TOKEN" value="<?=get_post_meta($post_id, "TWILIO_AUTH_TOKEN", true)?>" placeholder="TWILIO AUTH TOKEN">
  </div>
  <div class="form-group">
    <label for="twilioPurchasedNumber">twilio Purchased Number</label>
    <input type="text" class="form-control"  name="twilioPurchasedNumber" id="twilioPurchasedNumber" value="<?=get_post_meta($post_id, "twilioPurchasedNumber", true)?>" placeholder="twilio Purchased Number">
  </div>
  <div class="form-group">
  <input type="hidden" name="post_id" value="<?=isset($post_id)?$post_id:''?>">
  <button type="submit" class="btn btn-primary">Submit</button>
  </div>
</form>
<div class="row">
  <div class="col">
    Set in Twilio at <br>
    A call comes in  : http://www.YourHostName.com/incoming_call.php<br>
    A message comes in  : http://www.YourHostName.com/incoming_sms.php<br>
    Upload  3 files at WP root (http://www.YourHostName.com)<br>
      1.incoming_call.php <br>
      2.incoming_sms.php <br>
      3.call_record.php <br>
    
    <br>
</div>
</div>

<div class="row">
  <div class="col">
     <div class="form-group">
	   	   <a href="edit.php?post_type=contactsettings" class="btn btn-secondary">Add New Contact</a>
     </div>
  </div> 
  <div class="col">
     <div class="form-group"> 
         <a href="edit.php?post_type=contactsettings">
          Total Phone No.
         <?php
		      global $post;
			  $contacts = array(); 
			  $args = array('post_type' => 'contactsettings',
							 'meta_key' => 'phone');
			 $the_query = new WP_Query( $args );
			 $count_phone = $the_query->post_count;
			 echo $count_phone;
		 ?>
         </a>
      </div>
     </div> 
</div>
<div class="row">
  <div class="col">
     <div class="form-group">
	   <a href="admin.php?page=call_history" class="btn btn-secondary label">History</a>
     </div>
  </div>
</div>


<div class="row">
  <div class="col">
     <div class="form-group">
	   <a href="edit.php?post_type=twillio_data" class="btn btn-secondary label">Twillio data</a>
     </div>
  </div>
</div>

<div class="row">
  <div class="col">
     <div class="form-group">
	   <a href="edit.php?post_type=record_data" class="btn btn-secondary label">Call record data</a>
     </div>
  </div>
</div>

