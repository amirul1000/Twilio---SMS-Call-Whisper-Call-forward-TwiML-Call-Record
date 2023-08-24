<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

<h3><a href="edit.php?post_type=contactsettings" class="btn btn-secondary">Contact Settings</a></h3>
<form method="post" action="admin.php?page=theme-options">
  <div class="form-group">
    <label for="To">To</label>
    <input type="text" class="form-control" name="To" id="To" value="<?=get_post_meta($post->ID, "To", true)?>" placeholder="To">
  </div>
  <div class="form-group">
    <label for="From">From</label>
    <input type="text" class="form-control" name="From" id="From" value="<?=get_post_meta($post->ID, "From", true)?>" placeholder="Address">
  </div>
  <div class="form-group">
    <label for="Timestamp">Timestamp</label>
    <input type="text" class="form-control"  name="Timestamp" id="Timestamp" value="<?=get_post_meta($post->ID, "Timestamp", true)?>" placeholder="Phone">
  </div>
  <div class="form-group">
    <label for="AccountSid">AccountSid</label>
    <input type="text" class="form-control"  name="AccountSid" id="AccountSid" value="<?=get_post_meta($post->ID, "AccountSid", true)?>" placeholder="AccountSid">
  </div>
</form>

