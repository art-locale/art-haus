<?php require_once("head-utils.php");?>

<?php require_once("sign-in-modal.php");?>

<?php require_once("footer.php");?>

<header>

  <div class="container-fluid">
    <nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark">
      <img src="../src/img/logo.svg" alt="logo" class="logo" /> <!-- TODO: Add Logo-->
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link" href="sign-up.php">Sign Up</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="sign-in.php">Sign In</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="update-profile.php">Profile</a>
          </li>
        </ul>
        <form class="form-inline my-2 my-lg-0">
          <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
          <button class="btn btn-outline-info my-2 my-sm-0" type="submit">Search</button>
        </form>
      </div>
    </nav>
  </div>

</header>
