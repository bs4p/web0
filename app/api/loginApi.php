<?php
session_start();
require_once 'app/bootstrap.php';

if (!isset($_POST['_csrf'])) {
  http_response_code(404);
  die("<h1 style='color:red'>404 Not Found ({$_SERVER['REQUEST_URI']})</h1>");
}
$pdo = pdo();
$email = htmlspecialchars(strtolower($_POST["_email"]));
$password = $_POST["_password"];

$checkEmailRegistered = $pdo->query("SELECT email FROM users WHERE email = " . $pdo->quote($email));
$checkEmailResult = $checkEmailRegistered->fetch(PDO::FETCH_NUM);
if (!$checkEmailResult) {
  redirect("/", "email is not registered");
  die;
}

$checkPassword = $pdo->query("SELECT password FROM users WHERE email = " . $pdo->quote($checkEmailResult[0]));
$checkPasswordResult = $checkPassword->fetch(PDO::FETCH_NUM);
if (!password_verify($password,  $checkPasswordResult[0])) {
  redirect("/", "incorrect password");
  die;
}

if (isset($_POST["_remember"])) setcookie('key', '1', time() + 120);
$_SESSION["login"] = true;
redirect("/home.php", "Welcome {$checkEmailResult[0]}");
