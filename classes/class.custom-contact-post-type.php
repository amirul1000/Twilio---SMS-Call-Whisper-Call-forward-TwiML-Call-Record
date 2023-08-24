<?php
	class ContactSettings{
		public function __construct() {
					add_action( 'init', array( $this, 'create_post_type' ));
					add_action( 'add_meta_boxes',  array( $this,'add_contactsettings_metaboxes') );
					add_action('save_post', array( $this,'wpt_save_contactsettings_meta'), 1, 2); // save the custom fields
					add_filter( 'manage_edit-contactsettings_columns', array( $this,'my_edit_contactsettings_columns') ) ;
					add_action('manage_contactsettings_posts_custom_column',  array( $this,'manage_contactsettings_columns'), 10, 2);
				}
		function create_post_type() {
		  register_post_type( 'contactsettings',array(
								 'labels' => array(
													'name'               => __( 'contactsettings' ),
													'singular_name'      => __( 'contactsettings' ),
													'add_new'            => __( 'Add New', 'twilliosetting', 'your-plugin-textdomain' ),
													'add_new_item'       => __( 'Add New twilliosetting', 'your-plugin-textdomain' ),
													'new_item'           => __( 'New twilliosetting', 'your-plugin-textdomain' ),
													'edit_item'          => __( 'Edit twilliosetting', 'your-plugin-textdomain' ),
													'view_item'          => __( 'View twilliosetting', 'your-plugin-textdomain' ),
													'all_items'          => __( 'All contactsettings', 'your-plugin-textdomain' ),
													'search_items'       => __( 'Search contactsettings', 'your-plugin-textdomain' ),
													'parent_item_colon'  => __( 'Parent contactsettings:', 'your-plugin-textdomain' ),
													'not_found'          => __( 'No contactsettings found.', 'your-plugin-textdomain' ),
													'not_found_in_trash' => __( 'No contactsettings found in Trash.', 'your-plugin-textdomain' )
												),
								 'description'   => 'Description',				
								 'public' => true,
								 'has_archive' => true,
								 'menu_position' => 20,
								 'supports' => array( 'title', 'editor','thumbnail','comments','page-attributes'),
								 'supports' => array( 'title'),
								 'capability_type' => 'post',
								 'register_meta_box_cb' => array($this,'add_contactsettings_metaboxes'),
								  'show_in_menu'      => false

							 )
			  );
		}
		
	// Add the Events Meta Boxes

		function add_contactsettings_metaboxes() {
			add_meta_box('wpt_contactsettings_general', 'Settings', array($this,'wpt_contactsettings_general'), 'contactsettings', 'normal', 'default');
		}
		// Add the Events Meta Boxes
		
		// The Event Location Metabox
		
		function wpt_contactsettings_general() {
			global $post;
			
			ob_start();
			include_once dirname(__FILE__) . '/../admin_contactsettings.php';   
			$content = ob_get_clean();
			echo $content;
		}
		// Save the Metabox Data
		
		function wpt_save_contactsettings_meta($post_id, $post) {

			// verify this came from the our screen and with proper authorization,
			// because save_post can be triggered at other times
			/*if ( !wp_verify_nonce( $_POST['contactsettingsmeta_noncename'],  PLUGIN_PATH . '/includes/product-general.php' )) {
			
			return $post->ID;
			}*/
		
			// Is the user allowed to edit the post or page?
			if ( !current_user_can( 'edit_post', $post->ID ))
				return $post->ID;
		   
			// OK, we're authenticated: we need to find and save the data
			// We'll put it into an array to make it easier to loop though.
			
			$contactsettings_meta  =  $_POST;
			
			
			// Add values of $contactsettings_meta as custom fields
			
			foreach ($contactsettings_meta as $key => $value) { // Cycle through the $contactsettings_meta array!
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
	
	function my_edit_contactsettings_columns( $columns ) {
	
		$columns = array(
			'cb' => '<input type="checkbox" />',
			'id' => __('ID'),
			//'title' => __( 'title' ),
			//'short_code' => __( 'Short code' ),
			'contact_name' => __( 'Contact Name' ),
			'address' => __( 'Address' ),
			'phone' => __('Phone'),
			'email' => __('Email'),
			'author' => __( 'Author' ),
			'date' => __( 'Date' )
		);
	
		return $columns;
	}
	
		// Add to admin_init function
	 
	function manage_contactsettings_columns($column_name, $id) {
		global $wpdb;
		switch ($column_name) {
		case 'id':
			echo $id;
				break;
	    case 'short_code':
			        echo "[contactsettings id=$id]";
				break;
		case 'contact_name':
				  $custom_fields = get_post_custom($id);
				  $my_custom_field = $custom_fields[$column_name];
				  
				  if( $my_custom_field)
				  {
					  foreach ( $my_custom_field as $key => $value ) {
						echo $value;
					  }
				  }
			break;
		case 'address':
				   $custom_fields = get_post_custom($id);
				  $my_custom_field = $custom_fields[$column_name];
				  
				  if( $my_custom_field)
				  {
					  foreach ( $my_custom_field as $key => $value ) {
						echo $value;
					  }
				  }
			break;
		 case 'phone':
				   $custom_fields = get_post_custom($id);
				  $my_custom_field = $custom_fields[$column_name];
				  
				  if( $my_custom_field)
				  {
					  foreach ( $my_custom_field as $key => $value ) {
						echo $value;
					  }
				  }
			break;	
		 case 'email':
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