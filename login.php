<?php 
  require_once 'layout/header.php';

  ?>
<?php include "action_login.php"; ?>
  <div class="container">
    <div class="row">
      <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
        <div class="card border-0 shadow rounded-3 ">
          <div class="card-body p-sm-5">
            <h2 class="card-title text-center mb-5 fw-light fs-5">Sign In</h2>
            <form class="px-4 py-3 form-signin" action="login.php" method="POST">
              <?php if (isset($error)) { ?>
                <p class="error"><?php echo $error['error']; ?>  </p>
              <?php } ?>
              <div class="form-floating mb-3">
                <input type="email" class="form-control" id="floatingInput" placeholder="Username" name="email">
                <label for="floatingInput">Email</label>
              </div>
              <div class="form-floating mb-3">
                <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="pass">
                <label for="floatingPassword">Password</label>
              </div>
              <div class="d-grid">
                <button class="btn btn-primary btn-login text-uppercase fw-bold" type="submit">Sign
                  in</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php 
  require_once 'layout/footer.php';
  ?>