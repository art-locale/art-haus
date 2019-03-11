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

   <!--CAROUSEL:-->
	<div id="carousel" class="carousel slide bg-dark" data-ride="carousel">
		<div class="carousel-inner">
         <!--GALLERY 1:-->
			<div class="carousel-item active">
				<img class="d-block w-100 my-3" src="../sample-images/sample-image-1.jpg" alt="First slide">
				  	<div class="carousel-caption bg-dark">
						<h5>Gallery Name</h5>
					</div>
			</div>
         <!--GALLERY 2:-->
			<div class="carousel-item">
				<img class="d-block w-100 my-3" src="../sample-images/sample-image-2.jpg" alt="Second slide">
					<div class="carousel-caption bg-dark">
						<h5>Gallery Name</h5>
					</div>
			</div>
         <!--GALLERY 3:-->
			<div class="carousel-item">
				<img class="d-block w-100 my-3" src="../sample-images/sample-image-3.jpg" alt="Third slide">
					<div class="carousel-caption bg-dark ">
						<h5>Gallery Name</h5>
					</div>
			</div>
      <!--CONTROLS, PREVIOUS:-->
		<a class="carousel-control-prev" href="#carousel" role="button" data-slide="prev">
			<span class="carousel-control-prev-icon text-muted" aria-hidden="true"></span>
			<span class="sr-only text-muted">Previous</span>
		</a>
      <!--CONTROLS, NEXT:-->
		<a class="carousel-control-next" href="#carousel" role="button" data-slide="next">
			<span class="carousel-control-next-icon text-muted" aria-hidden="true"></span>
			<span class="sr-only text-muted">Next</span>
		</a>
		
		</div>
	</div>
</div>

</main>
