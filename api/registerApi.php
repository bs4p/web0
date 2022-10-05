<?php
session_start();
require_once '../app/global.php';
require_once '../app/Database.php';

if (!isset($_POST['__register'])) {
  pageError(404);
}

$db = new Database();

$name = htmlspecialchars(strtolower($_POST["_name"]));
$email = htmlspecialchars(strtolower($_POST["_email"]));
$password = $_POST["_password"];
$passwordRepeat = $_POST["_password_repeat"];

if (empty($name) || empty($email) || empty($password)) {
  createFlash("danger", "all input must be filled and can't be empty");
  redirect("/register.php");
}

$emailRegistered = $db->query("SELECT email FROM users WHERE email = " . $db->quote($email))->fetch();
if ($emailRegistered) {
  createFlash("danger", "email '{$email}' has been used");
  redirect("/register.php");
}

if ($password != $passwordRepeat) {
  createFlash("danger", "password and confirmation doesn't match");
  redirect("/register.php");
}

$passwordHash = password_hash($password, PASSWORD_DEFAULT);

$db->prepare("INSERT INTO users(id, name, email, password) VALUES(NULL, ?, ?, ?)")
  ->bindValue(1, $name)
  ->bindValue(2, $email)
  ->bindValue(3, $passwordHash)
  ->execute();

if ($db->rowCount() == 1) {
  createFlash("success", "{$email} was successfully created !");
  redirect("/");
}
