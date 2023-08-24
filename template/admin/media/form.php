 <link 
  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.css" 
  rel="stylesheet"  type='text/css'>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<?php
 error_reporting(!E_WARNING);
?>
<a  href="<?php echo 'admin.php?page=media'; ?>" class="btn btn-info"><i class="arrow_left"></i> List</a>
<h5 class="font-20 mt-15 mb-1"><?php if($id<0){echo "Save";}else { echo "Update";} echo " "; echo str_replace('_',' ','Wp_media'); ?></h5>
<!--Form to save data-->
<form method="post" action="admin.php?page=media&cmd=save&id=<?=$media[0]->id?>" enctype="multipart/form-data">
<div class="card">
   <div class="card-body">    
        
          <div class="form-group"> 
          <label for="Media name" class="col-md-4 control-label">Media name</label> 
          <div class="col-md-8"> 
           <input type="text" name="media_name" value="<?php echo ($_POST['media_name'] ? $_POST['media_name'] : $media[0]->media_name); ?>" class="form-control" id="media_name" /> 
          </div> 
           </div>
         <div class="form-group"> 
         <label for="JMedia type" class="col-md-4 control-label">Media type</label> 
          <div class="col-md-8"> 
            <select name="media_type"  id="media_type"  class="form-control"/> 
             <option value="">--Select--</option> 
              <option value="initiated" <?php if($media[0]->media_type=='initiated'){ echo "selected";} ?>>initiated</option> 
             <option value="ringing" <?php if($media[0]->media_type=='ringing'){ echo "selected";} ?>>ringing</option>
             <option value="answered" <?php if($media[0]->media_type=='answered'){ echo "selected";} ?>>answered</option>
              <option value="completed" <?php if($media[0]->media_type=='completed'){ echo "selected";} ?>>completed</option>
           </select> 
          </div> 
           </div>
          <div class="form-group"> 
          <label for="Media name" class="col-md-4 control-label">Call Greeting Msg</label> 
          <div class="col-md-8"> 
           <textarea name="greeting" class="form-control" id="greeting"><?php echo ($_POST['greeting'] ? $_POST['greeting'] : $media[0]->greeting); ?></textarea> 
          </div> 
           </div> 
          <div class="form-group"> 
          <label for="Join Class Condition" class="col-md-4 control-label">Media file</label> 
          <div class="col-md-8"> 
           <input type="file" name="media_file" value="" class="form-control" id="media_file" /> 
          </div> 
           </div>


   </div>
</div>
<div class="form-group">
    <div class="col-sm-offset-4 col-sm-8">
        <input type="hidden" name="id" value="<?=$media[0]->id?>" >
        <button type="submit" class="btn btn-success"><?php if(empty($media[0]->id)){?>Save<?php }else{?>Update<?php } ?></button>
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