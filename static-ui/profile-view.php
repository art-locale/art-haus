<?php require_once("head-utils.php");?>

<?php require_once("navbar.php");?>

<?php require_once("footer.php");?>

<main>

	<div class="jumbotron jumbotron-fluid">
		<div class="container">
			<h1 class="display-4">PROFILE NAME</h1>
			<p class="lead">Profile Email<br/>Profile Website</p>
		</div>
	</div>

	<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
		<ol class="carousel-indicators">
			<li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
			<li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
			<li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
		</ol>
		<div class="carousel-inner">
			<div class="carousel-item active">
				<img class="d-block w-100" src="../sample-images/sample-image-1.jpg" alt="First slide">
				\  <div id="carouselCaption" class="carousel-caption d-none d-md-block bg-dark">
					<h5>Gallery Name</h5>
					<p>Some description of image</p>
			</div>
			<div class="carousel-item">
				<img class="d-block w-100" src="../sample-images/sample-image-2.jpg" alt="Second slide">
				<div id="carouselCaption" class="carousel-caption d-none d-md-block bg-dark">
					<h5>Gallery Name</h5>
					<p>Some description of image</p>
			</div>
			<div class="carousel-item">
				<img class="d-block w-100" src="../sample-images/sample-image-3.jpg" alt="Third slide">
				<div id="carouselCaption" class="carousel-caption d-none d-md-block bg-dark ">
					<h5>Gallery Name</h5>
					<p>Some description of image</p>
			</div>
		</div>
		<a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
			<span class="carousel-control-prev-icon" aria-hidden="true"></span>
			<span class="sr-only">Previous</span>
		</a>
		<a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
			<span class="carousel-control-next-icon" aria-hidden="true"></span>
			<span class="sr-only">Next</span>
		</a>
	</div>

</main>