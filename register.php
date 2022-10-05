<?php $title = 'Home';
session_start();
require_once 'app/global.php';
?>

<?php $title = 'Register'; ?>
<?php require_once 'app/template/header.php'; ?>
<div class="container">
  <div class="row justify-content-center">
    <div class="col-lg-6">
      <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
          <div class="p-5">
            <div class="text-center">
              <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
            </div>
            <form class="user" method="post" action="api/registerApi.php">
              <?= showFlash(); ?>
              <div class="form-group">
                <input type="email" class="form-control form-control-user" id="email" name="_email" placeholder="Email Address">
              </div>
              <div class="form-group">
                <input type="text" class="form-control form-control-user" id="name" name="_name" placeholder="Full Name">
              </div>
              <div class="form-group row">
                <div class="col-sm-6 mb-3 mb-sm-0">
                  <input type="password" class="form-control form-control-user" id="password" name="_password" placeholder="Password">
                </div>
                <div class="col-sm-6">
                  <input type="password" class="form-control form-control-user" id="password_repeat" name="_password_repeat" placeholder="Repeat Password">
                </div>
              </div>
              <button type="submit" class="btn btn-primary btn-user btn-block" name="__register">
                Register
              </button>
            </form>
            <hr>
            <div class="text-center">
              <a class="small" href="/">Already have an account? Login!</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php require_once 'app/template/footer.php'; ?>