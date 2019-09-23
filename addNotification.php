<?php
include_once("includes/include.php");
use Login\CheckUser;

if($_SERVER['REQUEST_METHOD'] == "POST") {
	$add = new CheckUser();
	$userId = $_POST['userId'];
	$add->addNotification($userId);
}