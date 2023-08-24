
 <link 
  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.css" 
  rel="stylesheet"  type='text/css'>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<?php
 error_reporting(!E_WARNING);
?>
<a  href="<?php echo 'admin.php?page=dial'; ?>" class="btn btn-info"><i class="arrow_left"></i> List</a>
<h5 class="font-20 mt-15 mb-1"><?php if($id<0){echo "Save";}else { echo "Update";} echo " "; echo str_replace('_',' ','Dial'); ?></h5>
<!--Form to save data-->
<form method="post" action="admin.php?page=dial&cmd=save&id=<?=$dial[0]->id?>" enctype="multipart/form-data">
<div class="card">
   <div class="card-body"> 
   
         <div class="form-group"> 
         <label for="JMedia type" class="col-md-4 control-label">Forward type</label> 
          <div class="col-md-8"> 
            <select name="forward_for"  id="forward_for"  class="form-control"/> 
             <option value="">--Select--</option> 
              <option value="sms" <?php if($dial[0]->forward_for=='sms'){ echo "selected";} ?>>SMS</option> 
              <option value="call" <?php if($dial[0]->forward_for=='call'){ echo "selected";} ?>>Call</option>
            </select> 
          </div> 
          </div>
          <div class="form-group"> 
          <label for="Media name" class="col-md-4 control-label">Receiver name</label> 
          <div class="col-md-8"> 
           <input type="text" name="receiver_name" value="<?php echo ($_POST['receiver_name'] ? $_POST['receiver_name'] : $dial[0]->receiver_name); ?>" class="form-control" id="receiver_name" /> 
          </div> 
           </div>
		   
		   <div class="form-group"> 
          <label for="Media name" class="col-md-4 control-label">Twilio no</label> 
          <div class="col-md-8">
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
         
      <select name="twilio_no">
        <?php
        for($i=0;$i<count($numbers);$i++){
        ?>
        <option value="<?=$numbers[$i]->number?>" <?php if(isset($_POST['twilio_no'])&& $_POST['twilio_no'] ==$dial[0]->twilio_no){ echo "selected";}?>><?=$numbers[$i]->number?></option>
         <?php
         }
        ?>  
      </select> 
          
          
          
          
          
           </div>  
         
          <div class="form-group"> 
          <label for="Media name" class="col-md-4 control-label">phone</label> 
          <div class="col-md-8"> 
           <input type="text" name="phone" value="<?php echo ($_POST['phone'] ? $_POST['phone'] : $dial[0]->phone); ?>" class="form-control" id="phone" /> 
          </div> 
           </div>  
           
         <div class="form-group"> 
         <label for="JMedia type" class="col-md-4 control-label">Status</label> 
          <div class="col-md-8"> 
            <select name="status"  id="status"  class="form-control"/> 
              <option value="">--Select--</option> 
              <option value="active" <?php if($dial[0]->status=='active'){ echo "selected";} ?>>Active</option> 
              <option value="inactive" <?php if($dial[0]->status=='inactive'){ echo "selected";} ?>>Inactive</option>
           </select> 
          </div> 
           </div>
   </div>
</div>
<div class="form-group">
    <div class="col-sm-offset-4 col-sm-8">
        <input type="hidden" name="id" value="<?=$dial[0]->id?>" >
        <button type="submit" class="btn btn-success"><?php if(empty($dial[0]->id)){?>Save<?php }else{?>Update<?php } ?></button>
    </div>
</div>
</form>
<!--End of Form to save data//-->	
<!--JQuery-->
<script>
	$( ".datepicker" ).datepicker({
		dateFormat: "yy-mm-dd", 
		changeYear: true,
		changeMonth: true,
		showOn: 'button',
		buttonText: 'Show Date',
		buttonImageOnly: true,
		buttonImage: '<?php echo base_url(); ?>public/datepicker/images/calendar.gif',
	});
</script>  			