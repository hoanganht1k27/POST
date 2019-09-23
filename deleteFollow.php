<?php
include_once('includes/include.php');
use Login\CheckUser;

session_start();

if($_SERVER['REQUEST_METHOD'] == "POST") {
	$userId = $_POST['id'];
	$follow = new CheckUser();
	$following = $follow->getFollowing($_SESSION['id']);
	$following = json_decode($following);
	//array_push($following, intval($userId));
	foreach ($following as $key => $value) {
		if($value == intval($userId)) {
			array_splice($following, $key, 1);
		}
	}
	print_r($following);
	$following = json_encode($following);
	echo $following;

	$follow->addFollowing($following, $_SESSION['id']);

}