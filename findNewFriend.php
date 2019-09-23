<?php
include_once("includes/include.php");
use Login\CheckUser;

session_start();

if($_SERVER['REQUEST_METHOD'] == "POST") {
	$username = $_POST['username'];
	if($username == '') return '';
	$all = new CheckUser();
	$all = $all->fetchAllUser();

	foreach ($all as $value) {
		if(strpos($value->username, $username) !== false) {
			echo '
				<li>
					<a href="profile.php?id='.$value->id.'" class="link-to-newfr">'.$value->username.'</a>
				</li>
			';
		}
	}
}