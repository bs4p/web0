<?php
session_start();
require_once './app/Database.php';

if (!isset($_POST['__login'])) {
  pageError(404);
}

$db = new Database();
$email = htmlspecialchars(strtolower($_POST["_email"]));
$password = $_POST["_password"];

$checkEmailRegistered = $db->query("SELECT email FROM users WHERE email = " . $db->quote($email));
$checkEmailResult = $checkEmailRegistered->fetch();
if (!$checkEmailResult) {
  createFlash('danger', 'email is not registered');
  redirect("/", "");
}

$checkPassword = $db->query("SELECT password FROM users WHERE email = " . $db->quote($checkEmailResult));
$checkPasswordResult = $checkPassword->fetch(PDO::FETCH_NUM);
if (!password_verify($password,  $checkPasswordResult[0])) {
  redirect("/", "incorrect password");
  die;
}

if (isset($_POST["_remember"])) setcookie('key', '1', time() + 120);
$_SESSION["login"] = true;
redirect("/home.php", "Welcome {$checkEmailResult[0]}");
