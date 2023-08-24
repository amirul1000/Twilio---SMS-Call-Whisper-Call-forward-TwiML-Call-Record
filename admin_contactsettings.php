<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

<h3><a href="edit.php?post_type=contactsettings" class="btn btn-secondary">Contact Settings</a></h3>
<form method="post" action="admin.php?page=theme-options">
  <div class="form-group">
    <label for="TWILIO_ACCOUNT_SID">Name</label>
    <input type="text" class="form-control" name="contact_name" id="contact_name" value="<?=get_post_meta($post->ID, "contact_name", true)?>" placeholder="Name">
  </div>
  <div class="form-group">
    <label for="TWILIO_AUTH_TOKEN">Address</label>
    <input type="text" class="form-control" name="address" id="address" value="<?=get_post_meta($post->ID, "address", true)?>" placeholder="Address">
  </div>
  <div class="form-group">
    <label for="twilioPurchasedNumber">Phone</label>
    <input type="text" class="form-control"  name="phone" id="phone" value="<?=get_post_meta($post->ID, "phone", true)?>" placeholder="Phone">
  </div>
  <div class="form-group">
    <label for="twilioPurchasedNumber">Email</label>
    <input type="text" class="form-control"  name="email" id="email" value="<?=get_post_meta($post->ID, "email", true)?>" placeholder="Email">
  </div>
</form>


