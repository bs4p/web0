<?php
session_start();
require_once '../app/global.php';

if (!isset($_POST["__logout"])) {
  pageError(404);
}

session_destroy();
session_unset();
setcookie("id", "", time() - 3600, "/");
setcookie("key", "", time() - 3600, "/");

redirect("/");
