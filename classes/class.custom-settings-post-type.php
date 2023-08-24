<?php
	class Settings{
		public function __construct() {
					add_action( 'init', array( $this, 'create_post_type' ));
					add_action( 'add_meta_boxes',  array( $this,'add_twilliosettings_metaboxes') );
					add_action('save_post', array( $this,'wpt_save_twilliosettings_meta'), 1, 2); // save the custom fields
					add_filter( 'manage_edit-twilliosettings_columns', array( $this,'my_edit_twilliosettings_columns') ) ;
					add_action('manage_twilliosettings_posts_custom_column',  array( $this,'manage_twilliosettings_columns'), 10, 2);
				}
		function create_post_type() {
		  register_post_type( 'twilliosettings',array(
								 'labels' => array(
													'name'               => __( 'twilliosettings' ),
													'singular_name'      => __( 'twilliosettings' ),
													'add_new'            => __( 'Add New', 'twilliosetting', 'your-plugin-textdomain' ),
													'add_new_item'       => __( 'Add New twilliosetting', 'your-plugin-textdomain' ),
													'new_item'           => __( 'New twilliosetting', 'your-plugin-textdomain' ),
													'edit_item'          => __( 'Edit twilliosetting', 'your-plugin-textdomain' ),
													'view_item'          => __( 'View twilliosetting', 'your-plugin-textdomain' ),
													'all_items'          => __( 'All twilliosettings', 'your-plugin-textdomain' ),
													'search_items'       => __( 'Search twilliosettings', 'your-plugin-textdomain' ),
													'parent_item_colon'  => __( 'Parent twilliosettings:', 'your-plugin-textdomain' ),
													'not_found'          => __( 'No twilliosettings found.', 'your-plugin-textdomain' ),
													'not_found_in_trash' => __( 'No twilliosettings found in Trash.', 'your-plugin-textdomain' )
												),
								 'description'   => 'Description',				
								 'public' => true,
								 'has_archive' => true,
								 'menu_position' => 20,
								 //'supports' => array( 'title', 'editor','thumbnail','comments','page-attributes'),
								 'supports' => array( 'title'),
								 'capability_type' => 'post',
								 'register_meta_box_cb' => array($this,'add_twilliosettings_metaboxes'),
								 'show_in_menu'      => false

							 )
			  );
		}
		
	// Add the Events Meta Boxes

		function add_twilliosettings_metaboxes() {
			add_meta_box('wpt_twilliosettings_general', 'Settings', array($this,'wpt_twilliosettings_general'), 'twilliosettings', 'normal', 'default');
		}
		// Add the Events Meta Boxes
		
		// The Event Location Metabox
		
		function wpt_twilliosettings_general() {
			global $post;
			
			ob_start();
			include_once dirname(__FILE__) . '/../admin_settings.php';   
			$content = ob_get_clean();
			echo $content;
		}
		// Save the Metabox Data
		
		function wpt_save_twilliosettings_meta($post_id, $post) {

			// verify this came from the our screen and with proper authorization,
			// because save_post can be triggered at other times
			/*if ( !wp_verify_nonce( $_POST['twilliosettingsmeta_noncename'],  PLUGIN_PATH . '/includes/product-general.php' )) {
			
			return $post->ID;
			}*/
		
			// Is the user allowed to edit the post or page?
			if ( !current_user_can( 'edit_post', $post->ID ))
				return $post->ID;
		   
			// OK, we're authenticated: we need to find and save the data
			// We'll put it into an array to make it easier to loop though.
			
			$twilliosettings_meta  =  $_POST;
			
			
			// Add values of $twilliosettings_meta as custom fields
			
			foreach ($twilliosettings_meta as $key => $value) { // Cycle through the $twilliosettings_meta array!
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
	
	function my_edit_twilliosettings_columns( $columns ) {
	
		$columns = array(
			'cb' => '<input type="checkbox" />',
			'id' => __('ID'),
			//'title' => __( 'title' ),
			//'short_code' => __( 'Short code' ),
			'TWILIO_ACCOUNT_SID' => __( 'TWILIO ACCOUNT SID' ),
			'TWILIO_AUTH_TOKEN' => __( 'TWILIO AUTH TOKEN' ),
			'twilioPurchasedNumber' => __('twilio Purchased Number'),
			'author' => __( 'author' ),
			'date' => __( 'Date' )
		);
	
		return $columns;
	}
	
		// Add to admin_init function
	 
	function manage_twilliosettings_columns($column_name, $id) {
		global $wpdb;
		switch ($column_name) {
		case 'id':
			echo $id;
				break;
	    case 'short_code':
			        echo "[twilliosettings id=$id]";
				break;
		case 'TWILIO_ACCOUNT_SID':
				  $custom_fields = get_post_custom($id);
				  $my_custom_field = $custom_fields[$column_name];
				  
				  if( $my_custom_field)
				  {
					  foreach ( $my_custom_field as $key => $value ) {
						echo $value;
					  }
				  }
			break;
		case 'TWILIO_AUTH_TOKEN':
				   $custom_fields = get_post_custom($id);
				  $my_custom_field = $custom_fields[$column_name];
				  
				  if( $my_custom_field)
				  {
					  foreach ( $my_custom_field as $key => $value ) {
						echo $value;
					  }
				  }
			break;
		 case 'twilioPurchasedNumber':
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