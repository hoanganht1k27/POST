<?php
include_once("includes/include.php");
use Login\CheckUser;

if($_SERVER['REQUEST_METHOD'] == "POST") {
	$userId = $_POST['userId'];

	$room = new CheckUser();
	$room = $room->getRoomId($userId);

	echo $room;
}