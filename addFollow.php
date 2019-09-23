<?php
session_start();

include_once('includes/include.php');
use Login\CheckUser;

if($_SERVER['REQUEST_METHOD'] == "POST") {
	$userId = $_POST['id'];
	$follow = new CheckUser();
	$following = $follow->getFollowing($_SESSION['id']);
	$following = json_decode($following);
	$kt = 0;
	foreach ($following as $key => $value) {
		if($value == $userId) {
			$kt = 1;
			break;
		}
	}
	if($kt == 0)
	array_push($following, intval($userId));
	$following = json_encode($following);

	$follow->addFollowing($following, $_SESSION['id']);

	$followers = $follow->getFollowers($userId);
	$followers = json_decode($followers);

	array_push($followers, intval($_SESSION['id']));
	$followers = json_encode($followers);
	$follow->addFollowers($followers, $userId);

}