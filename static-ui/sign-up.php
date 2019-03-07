<?php require_once("head-utils.php");?>

<?php require_once("navbar.php");?>

<?php require_once("footer.php");?>

<main>

  <div class="container text-center">

    <h1>Sign Up For Art Haus!</h1>

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
        <label for="password">Password</label>
        <input type="password" class="form-control" id="password" placeholder="Password">
      </div>
      <div class="form-group">
        <label for="passwordConfirm">Confirm Password</label>
        <input type="password" class="form-control" id="passwordConfirm" placeholder="Confirm Password">
      </div>
      <button type="submit" class="btn btn-info">Submit</button>
    </form>
  </div>

</main>
