<?php
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
							'sms_media_name' => $_REQUEST['sms_media_name'],
							'created_at' =>$created_at,
							'updated_at' =>$updated_at,
							
							);
							
			$uploads_dir = get_home_path().'/wp-content/uploads/sms_media';
			if(!is_dir($uploads_dir)){
			  mkdir($uploads_dir); 
			}
			
				if ($_FILES["sms_media_file"]["error"]==UPLOAD_ERR_OK) {
					$tmp_name = $_FILES["sms_media_file"]["tmp_name"];
					// basename() may prevent filesystem traversal attacks;
					// further validation/sanitation of the filename may be appropriate
					$name = basename($_FILES["sms_media_file"]["name"]);
					move_uploaded_file($tmp_name, "$uploads_dir/$name");
					$params['sms_media_file'] = get_site_url()."/wp-content/uploads/sms_media/$name";
					
				}		
			 
			if($id>0){
			unset($params['created_at']);
			}if($id<=0){
			unset($params['updated_at']);
			} 
			if($id<=0){
			$res = $wpdb->insert('wp_sms_media',$params);
			}
			if($id>0){
			
			 $res = $wpdb->update('wp_sms_media',$params,array('id'=>$_REQUEST['id']));
			 
			}
			 ob_start();
             ob_end_flush();
			 echo "<script>";
			  echo "window.location.href = 'admin.php?page=sms_media';";
			 echo "</script>";
	      break;
	case "delete":  
	      $wpdb->delete('wp_sms_media',array('id'=>$_REQUEST['id']));
		   ob_start();
           ob_end_flush();
		  //wp_redirect( 'admin.php?page=sms_media' );
		   echo "<script>";
			  echo "window.location.href = 'admin.php?page=sms_media';";
			 echo "</script>";
	      break;  
    case "edit":
	         if(!empty($_REQUEST['id'])){
		     	$sms_media  = $wpdb->get_results("select * from wp_sms_media where id='".$_REQUEST['id']."'"); 
			 }
			 include(dirname(__FILE__) . '/template/admin/sms_media/form.php');  
		  break;		  
	default:
	   $sms_media  = $wpdb->get_results("select * from wp_sms_media"); 
	   include(dirname(__FILE__) . '/template/admin/sms_media/index.php');  
  }
?>