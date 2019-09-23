<?php
include_once('includes/include.php');
use Login\CheckUser;

session_start();

if($_SERVER['REQUEST_METHOD'] == "POST") {
	if(isset($_POST['comment']) && isset($_POST['from'])) {
		$comment = $_POST['comment'];
		$ava = $_POST['ava'];
		$from = $_POST['from'];
		$username = $_POST['username'];
		$to = $_POST['to'];
		$to = explode('-', $to);
		$toId = $to[0];
		$toPost = $to[1];
		$cm = new CheckUser();
		$cm->addComment($comment, $from, $toId, $toPost, $ava, $username);
	}
}