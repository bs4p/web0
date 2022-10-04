<?php
session_start();
require_once './app/global.php';

?>
<?php require_once './app/template/header.php'; ?>
<div class="container">
  <div class="row justify-content-center">
    <div class="col-lg-6">
      <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
          <div class="p-5">
            <div class="text-center">
              <h1 class="h4 text-gray-900 mb-4">Login</h1>
            </div>
            <form class="user" method="post" action="app/api/loginApi.php">
              <?= showFlash(); ?>
              <div class="form-group">
                <input type="email" class="form-control form-control-user" id="email" placeholder="Email Address" name="_email" />
              </div>
              <div class="form-group">
                <input type="password" class="form-control form-control-user" id="password" placeholder="Password" name="_password" />
              </div>
              <div class="form-group">
                <div class="custom-control custom-checkbox small">
                  <input type="checkbox" class="custom-control-input" id="remember" name="_remember" />
                  <label class="custom-control-label" for="remember">Remember Me</label>
                </div>
              </div>
              <button type="submit" class="btn btn-primary btn-user btn-block" name="__login">Login</button>
            </form>
            <hr />
            <div class="text-center">
              <a class="small" href="register.php">Create an Account!</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php require_once './app/template/footer.php'; ?>