<?php require_once ("head-utils.php");?>

<?php require_once("navbar.php");?>

<main>

  <!-- Button trigger modal --> <!-- TODO- Need to add to page?-->
  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#signInModal">
    Sign In
  </button>

    <!-- Sign In Modal -->
    <div class="modal fade" id="signInModal" tabindex="-1" role="dialog" aria-labelledby="signInModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content gray">
                <div class="modal-header gray">
                    <h5 class="modal-title" id="signInModal">Please Sign In</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body gray">
                    <form class="form-control-lg" id="form" action="" method="post">
                        <div class="info">
                                <input class="form-control" id="email" type="email" name="email" placeholder=" Email"/>
                                <input class="form-control" id="password" type="text" name="password" placeholder=" Password">
                        </div>
                    </form>
                    <div class="modal-footer">
                        <input class="btn btn-info" type="submit" value="Sign In">
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
