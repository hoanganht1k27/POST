<?php
include_once('includes/include.php');
use Login\CheckUser;

if($_SERVER['REQUEST_METHOD'] == "POST") {
	$username = $_POST['username'];
	$password = $_POST['password'];
	$confirmPass = $_POST['confirm-password'];
	if($username == "" || $password == "") {
		header("Location: register.php?status=empty");
		exit();
	}

	if($password != $confirmPass) {
		header("Location: register.php?status=failed");
		exit();
	}

	$newUser = new CheckUser();
	$res = $newUser->newUser($username, $password);

	$status = $res;
	if($status != "trung") $status = "success";
	if($status != "trung") {
		mkdir("avatar/".$res);
	}

	header("Location: login.php?status={$status}");
}