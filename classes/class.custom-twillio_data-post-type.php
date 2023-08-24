<?php
	class TwillioData{
		public function __construct() {
					add_action( 'init', array( $this, 'create_post_type' ));
					add_action( 'add_meta_boxes',  array( $this,'add_twillio_data_metaboxes') );
					add_action('save_post', array( $this,'wpt_save_twillio_data_meta'), 1, 2); // save the custom fields
					add_filter( 'manage_edit-twillio_data_columns', array( $this,'my_edit_twillio_data_columns') ) ;
					add_action('manage_twillio_data_posts_custom_column',  array( $this,'manage_twillio_data_columns'), 10, 2);
				}
		function create_post_type() {
		  register_post_type( 'twillio_data',array(
								 'labels' => array(
													'name'               => __( 'twillio_data' ),
													'singular_name'      => __( 'twillio_data' ),
													'add_new'            => __( 'Add New', 'twilliosetting', 'your-plugin-textdomain' ),
													'add_new_item'       => __( 'Add New twilliosetting', 'your-plugin-textdomain' ),
													'new_item'           => __( 'New twilliosetting', 'your-plugin-textdomain' ),
													'edit_item'          => __( 'Edit twilliosetting', 'your-plugin-textdomain' ),
													'view_item'          => __( 'View twilliosetting', 'your-plugin-textdomain' ),
													'all_items'          => __( 'All twillio_data', 'your-plugin-textdomain' ),
													'search_items'       => __( 'Search twillio_data', 'your-plugin-textdomain' ),
													'parent_item_colon'  => __( 'Parent twillio_data:', 'your-plugin-textdomain' ),
													'not_found'          => __( 'No twillio_data found.', 'your-plugin-textdomain' ),
													'not_found_in_trash' => __( 'No twillio_data found in Trash.', 'your-plugin-textdomain' )
												),
								 'description'   => 'Description',				
								 'public' => true,
								 'has_archive' => true,
								 'menu_position' => 20,
								 'supports' => array( 'title', 'editor','thumbnail','comments','page-attributes'),
								 'supports' => array( 'title'),
								 'capability_type' => 'post',
								 'register_meta_box_cb' => array($this,'add_twillio_data_metaboxes'),
								 'show_in_menu'      => false

							 )
			  );
		}
		
	// Add the Events Meta Boxes

		function add_twillio_data_metaboxes() {
			add_meta_box('wpt_twillio_data_general', 'TwillioData', array($this,'wpt_twillio_data_general'), 'twillio_data', 'normal', 'default');
		}
		// Add the Events Meta Boxes
		
		// The Event Location Metabox
		
		function wpt_twillio_data_general() {
			global $post;
			
			ob_start();
			include_once dirname(__FILE__) . '/../admin_twillio_data.php';   
			$content = ob_get_clean();
			echo $content;
		}
		// Save the Metabox Data
		
		function wpt_save_twillio_data_meta($post_id, $post) {

			// verify this came from the our screen and with proper authorization,
			// because save_post can be triggered at other times
			/*if ( !wp_verify_nonce( $_POST['twillio_datameta_noncename'],  PLUGIN_PATH . '/includes/product-general.php' )) {
			
			return $post->ID;
			}*/
		
			// Is the user allowed to edit the post or page?
			if ( !current_user_can( 'edit_post', $post->ID ))
				return $post->ID;
		   
			// OK, we're authenticated: we need to find and save the data
			// We'll put it into an array to make it easier to loop though.
			
			$twillio_data_meta  =  $_POST;
			
			
			// Add values of $twillio_data_meta as custom fields
			
			foreach ($twillio_data_meta as $key => $value) { // Cycle through the $twillio_data_meta array!
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
	
	function my_edit_twillio_data_columns( $columns ) {
	
		$columns = array(
			'cb' => '<input type="checkbox" />',
			'id' => __('ID'),
			//'title' => __( 'title' ),
			//'short_code' => __( 'Short code' ),
			'Direction' => __( 'Direction' ),
			'Timestamp' => __('Timestamp'),
			'CallbackSource' => __('CallbackSource'),
			'CallSid' => __( 'CallSid' ),
			'To' => __( 'To' ),
			'CallStatus' => __('CallStatus'),
			'From' => __('From'),
			'AccountSid' => __( 'AccountSid' ),
			'author' => __( 'Author' ),
			'date' => __( 'Date' )
		);
	
		return $columns;
	}
	
		// Add to admin_init function
	 
	function manage_twillio_data_columns($column_name, $id) {
		global $wpdb;
		switch ($column_name) {
		case 'id':
			echo $id;
				break;
		case 'Direction':
				  $custom_fields = get_post_custom($id);
				  $my_custom_field = $custom_fields[$column_name];
				  
				  if( $my_custom_field)
				  {
					  foreach ( $my_custom_field as $key => $value ) {
						echo $value;
					  }
				  }
			break;
		case 'Timestamp':
				   $custom_fields = get_post_custom($id);
				  $my_custom_field = $custom_fields[$column_name];
				  
				  if( $my_custom_field)
				  {
					  foreach ( $my_custom_field as $key => $value ) {
						echo $value;
					  }
				  }
			break;
		 case 'CallbackSource':
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
	    case 'To':
				   $custom_fields = get_post_custom($id);
				  $my_custom_field = $custom_fields[$column_name];
				  
				  if( $my_custom_field)
				  {
					  foreach ( $my_custom_field as $key => $value ) {
						echo $value;
					  }
				  }
			break;		
	    case 'CallStatus':
				   $custom_fields = get_post_custom($id);
				  $my_custom_field = $custom_fields[$column_name];
				  
				  if( $my_custom_field)
				  {
					  foreach ( $my_custom_field as $key => $value ) {
						echo $value;
					  }
				  }
			break;		
	   case 'From':
				   $custom_fields = get_post_custom($id);
				  $my_custom_field = $custom_fields[$column_name];
				  
				  if( $my_custom_field)
				  {
					  foreach ( $my_custom_field as $key => $value ) {
						echo $value;
					  }
				  }
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
		default: 
			break;
		} // end switch
	} 

 }

?>