<?php
include_once('includes/include.php');
use Login\CheckUser;

session_start();

if(!isset($_SESSION['username'])) {
	header("Location: login.php");
	exit();
}

$ava = new CheckUser();
$ava = $ava->getAvatarUrl($_SESSION['id']);

?>

<!DOCTYPE html>
<html>
<head>
	<title>POSTER</title>
	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
  	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  	<link rel="stylesheet" type="text/css" href="css/style.css">
  	<script type="text/javascript" src="Js/jquery-3.3.1.min.js"></script>
	<script type="text/javascript" src="Js/chatkit.js"></script>
	<script type="text/javascript" src="Js/notice.js"></script>
</head>
<body>
	<div class="nav-container">
		<div class="navigation">
			<ul class="nav-list">
				<li>
					<a href="index.php" title="Home">
						<i class="fa fa-home"></i>
					</a>
				</li>
				<li>
					<a href="profile.php?id=<?php echo $_SESSION['id']; ?>" title="Profile">
						<i class="fa fa-user"></i>
					</a>
				</li>
				<li style="position: relative;" id="notification">
					<span>
						<i class="fa fa-bell" title="Notification"></i>
					</span>
					<span class="badge">
						3
					</span>
				</li>
			</ul>
		</div>
		<div class="logout-container">
			<a href="logout.php" title="Log out">
				<i class="fa fa-sign-out"></i>
			</a>
		</div>
	</div>
	<div class="bg-for-notice"></div>
	<div class="dropdown-notice">
		<ul>
			<!-- <li>
				<a href="#">
					<div class="notice-ava">
						<img src="avatar/default-ava.jpg">
					</div>
					<p class="notice-content">Nguyen Hoang Anh comment ctetur? Error wisi! Ratione sunt tempora! Consequat risus, possimus eleifend. Nec repellendus, cursus senectus! Ligula. Imperdiet dignissim impedit nam! Fermentum convallis magnis? Luced your post</p>
				</a>
			</li>
			<li>
				<a href="#">
					<div class="notice-ava">
						<img src="avatar/default-ava.jpg">
					</div>
					<p class="notice-content">Nguyen Hoang Anh comment ctetur? Error wisi! Ratione</p>
				</a>
			</li>
			<li>
				<a href="#">
					<div class="notice-ava">
						<img src="avatar/default-ava.jpg">
					</div>
					<p class="notice-content">Nguyen Hoang Anh co Fermentum convallis magnis? Luced your post</p>
				</a>
			</li> -->
		</ul>
	</div>
	<div class="main" userid="<?php echo $_SESSION['id']; ?>" userava="<?php echo $ava; ?>" username="<?php echo $_SESSION['username']; ?>" usingid="<?php echo $_SESSION['id']; ?>">
		<script type="text/javascript">
			var c = new chatkit();
			c.init();
		</script>
		<div class="left-container">
			<div class="feed-container">
				<div class="feed-icon">
					<img src="images/feed.png">
				</div>
				<div class="feed-header">
					<h4>Your feed</h4>
				</div>
			</div>
			<div class="new-friend-container feed-container">
				<div class="new-friend-icon feed-icon">
					<img src="images/newfr2.png">
				</div>
				<div class="feed-header">
					<h4>Find new friends</h4>
				</div>
				<div class="find-friend-container">
					<input type="search" name="new-friend" id="new-friend" placeholder="Your friend's name">
				</div>
				<div class="new-friend-list">
				</div>
			</div>
		</div>
		<div class="middle-container">
			<div class="post-yourself-container all-post-hihi">
				<header>Post something here</header>
				<form class="post-yourself" method="post" action="postYourself.php">
					<div class="ava-post-yourself">
						<img src="images/img1.jpg">
					</div>
					<input type="text" name="post-yourself" placeholder="What are you thinking?" id="post-yourself">
					<input type="submit" name="submit-post-yourself" id="submit-post-yourself" value="Post">
				</form>
			</div>
			<div class="all-post">
				<?php
					$following = new CheckUser();
					$following->showAllFollowingPost($_SESSION['id']);
				?>
			</div>
		</div>
		<div class="right">
			
		</div>
	</div>
	<script type="text/javascript" src="Js/event2.js"></script>
</body>
</html>