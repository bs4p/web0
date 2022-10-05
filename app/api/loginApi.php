<?php
session_start();
require_once '../global.php';
require_once '../Database.php';

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

$data = $db->query("SELECT * FROM users WHERE email = " . $db->quote($email))->fetch();
if (!$data) {
  createFlash("danger", "Email is not registered");
  redirect("/");
}

if (!password_verify($password,  $data["password"])) {
  createFlash("danger", "Incorrect password");
  redirect("/");
}

if (isset($_POST["_remember"])) {
  setcookie("id", "$data[id]", time() + 300, "/");
  setcookie("key", sha1($data["name"]), time() + 300, "/");
}

$_SESSION["login"] = [
  "id" => $data["id"],
  "name" => $data["name"],
  "email" => $data["email"],
];

redirect("/home.php");
