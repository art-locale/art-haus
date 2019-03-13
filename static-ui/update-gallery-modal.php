<?php require_once("head-utils.php");?>

<?php require_once("navbar.php");?>

<?php require_once("footer.php");?>

<main>

  <!-- Image Upload Modal -->
  <div class="modal fade" id="galleryRenameModal" tabindex="-1" role="dialog" aria-labelledby="galleryRenameModal" aria-hidden="true">
      <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="imageUploadModal">Rename A Gallery</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close" />
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                  <form class="form-control-lg" id="form" action="" method="post">
                      <div class="info">
                              <input class="form-control" id="galleryName" type="text" name="galleryName" placeholder="Gallery Name" />
                              <input class="form-control" id="newGalleryName" type="text" name="newGalleryName" placeholder="New Gallery Name" />
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
