<?php require_once("head-utils.php");?>

<?php require_once("navbar.php");?>

<?php require_once("footer.php");?>

<main>
<!--JUMBOTRON:-->
	<div class="jumbotron jumbotron-fluid">
		<div class="container">
			<h1 class="display-4">PROFILE NAME</h1>
			<p class="lead">Profile Email<br/>Profile Website</p>
		</div>
	</div>
<!--CAROUSEL BAR:-->
<div class="carousel-bar containter-fluid">
<div class="row bg-dark">
<div class="mx-auto py-3">
   <!--CAROUSEL:-->
	<div id="carousel" class="carousel slide" data-ride="carousel">
		<div class="carousel-inner">
         <!--GALLERY 1:-->
			<div class="carousel-item active mb-2 mt-0">
				<img class="d-block w-100" src="../sample-images/sample-image-1.jpg" alt="First slide">
				  	<div class="carousel-caption d-md-block bg-dark">
						<h5>Gallery Name</h5>
					</div>
			</div>
         <!--GALLERY 2:-->
			<div class="carousel-item mb-2 mt-0">
				<img class="d-block w-100" src="../sample-images/sample-image-2.jpg" alt="Second slide">
					<div class="carousel-caption d-md-block bg-dark">
						<h5>Gallery Name</h5>
					</div>
			</div>
         <!--GALLERY 3:-->
			<div class="carousel-item mb-2 mt-0">
				<img class="d-block w-100" src="../sample-images/sample-image-3.jpg" alt="Third slide">
					<div class="carousel-caption d-md-block bg-dark ">
						<h5>Gallery Name</h5>
					</div>
			</div>
      <!--CONTROLS, PREVIOUS:-->
		<a class="carousel-control-prev" href="#carousel" role="button" data-slide="prev">
			<span class="carousel-control-prev-icon" aria-hidden="true"></span>
			<span class="sr-only">Previous</span>
		</a>
      <!--CONTROLS, NEXT:-->
		<a class="carousel-control-next" href="#carousel" role="button" data-slide="next">
			<span class="carousel-control-next-icon" aria-hidden="true"></span>
			<span class="sr-only">Next</span>
		</a>
		
		</div>
	</div>
</div>
</div>
</div>

</main>
