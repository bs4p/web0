<?php
require_once '../app/Database.php';

$id = $_GET['id'] ?? null;

$db = new Database();
$userData = $db->query("SELECT id,name,email FROM users WHERE id = {$id}")->fetch();
echo json_encode($userData);
