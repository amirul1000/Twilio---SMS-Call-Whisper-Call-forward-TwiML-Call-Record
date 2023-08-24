<?php
   /*Plugin Name: DFY Magic Call Center
    Author: 
  */
  
  
     $args = array('post_type' => 'twilliosettings');
	  $posts = get_posts($args);
	  if($posts){
	    define('SID', $posts[0]->TWILIO_ACCOUNT_SID);
		define('TOKEN', $posts[0]->TWILIO_AUTH_TOKEN);
		define('PurchasedNumber', $posts[0]->twilioPurchasedNumber);
	  }
  
  
    include_once( dirname(__FILE__)  . '/classes/class.custom-settings-post-type.php');
	$obj_settings = new Settings();
	
	include_once( dirname(__FILE__)  . '/classes/class.custom-contact-post-type.php');
	$obj_contactsettings = new ContactSettings();
	
	include_once( dirname(__FILE__)  . '/classes/class.custom-twillio_data-post-type.php');
	$obj_twillio_data = new TwillioData();
	
	include_once( dirname(__FILE__)  . '/classes/class.custom-record_data-post-type.php');
	$obj_record_data = new RecordData();
  
   //Admin		
	add_action('admin_menu', 'twillio_manage');
	function twillio_manage(){
	  add_menu_page('DFY Magic Call Center Settings', 'DFY Magic Call Center', 'manage_options', 'theme-options', 'settings_func');
	  add_submenu_page( 'theme-options', 'Call Media Settings', 'Call Media Settings', 'manage_options', 'media', 'media_url_func');
	  add_submenu_page( 'theme-options', 'SMS Media Settings', 'SMS Media Settings', 'manage_options', 'sms_media', 'sms_media_url_func');
	  add_submenu_page( 'theme-options', 'Forward Settings', 'Forward Settings', 'manage_options', 'dial', 'forward_url_func');
      add_submenu_page( 'theme-options', 'Send SMS', 'Send SMS', 'manage_options', 'sms', 'sms_func');
	 // add_submenu_page( 'theme-options', 'Call', 'Call', 'manage_options', 'call', 'call_func');
	  add_submenu_page( 'theme-options', 'SMS History', 'SMS History', 'manage_options', 'sms_history', 'sms_history_func');
	  add_submenu_page( 'theme-options', 'Call History', 'Call History', 'manage_options', 'call_history', 'call_history_func');
	  

	}
	 
    function settings_func(){
		 include_once dirname(__FILE__) . '/admin_settings.php';   
	}
	function sms_func(){
		 include_once dirname(__FILE__) . '/admin_sms.php';   
	}
	/*function call_func(){
		include_once dirname(__FILE__) . '/admin_call.php';   
	}*/
	
	function sms_history_func(){
		include_once dirname(__FILE__) . '/admin-sms-history.php';   
	}
	
	function call_history_func(){
		include_once dirname(__FILE__) . '/admin-call-history.php';   
	}
	
	function media_url_func(){
		include_once dirname(__FILE__) . '/admin_media.php';  
	}
	function sms_media_url_func(){
		include_once dirname(__FILE__) . '/admin_sms_media.php';  
	}
	function forward_url_func(){
		include_once dirname(__FILE__) . '/admin_dial.php';  
	}
	
	add_shortcode('twillio_call_back', 'call_back_func'); 
	
	function call_back_func(){
		include_once dirname(__FILE__) . '/whisper_call_back.php';  
	}
	
	
	add_shortcode('inbound_call', 'inbound_call_func'); 
	
	function inbound_call_func(){
		include_once dirname(__FILE__) . '/inbound_call.php';  
	}
	

	
// function to create the DB / Options / Defaults					
function your_plugin_options_install() {
   	global $wpdb;
  	global $your_db_name;
 
	 $sql = "
				CREATE TABLE `wp_media` (
				  `id` int(10) NOT NULL,
				  `media_name` varchar(64) DEFAULT NULL,
				  `media_type` varchar(64) DEFAULT NULL,
				  `greeting` varchar(256) DEFAULT NULL,
				  `media_file` varchar(256) DEFAULT NULL,
				  `created_at` datetime DEFAULT NULL,
				  `updated_at` datetime DEFAULT NULL
				) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
				
				--
				-- Indexes for dumped tables
				--
				
				--
				-- Indexes for table `wp_media`
				--
				ALTER TABLE `wp_media`
				  ADD PRIMARY KEY (`id`);
				
				--
				-- AUTO_INCREMENT for dumped tables
				--
				
				--
				-- AUTO_INCREMENT for table `wp_media`
				--
				ALTER TABLE `wp_media`
				  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
				COMMIT;
				
				
				
			CREATE TABLE `wp_sms_media` (
				  `id` int(10) NOT NULL,
				  `sms_media_name` varchar(64) DEFAULT NULL,				  
				  `sms_media_file` varchar(256) DEFAULT NULL,
				  `created_at` datetime DEFAULT NULL,
				  `updated_at` datetime DEFAULT NULL
				) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
				
				--
				-- Indexes for dumped tables
				--
				
				--
				-- Indexes for table `wp_sms_media`
				--
				ALTER TABLE `wp_sms_media`
				  ADD PRIMARY KEY (`id`);
				
				--
				-- AUTO_INCREMENT for dumped tables
				--
				
				--
				-- AUTO_INCREMENT for table `wp_sms_media`
				--
				ALTER TABLE `wp_sms_media`
				  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
				COMMIT;	
				
				
			
			CREATE TABLE `wp_dial` (
			  `id` int(10) NOT NULL,
			  `forward_for` varchar(64) DEFAULT NULL,
			  `receiver_name` varchar(64) DEFAULT NULL,
			  `twilio_no` varchar(64) DEFAULT NULL,
			  `phone` varchar(64) DEFAULT NULL,
			  `status` varchar(64) DEFAULT NULL,
			  `created_at` datetime DEFAULT NULL,
			  `updated_at` datetime DEFAULT NULL
			) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
			
			--
			-- Indexes for dumped tables
			--
			
			--
			-- Indexes for table `wp_dial`
			--
			ALTER TABLE `wp_dial`
			  ADD PRIMARY KEY (`id`);
			
			--
			-- AUTO_INCREMENT for dumped tables
			--
			
			--
			-- AUTO_INCREMENT for table `wp_dial`
			--
			ALTER TABLE `wp_dial`
			  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
			COMMIT;
				
				";
 
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql);
	
 
}
// run the install scripts upon plugin activation
register_activation_hook(__FILE__,'your_plugin_options_install');
	
	
	
	
	
	
	
	
	
	
		
	