<?php require_once("head-utils.php");?>

<?php require_once("navbar.php");?>

<?php require_once("footer.php");?>

<main>

  <!-- Gallery Upload Modal -->
  <div class="modal fade" id="galleryCreationModal" tabindex="-1" role="dialog" aria-labelledby="galleryCreationModal" aria-hidden="true">
      <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="galleryCreationModal">Create A Gallery</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close" />
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                  <form class="form-control-lg" id="form" action="" method="post">
                      <div class="info">
                              <input class="form-control" id="galleryName" type="text" name="galleryName" placeholder="Gallery Name" />
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
