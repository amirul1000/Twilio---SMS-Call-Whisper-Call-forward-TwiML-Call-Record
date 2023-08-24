<?php 
   include(plugin_dir_path( __FILE__ ) .'/Twilio/autoload.php');
   use Twilio\Rest\Client;
   use Twilio\TwiML\VoiceResponse;
   
   $sid = SID;
   $token = TOKEN;
	
   $client = new Client($sid, $token);
   $msg='';
			
   global $post;
   global $wpdb;
  $contacts = array(); 
  $args = array('post_type' => 'contactsettings',
                 'meta_key' => 'phone',
				 
				'orderby'   => 'meta_value',
                'order' => 'ASC',
				 );
 $the_query = new WP_Query( $args );
 $count_phone = $the_query->post_count;

      if ( $the_query->have_posts() ) {
       
        while ( $the_query->have_posts() ) :
              $the_query->the_post();
			  
			  $contact_name = get_post_meta($post->ID, "contact_name", true);
			  $address = get_post_meta($post->ID, "address", true);
			  $phone = get_post_meta($post->ID, "phone", true);
			  $email = get_post_meta($post->ID, "email", true);
			  $contacts[] = array('contact_name'=>$contact_name,
			                     'address'=>$address,
								 'phone'=>$phone,
								 'email'=>$email);
			  
	 
	    endwhile;
		   
		}
		
     if($_POST){
		 
		 if($_POST['media']){
			
				$obj = $wpdb->get_results("select * from wp_media where id='".$_POST['media']."'"); 
                $media_file = $obj[0]->media_file;
			 }
			 
			/*$path = get_home_path()."/voice.xml";
			$file = fopen($path,"w");
			fwrite($file,$twiml->asXML());
			fclose($file);
			
			
	   if(!empty($_POST['msg'])){		
			$say = new \Twilio\TwiML\Voice\Say($_POST['msg'], [
			'voice' => 'woman'
			]);
	   }
		if(!empty($media_file)){		
			$play = new \Twilio\TwiML\Voice\Play($media_file, [
				'loop' => 1
			]);
		}
		
		
		$twiml = new VoiceResponse();
		 if(!empty($_POST['msg'])){	
			$twiml->append($say);
		 }
		 if(!empty($media_file)){	
			$twiml->append($play);
		 }
		
		 $path = get_home_path()."/voice.xml";
		 $file = fopen($path,"w");
		 fwrite($file,$twiml->asXML());
		 fclose($file);
		 $mediaUrl = site_url('/voice.xml');
		*/
		 
		 $phone_arr['phone'] = array();
		 if(!empty($_POST['phone'])){
			 $phone_arr['phone'] = $_POST['phone'];
		 }
		 if(!empty($_POST['entered_phone_no'])){
			 $phone_arr['phone'][] = $_POST['entered_phone_no'];
		 }
		 //$arr_msg_status = array();
		for($i=0;$i<count($phone_arr['phone']);$i++){ 
		
			$phoneNumber = $phone_arr['phone'][$i];
			$twilioPurchasedNumber = $_POST['twillioPurchasedNumber'];
			// Send a text message https://www.twilio.com/docs/sms/send-messages
			try{
				if(empty($media_file)){
					$message = $client->messages->create(
						$phoneNumber,
						[
							'from' => $twilioPurchasedNumber,
							'body' => $_POST['msg']
						]
					);		
				}
				else{
			        $message = $client->messages->create(
						$phoneNumber,
						[
							'from' => $twilioPurchasedNumber,
							'body' => $_POST['msg'],
							'mediaUrl'=>[$media_file]
						]
					);		
				}
			
			}catch(\Twilio\Exceptions\RestException $e){
				echo "Error sending: ".$e->getCode() . ' : ' . $e->getMessage()."\n";
			}
			$msg .= "Message sent successfully to $phoneNumber with sid = " . $message->sid ."\n\n<br>";
		}
	 }
?>
  <link 
  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.css" 
  rel="stylesheet"  type='text/css'>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<style>
.label {
   text-align: right;
    //clear: both;
    //float:left;
    margin-left:20px;
}
  .show{
	  display:block;
  }
.hide{
	   display:none;
  }
  
   .show2{
	  display:block;
  }
.hide2{
	   display:none;
  }

</style>
<h3>Send SMS</h3>
<?php
  if(isset($msg)){
    echo $msg;
  }
?>
<a href="edit.php?post_type=contactsettings" class="btn btn-secondary">Add New Contact</a>
<form method="post"  action="admin.php?page=sms" onSubmit="return chkRequired();">
   <div class="form-group form-check">
    <label for="usr">Contact</label>
    <ul class="list-group">
         <li class="list-group-item" style="display: inline-block;">
            <input type="checkbox" name="chkunchk" id="chkunchk" class="form-check-input" onChange="setChk();"><label  class="label">Check/UnCheck All</label>
         </li>
         <li class="list-group-item">
                    <a href="javascript:void(0)" class="clickMe" onClick="showhideClass();"><i class="fa fa-plus"></i></a>

           <label  class="label">Custom phone No(Call To/Receiver)</label>
         </li>
		<?php
        for($i=0;$i<count($contacts);$i++){
                         ?>
         <li class="list-group-item sh hide">
            <input type="checkbox" name="phone[]" id="phone<?=$i?>" value="<?=$contacts[$i]['phone']?>" class="form-check-input" <?php if(isset($_POST['phone'][$i])&&$contacts[$i]['phone']==$_POST['phone'][$i]){ echo "checked";}?>>
             <label  class="label"> <?=$contacts[$i]['phone']?> [<?=$contacts[$i]['contact_name']?>,<?=$contacts[$i]['address']?>,<?=$contacts[$i]['email']?>]</label>
         </li>
        <?php
         }
        ?>
        <li class="list-group-item">
           Enter Phone No<input type="text" name="entered_phone_no" value="<?php echo isset($_POST['entered_phone_no'])?$_POST['entered_phone_no']:''; ?>">
        </li>
     </ul>
     
       <?php
			$context = $client->getAccount();
			$activeNumbers = $context->incomingPhoneNumbers;
			$activeNumberArray = $activeNumbers->read();
			$numbers = [];
			foreach($activeNumberArray as $activeNumber) {
				error_log('active number = '.$activeNumber->phoneNumber);
				$numbers[] = (object)[
					'number' => $activeNumber->phoneNumber,
					//'name' => $activeNumber->friendlyName,
					//'sid' => $activeNumber->sid
				];
		   }
		   sort($numbers,SORT_REGULAR );
		 ?>
         <label>Twillio Call By (Sender)</label>
      <select name="twillioPurchasedNumber">
        <?php
        for($i=0;$i<count($numbers);$i++){
        ?>
        <option value="<?=$numbers[$i]->number?>" <?php if(isset($_POST['twillioPurchasedNumber'])&&$_POST['twillioPurchasedNumber']==$numbers[$i]->number){ echo "selected";}?>><?=$numbers[$i]->number?></option>
         <?php
         }
        ?>  
      </select> 
     </div>
     <div class="form-group">
          <label class="label" for="msg">Message:</label>
          <textarea class="form-control" rows="5" name="msg" id="msg"><?php echo isset($_POST['msg'])?$_POST['msg']:''; ?></textarea>
      </div>
      
      <div class="form-group">
        <a href="javascript:void(0)" class="clickMe2" onClick="showhideClass2();"><i class="fa fa-plus"></i></a>
         <label  class="label">SMS Media</label>
        <?php
		  $sms_media  = $wpdb->get_results("select * from wp_sms_media"); 
		?>
        <div style="overflow-x:auto;width:100%;" class="sh2 hide2">      
        <table cellspacing="3" cellpadding="3" class="table table-striped table-bordered">
                <tr>
                    <th>Choice</th>
                    <th>Media Name</th>
                    <th>Media File</th>
                </tr>
                <?php foreach($sms_media as $c){ ?>
                <tr>
                    <td><input type="radio" name="media" value="<?php echo $c->id; ?>" <?php if(isset($_POST['media'])&&$_POST['media']==$c->id){ echo "checked";} ?>></td>
                    <td><?php echo $c->sms_media_name; ?></td>       
                    <td><?php echo $c->sms_media_file; ?><br>
                        <audio controls>
                          <source src="<?php echo $c->sms_media_file; ?>" type="audio/ogg">
                          <source src="<?php echo $c->sms_media_file; ?>" type="audio/mpeg">
                        Your browser does not support the audio element.
                        </audio>
                    </td>
                </tr>
                <?php } ?>
            </table>
        </div>
      </div>
      <div class="form-group">
        <input type="submit" class="btn btn-success label" value="Send">
      </div>
</form>


<div class="row">
  <div class="col">
     <div class="form-group">
	   <a href="admin.php?page=sms_history" class="btn btn-secondary label">History</a>
     </div>
  </div>
</div>


<script>
   

function chkRequired(){	
	var selected = [];
	$('input[name="phone[]"]').each(function() {
	   if ($(this).is(":checked")) {
		   selected.push($(this).attr('value'));
	   }
	});
	if(selected.length<1){
	  alert("Please select at least one phone no");
	 return false; 
	} 
	
	if($("#msg").val()==''){
		 alert("Message is a required field");
		 return false; 
	}
	 
	 return true;
}

function setChk(value){
	if($("#chkunchk").is(':checked')){
		$('input[name="phone[]"]').each(function() {
		   $(this).prop('checked', true);
		});
	}else{
		$('input[name="phone[]"]').each(function() {
		   $(this).prop('checked', false);
		});
	}
}

function showhideClass(){
                if($(".sh").hasClass('show')){
					$(".sh").removeClass('show');
					$(".sh").addClass('hide');
					$('.clickMe').html('<i class="fa fa-plus"></i>');
				}
				else if($(".sh").hasClass('hide')){
					$(".sh").removeClass('hide');
					$(".sh").addClass('show');
					$('.clickMe').html('<i class="fa fa-minus"></i>');
				} 
		  }		
function showhideClass2(){
                if($(".sh2").hasClass('show2')){
					$(".sh2").removeClass('show2');
					$(".sh2").addClass('hide2');
					$('.clickMe2').html('<i class="fa fa-plus"></i>');
				}
				else if($(".sh2").hasClass('hide2')){
					$(".sh2").removeClass('hide2');
					$(".sh2").addClass('show2');
					$('.clickMe2').html('<i class="fa fa-minus"></i>');
				} 
		  }				
</script>