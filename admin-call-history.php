<?php
   include(plugin_dir_path( __FILE__ ) .'/Twilio/autoload.php');
   use Twilio\Rest\Client;
   $sid = SID;
   $token = TOKEN;
	
   $client = new Client($sid, $token);
   
   $callsList = $client->calls->read([], 20);
   ?>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
   <h3>Call History</h3>
   <table class="table">
     <tr>
       <td>From</td>
       <td>To</td>
       <td>duration</td>
       <td>Status</td>
     </tr>
     <?php
	 
foreach ($callsList as $call) {
    ?>
     <tr>
       <td><?=$call->from?></td>
       <td><?=$call->to?></td>
       <td><?=$call->duration?> seconds</td>
       <td><?=$call->status?></td>
     </tr>
<?php
}
?>
</table>