<?php
error_reporting(E_ALL ^ E_WARNING); 

 if (file_exists("wp-load.php"))
    {
    	require_once("wp-load.php");
    }
    
    
    ob_start();
	 
    global $post;
    global $wpdb;
	
	
		//Twillio data save
	//if($_REQUEST['CallStatus']){
		$args = array('post_type' => 'record_data');
		$posts = get_posts($args);
		
		$page_slug = 'record_data-page-title'; // Slug of the Post
		$new_post = array(
			'post_type'     => 'record_data', 				// Post Type Slug eg: 'page', 'post'
			'post_title'    => 'Twillio record Data',	// Title of the Content
			'post_status'   => 'publish',			// Post Status
			'post_author'   => 1,					// Post Author ID
			'post_name'     => 'Twillio record Data'			// Slug of the Post
		);
		$post_id = wp_insert_post($new_post);
		
		add_post_meta($post_id, 'AccountSid', $_REQUEST['AccountSid']);
		add_post_meta($post_id, 'CallSid', $_REQUEST['CallSid']);
		add_post_meta($post_id, 'RecordingSid', $_REQUEST['RecordingSid']);
		add_post_meta($post_id, 'RecordingUrl', $_REQUEST['RecordingUrl']);
		add_post_meta($post_id, 'RecordingStatus', $_REQUEST['RecordingStatus']);
		add_post_meta($post_id, 'RecordingDuration', $_REQUEST['RecordingDuration']);
		add_post_meta($post_id, 'RecordingChannels', $_REQUEST['RecordingChannels']);
		add_post_meta($post_id, 'RecordingSource', $_REQUEST['RecordingSource']);
	//}
	
	
?>	