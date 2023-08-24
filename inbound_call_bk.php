<?php 
    ob_start();
	 
    global $post;
    global $wpdb;
    include(plugin_dir_path( __FILE__ ) .'/Twilio/autoload.php');
  
	use Twilio\TwiML\VoiceResponse;
	
	$sid = SID;
    $token = TOKEN;
	
	
	
	//Twillio data save
	if($_REQUEST['CallStatus']){
		$args = array('post_type' => 'twillio_data');
		$posts = get_posts($args);
		
		$page_slug = 'twillio_data-page-title'; // Slug of the Post
		$new_post = array(
			'post_type'     => 'twillio_data', 				// Post Type Slug eg: 'page', 'post'
			'post_title'    => 'Twillio Data',	// Title of the Content
			'post_status'   => 'publish',			// Post Status
			'post_author'   => 1,					// Post Author ID
			'post_name'     => 'Twillio Data'			// Slug of the Post
		);
		$post_id = wp_insert_post($new_post);
		
		
		add_post_meta($post_id, 'Direction', $_REQUEST['Direction']);
		add_post_meta($post_id, 'Timestamp', $_REQUEST['Timestamp']);
		add_post_meta($post_id, 'CallbackSource', $_REQUEST['CallbackSource']);
		add_post_meta($post_id, 'CallSid', $_REQUEST['CallSid']);
		add_post_meta($post_id, 'To', $_REQUEST['To']);
		add_post_meta($post_id, 'CallStatus', $_REQUEST['CallStatus']);
		add_post_meta($post_id, 'From', $_REQUEST['From']);
		add_post_meta($post_id, 'AccountSid', $_REQUEST['AccountSid']);
	}
	if($_REQUEST['CallStatus']=='answered' || $_REQUEST['CallStatus']=='completed'){
		$obj = $wpdb->get_results("select * from wp_media where media_type='Answerphone'"); 
		// TwiML Say and Play
		$say = new \Twilio\TwiML\Voice\Say('Thanks for calling!', [
			'voice' => 'woman'
		]);
		
		$play = new \Twilio\TwiML\Voice\Play($obj[0]->media_file, [
			'loop' => 1
		]);
		
		$twiml = new VoiceResponse();
		$twiml->append($say);
		$twiml->append($play);
		
		 $path = get_home_path()."/voice2.xml";
		 $file = fopen($path,"w");
		 fwrite($file,$twiml->asXML());
		 fclose($file);
		 
		 ob_start();	
		 ob_end_clean();			
		$content =  file_get_contents(get_site_url()."/voice2.xml");
		
		echo $content;
	
	}
	
	
	if($_REQUEST['CallStatus']=='initiated' || $_REQUEST['CallStatus']=='ringing'){
		$obj = $wpdb->get_results("select * from wp_media where media_type='In coming Call Message'"); 
		// TwiML Say and Play
		$say = new \Twilio\TwiML\Voice\Say('Thanks for calling!', [
			'voice' => 'woman'
		]);
		
		$play = new \Twilio\TwiML\Voice\Play($obj[0]->media_file, [
			'loop' => 1
		]);
		
		$twiml = new VoiceResponse();
		$twiml->append($say);
		$twiml->append($play);
		
		 $path = get_home_path()."/voice3.xml";
		 $file = fopen($path,"w");
		 fwrite($file,$twiml->asXML());
		 fclose($file);
		 
		 ob_start();	
		 ob_end_clean();	
		 $content =  file_get_contents(get_site_url()."/voice3.xml");
		 echo $content;
	}

?>