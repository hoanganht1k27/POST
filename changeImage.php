<?php
include_once('includes/include.php');
use Login\CheckUser;

session_start();

if($_SERVER['REQUEST_METHOD'] == "POST") {
	if(isset($_POST['submit'])) {
		$checkAva = null;

		if($_FILES['avatar']['tmp_name'])
		$checkAva = getimagesize($_FILES['avatar']['tmp_name']);

		if($_FILES['avatar']['tmp_name']) {
			$tmp = $_FILES['avatar']['name'];
			$tmp = basename($tmp);
			$extension = strtoupper(pathinfo($tmp, PATHINFO_EXTENSION));
			if($extension != "JPG") {
				header("Location: profile.php?change=invalid");
				exit();
			}
		}

		if($_FILES['background']['tmp_name']) {
			$tmp = $_FILES['background']['name'];
			$tmp = basename($tmp);
			$extension = strtoupper(pathinfo($tmp, PATHINFO_EXTENSION));
			if($extension != "JPG") {
				header("Location: profile.php?change=invalid");
				exit();
			}
		}

		$img = new CheckUser();
		if($checkAva) {
			$img->uploadAvatar($_FILES['avatar']['tmp_name'], $_SESSION['id']);
		}

		$checkBg = null;
		if($_FILES['background']['tmp_name'])
		$checkBg = getimagesize($_FILES['background']['tmp_name']);
		if($checkBg) {
			$img->uploadBackground($_FILES['background']['tmp_name'], $_SESSION['id']);
		}
		header("Location: profile.php?change=success");
	}
}