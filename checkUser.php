<?php
include_once('includes/include.php');
use Login\CheckUser;

session_start();

if($_SERVER["REQUEST_METHOD"] == "POST") {
	$check = new CheckUser();
	$username = $_POST['username'];
	$password = $_POST['password'];
	$status = $check->checkUser($username, $password);
}

header("Location: login.php?status={$status}");
