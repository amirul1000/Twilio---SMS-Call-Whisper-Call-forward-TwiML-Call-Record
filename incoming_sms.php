 <?php
 //ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
error_reporting(E_ALL ^ E_WARNING); 

 if (file_exists("wp-load.php"))
    {
    	require_once("wp-load.php");
    }
    
    
    ob_start();
	 
    global $post;
    global $wpdb;
   // include('wp-content/plugins/twillio-msg-call/Twilio/autoload.php');
  
	//use Twilio\TwiML\VoiceResponse;
	
//	$sid = SID;
   // $token = TOKEN;
	
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
	//Dial
	$forward  = $wpdb->get_results("select * from wp_dial 
	              where status='active' 
				   AND  forward_for='sms'
				   AND  twilio_no Like '%".trim($_REQUEST['To'])."'"); 
	
	 echo '<Response>
	        <Say>'.$_REQUEST['Body'].'</Say>
			<Message to="'.trim($forward[0]->phone).'">'.trim($_REQUEST['From']).': '.$_REQUEST['Body'].'</Message>
			</Response>  ';        
	

?>
  