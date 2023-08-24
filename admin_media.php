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
							'media_name' => $_REQUEST['media_name'],
							'media_type' => $_REQUEST['media_type'],
							'greeting' => $_REQUEST['greeting'],
							'created_at' =>$created_at,
							'updated_at' =>$updated_at,
							
							);
							
			$uploads_dir = get_home_path().'/wp-content/uploads/media';
			if(!is_dir($uploads_dir)){
			  mkdir($uploads_dir); 
			}
			
				if ($_FILES["media_file"]["error"]==UPLOAD_ERR_OK) {
					$tmp_name = $_FILES["media_file"]["tmp_name"];
					// basename() may prevent filesystem traversal attacks;
					// further validation/sanitation of the filename may be appropriate
					$name = basename($_FILES["media_file"]["name"]);
					move_uploaded_file($tmp_name, "$uploads_dir/$name");
					$params['media_file'] = get_site_url()."/wp-content/uploads/media/$name";
					
				}		
			 
			if($id>0){
			unset($params['created_at']);
			}if($id<=0){
			unset($params['updated_at']);
			} 
			if($id<=0){
			$res = $wpdb->insert('wp_media',$params);
			}
			if($id>0){
			
			 $res = $wpdb->update('wp_media',$params,array('id'=>$_REQUEST['id']));
			 
			}
			 ob_start();
             ob_end_flush();
			 echo "<script>";
			  echo "window.location.href = 'admin.php?page=media';";
			 echo "</script>";
	      break;
	case "delete":  
	      $wpdb->delete('wp_media',array('id'=>$_REQUEST['id']));
		   ob_start();
           ob_end_flush();
		  //wp_redirect( 'admin.php?page=media' );
		   echo "<script>";
			  echo "window.location.href = 'admin.php?page=media';";
			 echo "</script>";
	      break;  
    case "edit":
	         if(!empty($_REQUEST['id'])){
		     	$media  = $wpdb->get_results("select * from wp_media where id='".$_REQUEST['id']."'"); 
			 }
			 include(dirname(__FILE__) . '/template/admin/media/form.php');  
		  break;		  
	default:
	   $media  = $wpdb->get_results("select * from wp_media"); 
	   include(dirname(__FILE__) . '/template/admin/media/index.php');  
  }
?>