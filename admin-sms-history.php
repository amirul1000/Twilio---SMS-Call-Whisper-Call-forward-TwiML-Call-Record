<?php
   include(plugin_dir_path( __FILE__ ) .'/Twilio/autoload.php');
   use Twilio\Rest\Client;
   $sid = SID;
   $token = TOKEN;
	
   $client = new Client($sid, $token);
   
   $messageList = $client->messages->read([],100);
   ?>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
   <h3>SMS History</h3>
   <table class="table">
     <tr>
       <td>ID</td>
       <td>From</td>
       <td>TO</td>
       <td>Status</td>
        <td>Body</td>
     </tr>
     <?php
	 
foreach ($messageList as $msg) {
    ?>
     <tr>
       <td><?=$msg->sid?></td>
       <td><?=$msg->from?></td>
       <td><?=$msg->to?></td>
       <td><?=$msg->status?></td>
        <td><?=$msg->body?></td>
     </tr>
<?php
}
?>
</table>