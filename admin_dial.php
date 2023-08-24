<?php

   include(plugin_dir_path( __FILE__ ) .'/Twilio/autoload.php');
   use Twilio\Rest\Client;
   use Twilio\TwiML\VoiceResponse;
   $sid = SID;
   $token = TOKEN;
	
   $client = new Client($sid, $token);




  global $wpdb;
  $cmd='';
  $id = '';
  $cmd = isset($_REQUEST['cmd'])?$_REQUEST['cmd']:'';
  $id = isset($_REQUEST['id'])?$_REQUEST['id']:'';
  
  switch($cmd){
	case "save":
	         $created_at = "";
			 $updated_at = "";

			if($id<=0){
				 $created_at = date("Y-m-d H:i:s");
			 }
			else if($id>0){
				 $updated_at = date("Y-m-d H:i:s");
			 }

			$params = array(
			                'forward_for' => $_REQUEST['forward_for'],
			                'receiver_name' => $_REQUEST['receiver_name'],
							'twilio_no'  => $_REQUEST['twilio_no'],
							'phone' => $_REQUEST['phone'],
							'status' => $_REQUEST['status'],
							'created_at' =>$created_at,
							'updated_at' =>$updated_at,
							
							);
			
			 
			if($id>0){
			unset($params['created_at']);
			}if($id<=0){
			unset($params['updated_at']);
			} 
			if($id<=0){
			$res = $wpdb->insert('wp_dial',$params);
			}
			if($id>0){
			
			 $res = $wpdb->update('wp_dial',$params,array('id'=>$_REQUEST['id']));
			 
			}
			 ob_start();
             ob_end_flush();
			 echo "<script>";
			  echo "window.location.href = 'admin.php?page=dial';";
			 echo "</script>";
	      break;
	case "delete":  
	      $wpdb->delete('wp_dial',array('id'=>$_REQUEST['id']));
		   ob_start();
           ob_end_flush();
		  //wp_redirect( 'admin.php?page=dial' );
		   echo "<script>";
			  echo "window.location.href = 'admin.php?page=dial';";
			 echo "</script>";
	      break;  
    case "edit":
	         if(!empty($_REQUEST['id'])){
		     	$dial  = $wpdb->get_results("select * from wp_dial where id='".$_REQUEST['id']."'"); 
			 }
			 include(dirname(__FILE__) . '/template/admin/dial/form.php');  
		  break;		  
	default:
	   $dial  = $wpdb->get_results("select * from wp_dial"); 
	   include(dirname(__FILE__) . '/template/admin/dial/index.php');  
  }
?>