<?php
	class RecordData{
		public function __construct() {
					add_action( 'init', array( $this, 'create_post_type' ));
					add_action( 'add_meta_boxes',  array( $this,'add_record_data_metaboxes') );
					add_action('save_post', array( $this,'wpt_save_record_data_meta'), 1, 2); // save the custom fields
					add_filter( 'manage_edit-record_data_columns', array( $this,'my_edit_record_data_columns') ) ;
					add_action('manage_record_data_posts_custom_column',  array( $this,'manage_record_data_columns'), 10, 2);
				}
		function create_post_type() {
		  register_post_type( 'record_data',array(
								 'labels' => array(
													'name'               => __( 'record_data' ),
													'singular_name'      => __( 'record_data' ),
													'add_new'            => __( 'Add New', 'twilliosetting', 'your-plugin-textdomain' ),
													'add_new_item'       => __( 'Add New twilliosetting', 'your-plugin-textdomain' ),
													'new_item'           => __( 'New twilliosetting', 'your-plugin-textdomain' ),
													'edit_item'          => __( 'Edit twilliosetting', 'your-plugin-textdomain' ),
													'view_item'          => __( 'View twilliosetting', 'your-plugin-textdomain' ),
													'all_items'          => __( 'All record_data', 'your-plugin-textdomain' ),
													'search_items'       => __( 'Search record_data', 'your-plugin-textdomain' ),
													'parent_item_colon'  => __( 'Parent record_data:', 'your-plugin-textdomain' ),
													'not_found'          => __( 'No record_data found.', 'your-plugin-textdomain' ),
													'not_found_in_trash' => __( 'No record_data found in Trash.', 'your-plugin-textdomain' )
												),
								 'description'   => 'Description',				
								 'public' => true,
								 'has_archive' => true,
								 'menu_position' => 20,
								 'supports' => array( 'title', 'editor','thumbnail','comments','page-attributes'),
								 'supports' => array( 'title'),
								 'capability_type' => 'post',
								 'register_meta_box_cb' => array($this,'add_record_data_metaboxes'),
								 'show_in_menu'      => false

							 )
			  );
		}
		
	// Add the Events Meta Boxes

		function add_record_data_metaboxes() {
			add_meta_box('wpt_record_data_general', 'RecordData', array($this,'wpt_record_data_general'), 'record_data', 'normal', 'default');
		}
		// Add the Events Meta Boxes
		
		// The Event Location Metabox
		
		function wpt_record_data_general() {
			global $post;
			
			ob_start();
			//include_once dirname(__FILE__) . '/../admin_record_data.php';   
			$content = ob_get_clean();
			echo $content;
		}
		// Save the Metabox Data
		
		function wpt_save_record_data_meta($post_id, $post) {

			// verify this came from the our screen and with proper authorization,
			// because save_post can be triggered at other times
			/*if ( !wp_verify_nonce( $_POST['record_datameta_noncename'],  PLUGIN_PATH . '/includes/product-general.php' )) {
			
			return $post->ID;
			}*/
		
			// Is the user allowed to edit the post or page?
			if ( !current_user_can( 'edit_post', $post->ID ))
				return $post->ID;
		   
			// OK, we're authenticated: we need to find and save the data
			// We'll put it into an array to make it easier to loop though.
			
			$record_data_meta  =  $_POST;
			
			
			// Add values of $record_data_meta as custom fields
			
			foreach ($record_data_meta as $key => $value) { // Cycle through the $record_data_meta array!
				if( $post->post_type == 'revision' ) return; // Don't store custom data twice
				$value = implode(',', (array)$value); // If $value is an array, make it a CSV (unlikely)
				if(get_post_meta($post->ID, $key, FALSE)) { // If the custom field already has a value
					update_post_meta($post->ID, $key, $value);
				} else { // If the custom field doesn't have a value
					add_post_meta($post->ID, $key, $value);
				}
				if(!$value) delete_post_meta($post->ID, $key); // Delete if blank
			}
		

		}
	
	function my_edit_record_data_columns( $columns ) {
	
		$columns = array(
			'cb' => '<input type="checkbox" />',
			'id' => __('ID'),
			//'title' => __( 'title' ),
			//'short_code' => __( 'Short code' ),
			'AccountSid' => __( 'AccountSid' ),
			'CallSid' => __('CallSid'),
			'RecordingSid' => __('RecordingSid'),
			'RecordingUrl' => __( 'RecordingUrl' ),
			'RecordingStatus' => __( 'RecordingStatus' ),
			'RecordingDuration' => __('RecordingDuration'),
			'RecordingChannels' => __('RecordingChannels'),
			'RecordingSource' => __( 'RecordingSource' ),
			'author' => __( 'Author' ),
			'date' => __( 'Date' )
		);
	
		return $columns;
	}
	
		// Add to admin_init function
	 
	function manage_record_data_columns($column_name, $id) {
		global $wpdb;
		switch ($column_name) {
		case 'id':
			echo $id;
				break;
		case 'AccountSid':
				  $custom_fields = get_post_custom($id);
				  $my_custom_field = $custom_fields[$column_name];
				  
				  if( $my_custom_field)
				  {
					  foreach ( $my_custom_field as $key => $value ) {
						echo $value;
					  }
				  }
			break;
		case 'CallSid':
				   $custom_fields = get_post_custom($id);
				  $my_custom_field = $custom_fields[$column_name];
				  
				  if( $my_custom_field)
				  {
					  foreach ( $my_custom_field as $key => $value ) {
						echo $value;
					  }
				  }
			break;
		 case 'RecordingSid':
				   $custom_fields = get_post_custom($id);
				  $my_custom_field = $custom_fields[$column_name];
				  
				  if( $my_custom_field)
				  {
					  foreach ( $my_custom_field as $key => $value ) {
						echo $value;
					  }
				  }
			break;	
		 case 'RecordingUrl':
				   $custom_fields = get_post_custom($id);
				  $my_custom_field = $custom_fields[$column_name];
				  
				  if( $my_custom_field)
				  {
					  foreach ( $my_custom_field as $key => $value ) {
						echo $value;
					  }
				  }
			break;		
	    case 'RecordingStatus':
				   $custom_fields = get_post_custom($id);
				  $my_custom_field = $custom_fields[$column_name];
				  
				  if( $my_custom_field)
				  {
					  foreach ( $my_custom_field as $key => $value ) {
						echo $value;
					  }
				  }
			break;		
	    case 'RecordingDuration':
				   $custom_fields = get_post_custom($id);
				  $my_custom_field = $custom_fields[$column_name];
				  
				  if( $my_custom_field)
				  {
					  foreach ( $my_custom_field as $key => $value ) {
						echo $value;
					  }
				  }
			break;		
	   case 'RecordingChannels':
				   $custom_fields = get_post_custom($id);
				  $my_custom_field = $custom_fields[$column_name];
				  
				  if( $my_custom_field)
				  {
					  foreach ( $my_custom_field as $key => $value ) {
						echo $value;
					  }
				  }
			break;	
	    case 'RecordingSource':
				   $custom_fields = get_post_custom($id);
				  $my_custom_field = $custom_fields[$column_name];
				  
				  if( $my_custom_field)
				  {
					  foreach ( $my_custom_field as $key => $value ) {
						echo $value;
					  }
				  }
			break;													
		default: 
			break;
		} // end switch
	} 

 }

?>