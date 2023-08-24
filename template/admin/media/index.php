 <link 
  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.css" 
  rel="stylesheet"  type='text/css'>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<h5 class="font-20 mt-15 mb-1">Call Media</h5>

<!--Action-->
<div>
	<div class="float_left padding_10">
		<a href="admin.php?page=media&cmd=edit"
			class="btn btn-success">Add</a>
	</div>
	
	
</div>
<!--End of Action//--> 
   
<!--Data display of media-->     
<div style="overflow-x:auto;width:100%;">      
<table cellspacing="3" cellpadding="3" class="table table-striped table-bordered">
    <tr>
		<th>Media Name</th>
        <th>Media Type</th>
        <th>Call Greeting Msg</th>
        <th>Media File</th>
		<th>Actions</th>
    </tr>
	<?php foreach($media as $c){ ?>
    <tr>
        <td><?php echo $c->media_name; ?></td>
        <td><?php echo $c->media_type; ?></td>
         <td><?php echo $c->greeting; ?></td>
        <td><?php echo $c->media_file; ?><br>
            <audio controls>
              <source src="<?php echo $c->media_file; ?>" type="audio/ogg">
              <source src="<?php echo $c->media_file; ?>" type="audio/mpeg">
            Your browser does not support the audio element.
            </audio>

        </td>

		<td>
            <a href="admin.php?page=media&cmd=edit&id=<?=$c->id?>" class="action-icon"> Edit</a>
            <a href="admin.php?page=media&cmd=delete&id=<?=$c->id?>" onClick="return confirm('Are you sure to delete this item?');" class="action-icon"> Delete</a>
         </td>
    </tr>
	<?php } ?>
</table>
</div>
<!--End of Data display of media//--> 

<!--No data-->
<?php
	if(count($media)==0){
?>
 <div align="center"><h3>Data does not exists</h3></div>
<?php
	}
?>
<!--End of No data//-->

<!--Pagination-->
<!--End of Pagination//-->
