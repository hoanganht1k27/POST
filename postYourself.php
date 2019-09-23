<?php
session_start();
include_once('includes/include.php');
use Login\CheckUser;

if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['post-yourself'])) {
	$content = $_POST['post-yourself'];
	if($content == "") {
		header("Location: index.php");
		exit();
	}
	$post = new CheckUser();
	$current = $post->getMyPost($_SESSION['id']);

	$current = json_decode($current);

	 $now = time();
	 // $now = json_encode($now);
	 $object = new stdClass();
	 $object->createAt = $now;
	 $object->content = $content;
	 $object->comment = [];
	 $object->likes = [];
	 array_unshift($current, $object);

	 $current = json_encode($current, JSON_UNESCAPED_SLASHES);
	 $current = $post->Stringify($current);

	 $status = $post->addPost($current, $_SESSION['id']);

	 header("Location: profile.php?status={$status}");
}