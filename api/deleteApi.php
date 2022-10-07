<?php
session_start();
require_once '../app/global.php';
require_once '../app/Database.php';

if (!isset($_GET["id"])) {
  pageError(404);
}

$db = new Database();

$id = $_GET["id"];

$checkId = $db->query("SELECT id FROM users WHERE id = {$id}")->fetch();

if (!$checkId) {
  createFlash("warning", "Illegal action no data found");
} else {
  $deleteData = $db->query("DELETE FROM users WHERE id = {$id}");
  createFlash("success", "A data was successfully deleted");
}
redirect("/home.php");
