<?php require_once("head-utils.php");?>

<?php require_once("navbar.php");?>

<?php require_once("footer.php");?>

<main>

	<div class="container bg-secondary h-100">

		<h1 class="text-center">Sign Up For Art Haus!</h1>

		<form [formGroup]="signUpForm" class="form-control-lg" id="form" action="" method="post" (submit)="createSignUp();" novalidate>
			<div class="form-group">
				<label class="d-flex justify-content-start" for="name">Name</label>
				<input type="text" class="d-flex justify-content-start form-control " id="name" placeholder="Name"/>
			</div>

			<div class="form-group">
				<label class="d-flex justify-content-start" for="email">Email Address</label>
				<input type="email" class="d-flex justify-content-start form-control" id="email" placeholder="Email"/>
			</div>

			<div class="form-group">
				<label class="d-flex justify-content-start" for="addressLine1">Address Line 1</label>
				<input type="text" class="d-flex justify-content-start form-control" id="addressLine1" placeholder="Street address, PO box, company name, c/o">
			</div>

			<div class="form-group">
				<label class="d-flex justify-content-start" for="addressLine2">Address Line 2</label>
				<input type="text" class="d-flex justify-content-start form-control" id="addressLine2" placeholder="Apartment, suite, unit, building, floor, etc.">
			</div>

			<div class="form-group">
				<label class="d-flex justify-content-start" for="city">City</label>
				<input type="text" class="d-flex justify-content-start form-control" id="city" placeholder="City">
			</div>

			<div class="form-group">
				<label class="d-flex justify-content-start" for="state">State/Province/Region</label>
				<input type="text" class="d-flex justify-content-start form-control" id="state" placeholder="State, province, region">
			</div>

			<div class="form-group">
				<label class="d-flex justify-content-start" for="zip">ZIP/Postal Code</label>
				<input type="text" class="d-flex justify-content-start form-control" id="zip" placeholder="Zip/Postal Code">
			</div>

			<div class="form-group">
				<label class="d-flex justify-content-start" for="country">Country</label>
				<input type="text" class="d-flex justify-content-start form-control" id="country" placeholder="Country">
			</div>

			<div class="form-group">
				<label class="d-flex justify-content-start" for="website">Your Website</label>
				<input type="password" class="d-flex justify-content-start form-control" id="website" placeholder="Your Website">
			</div>

			<div class="form-group">
				<label for="password">Password</label>
				<input type="password" class="form-control" id="password" placeholder="Password">
			</div>

			<div class="form-group">
				<label class="d-flex justify-content-start" for="passwordConfirm">Confirm Password</label>
				<input type="password" class="d-flex justify-content-start form-control" id="passwordConfirm" placeholder="Confirm Password">
			</div>

			<button type="submit" class="btn btn-info">Submit</button>
		</form>
	</div>

</main>
