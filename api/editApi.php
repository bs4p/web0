<?php
session_start();
require_once '../app/global.php';
require_once '../app/Database.php';

if (!isset($_POST["__edit"])) {
  pageError(404);
}

$db = new Database();

$id = $_POST["_id"];
$name = htmlspecialchars(ucwords($_POST["_name"]));
$email = htmlspecialchars(strtolower($_POST["_email"]));

$dataDb = $db->query("SELECT id,name,email FROM users WHERE id = {$id}")->fetch();

$dataDiff = [
  [$dataDb['name'], $name],
  [$dataDb['email'], $email],
];

$updates = [];
foreach ($dataDiff as $diff) {
  if ($diff[0] != $diff[1]) {
    $updates[] = "~ {$diff[0]} updated to {$diff[1]}";
  }
}

if ($updates == []) {
  createFlash("success", "No data was edited");
} else {
  $db->prepare("UPDATE users SET name = :name, email = :email WHERE id = :id")
    ->bindValue('name', $name)
    ->bindValue('email', $email)
    ->bindValue('id', $id)
    ->execute();

  createFlash("success", implode("<br>", $updates));
}
redirect("/home.php");
