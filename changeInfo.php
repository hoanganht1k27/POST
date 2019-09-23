<?php
include_once("includes/include.php");
use Login\CheckUser;

session_start();

if($_SERVER['REQUEST_METHOD'] == "POST") {
	$username = $_POST['change-username'];
	$oldPass = $_POST['old-password'];
	$newPass = $_POST['new-pass'];
	$confirmNewPass = $_POST['confirm-new-pass'];

	$t = new CheckUser();
	$status = $t->getIdOfName($username);

	if($status != "trung") {
		$status = $t->updateUsername($_SESSION['id'], $username);
	} 

	$checkPass = "";

	if($newPass != $confirmNewPass) $checkPass = "failed";
	if(!$t->checkPass($_SESSION['id'], $oldPass)) {
		$checkPass = "failed";
	}

	if($checkPass != "failed") {
		$checkPass = $t->changePassword($_SESSION['id'], $newPass);
	}

	header("Location: profile.php?status={$status}&checkpass={$checkPass}");
}