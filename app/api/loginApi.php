<?php
session_start();
require_once "../global.php";
require_once "../Database.php";

if (!isset($_POST["__login"])) {
  pageError(404);
}

$db = new Database();

$email = htmlspecialchars(strtolower($_POST["_email"]));
$password = $_POST["_password"];

if (empty($email) || empty($password)) {
  createFlash("danger", "all input must be filled and can't be empty");
  redirect("/");
}

$dataByEmail = $db->query("SELECT * FROM users WHERE email = " . $db->quote($email))->fetch();
if (!$dataByEmail) {
  createFlash("danger", "Email is not registered");
  redirect("/");
}

if (!password_verify($password,  $dataByEmail["password"])) {
  createFlash("danger", "Incorrect password");
  redirect("/");
}

if (isset($_POST["_remember"])) {
  setcookie("key", sha1($dataByEmail["name"]), time() + 300);
}

$_SESSION["login"] = [
  "email" => $email,
  "name" => $dataByEmail["name"],
];
redirect("/home.php");
