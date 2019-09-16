<?php
include_once('includes/include.php');
use Login\CheckUser;

if($_SERVER['REQUEST_METHOD'] == "POST") {
	$username = $_POST['username'];
	$password = $_POST['password'];

	$newUser = new CheckUser();
	$res = $newUser->newUser($username, $password);

	echo $res;

	// header("Location: login.php?status={$res}");
}