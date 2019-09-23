<?php
include_once("includes/include.php");
use Login\CheckUser;

session_start();

if($_SERVER['REQUEST_METHOD'] == "POST") {
	$from = $_POST['from'];
	$ava = $_POST['ava'];
	$username = $_POST['username'];
	$to = $_POST['to'];
	$to = explode('-', $to);
	$toId = $to[0];
	$toPost = $to[1];
	$keep = new CheckUser();
	$keep->addLike($from, $ava, $username, $toId, $toPost);
}