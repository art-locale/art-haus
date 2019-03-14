<?php require_once("head-utils.php");?>

<?php require_once("navbar.php");?>

<?php require_once("footer.php");?>

<main>

	  <div class="modal fade" id="profileUpdateModal" tabindex="-1" role="dialog" aria-labelledby="profileUpdateModal" aria-hidden="true">
		  <div class="modal-dialog" role="document">
			  <div class="modal-content">
				  <div class="modal-header">
					  <h5 class="modal-title" id="profileUpdateModal">Update Your Profile</h5>
					  <button type="button" class="close" data-dismiss="modal" aria-label="Close" />
					  <span aria-hidden="true">&times;</span>
					  </button>
				  </div>
				  <div class="modal-body">
					  <form class="form-control-lg" id="form" action="" method="post">
						  <div class="info">
							  <input class="form-control" id="newProfileName" type="text" name="newProfileName" placeholder="Profile Name" />
							  <input class="form-control" id="newEmail" type="text" name="newEmail" placeholder="Email" />
							  <input class="form-control" id="newAddressLine1" type="text" name="newAddressLine1" placeholder="Address Line 1" />
							  <input class="form-control" id="newAddressLine2" type="text" name="newAddressLine2" placeholder="Address Line 2" />
							  <input class="form-control" id="newCity" type="text" name="newCity" placeholder="City" />
							  <input class="form-control" id="newState" type="text" name="newState" placeholder="State/Province/Region" />
							  <input class="form-control" id="newZip" type="number" name="newZip" placeholder="Zip/Postal Code" />
							  <input class="form-control" id="newCountry" type="text" name="newCountry" placeholder="Country" />
							  <input class="form-control" id="newWebsite" type="text" name="newWebsite" placeholder="Website" />
							  <input class="form-control" id="currentPassword" type="password" name="currentPassword" placeholder="Current Password" />
							  <input class="form-control" id="newPassword" type="password" name="newPassword" placeholder="New Password" />
						  </div>
					  </form>
					  <div class="modal-footer">
						  <input class="btn btn-info" type="submit" value="Submit" />
					  </div>
				  </div>
			  </div>
		  </div>
	  </div>

</main>
