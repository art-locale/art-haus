<?php require_once("head-utils.php");?>

<?php require_once("sign-in-modal.php");?>

<?php require_once("image-upload-modal.php");?>

<?php require_once("update-gallery-modal.php");?>

<?php require_once("update-profile-modal.php");?>

<?php require_once("gallery-creation-modal.php");?>

<?php require_once("footer.php");?>

<header>

  <div class="container-fluid">
    <nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark">

      <a class="fab fa-2x fa-artstation justify-content-left" href="./home-view.php" id="logo"></a><!--TODO: fix logo anchor to assess whether or not user is logged in-->

      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link" href="sign-up.php">Sign Up</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="sign-in-modal.php" data-toggle="modal" data-target="#signInModal">Sign In</a>
          </li>
			  <li class="nav-item dropdown">
				  <a class="nav-link dropdown-toggle" id="navbarGalleryDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Gallery</a>
				  <div class="dropdown-menu" aria-labelledby="navbarProfileDropdown">
					  <a class="dropdown-item" href="gallery-creation-modal.php" data-toggle="modal" data-target="#galleryCreationModal">Add Gallery</a>
					  <a class="dropdown-item" href="update-gallery-modal.php" data-toggle="modal" data-target="#galleryRenameModal">Update Gallery</a>
				  </div>
			  </li>
          <li class="nav-item dropdown">
				  <a class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Profile</a>
				  <div class="dropdown-menu" aria-labelledby="navbarDropdown">
					  <a class="dropdown-item" href="profile-view.php">Profile Page</a>
					  <a class="dropdown-item" href="update-profile-modal.php" data-toggle="modal" data-target="#profileUpdateModal">Update Profile</a>
				  </div>
				  </li>
			  <li class="nav-item">
				  <a class="nav-link" href="image-upload-modal.php" data-toggle="modal" data-target="#imageUploadModal">Add Image</a>
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
