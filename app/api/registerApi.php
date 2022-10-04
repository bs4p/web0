<?php
session_start();
require_once 'app/global.php';

if (!isset($_POST['__login'])) {
  pageError(404);
}

$db = new Database();
$name = htmlspecialchars(strtolower($_POST["_name"]));
$email = htmlspecialchars(strtolower($_POST["_email"]));
$password = $_POST["_password"];
$passwordRepeat = $_POST["_password_repeat"];

$checkEmailRegistered = $pdo->query("SELECT email FROM users WHERE email = " . $pdo->quote($email));
if ($checkEmailRegistered->fetch(PDO::FETCH_ASSOC)) {
  redirect("/register.php", "email {$email} has been registered");
  die;
}

if ($password != $passwordRepeat) {
  redirect("/register.php", "password and confirmation is not the same");
  die;
}
$passwordHash = password_hash($password, PASSWORD_DEFAULT);

$insertNewUser = $pdo->prepare("INSERT INTO users(id, name, email, password) VALUES('', ?, ?, ?)");
$insertNewUser->execute([$name, $email, $passwordHash]);
if ($insertNewUser->rowCount() == 1) {
  redirect("/", "Account has been registered!!!");
  die;
}
