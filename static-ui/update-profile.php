<?php require_once("head-utils.php");?>

<?php require_once("navbar.php");?>

<?php require_once("footer.php");?>

<main>

  <div class="container-fluid">
    <h1 class="text-center">Update Profile</h1>

    <form>
      <div class="form-group">
        <label for="name">Name</label>
        <input type="text" class="form-control" id="name" placeholder="Name">
      </div>
      <div class="form-group">
        <label for="email">Email Address</label>
        <input type="email" class="form-control" id="email" placeholder="Email">
      </div>
      <div class="form-group">
        <label for="website">Website</label>
        <input type="text" class="form-control" id="website" aria-describedby="websiteHelp" placeholder="Website">
        <small id="websiteHelp" class="form-text text-muted">Add your website to share with others.</small>
      </div>
      <div class="form-group">
        <label for="currentPassword">Current Password</label>
        <input type="password" class="form-control" id="currentPassword" placeholder="Current Password">
      </div>
      <div class="form-group">
        <label for="newPassword">New Password</label>
        <input type="password" class="form-control" id="newPassword" placeholder="New Password">
      </div>
      <div class="form-group">
        <label for="newPasswordConfirm">Confirm New Password</label>
        <input type="password" class="form-control" id="newPasswordConfirm" placeholder="Confirm New Password">
      </div>
      <button type="submit" class="btn btn-info">Submit Changes</button>
    </form>

  </div>

</main>
