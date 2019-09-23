<?php
include_once('includes/include.php');
use Login\CheckUser;

session_start();

if(!isset($_SESSION['username'])) {
	header("Location: login.php");
	exit();
}

$userId = $_SESSION['id'];
if(isset($_GET['id'])) {
	$userId = $_GET['id'];
}

$name = new CheckUser();
$name = $name->getNameOfId($userId);

if($name == "noname") {
	header("Location: index.php");
	exit();
}

$ava = new CheckUser();
$ava = $ava->getAvatarUrl($_SESSION['id']);

?>

<!DOCTYPE html>
<html>
<head>
	<title>
		<?php
			echo $name;
		?>
	</title>
	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
  	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  	<link rel="stylesheet" type="text/css" href="css/style.css">
  	<link rel="stylesheet" type="text/css" href="css/profile.css">
  	<script type="text/javascript" src="Js/jquery-3.3.1.min.js"></script>
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
		<div class="left">
			<div class="following-container all-post-hihi">
				<h4>Following</h4>
				<div class="following">
					<div class="person-follow">
						<a href="#" title="Anh Nguyen">
						</a>
					</div>
					<div class="person-follow">
						<a href="#" title="Anh Nguyen">
						</a>
					</div>
					<div class="person-follow">
						<a href="#" title="Anh Nguyen">
						</a>
					</div>
					<div class="person-follow">
						<a href="#" title="Anh Nguyen">
						</a>
					</div>
					<div class="person-follow">
						<a href="#" title="Anh Nguyen">
						</a>
					</div>
					<div class="person-follow">
						<a href="#" title="Anh Nguyen">
						</a>
					</div>
					<div class="person-follow">
						<a href="#" title="Anh Nguyen">
						</a>
					</div>
					<div class="person-follow">
						<a href="#" title="Anh Nguyen">
						</a>
					</div>
					<div class="person-follow">
						<a href="#" title="Anh Nguyen">
						</a>
					</div>
				</div>
			</div>
		</div>
		<div class="middle-container">
			<div class="ava-container">
				<div class="background-ava" style="background-image: url('<?php 
						$bg = new CheckUser();
						$bg = $bg->getBackground($userId);
						echo 'avatar/'.$bg;
					?>');">
				</div>
				<div class="main-ava">
					<img src="<?php 
						$ava = new CheckUser();
						$ava = $ava->getAvatar($userId);
						echo 'avatar/'.$ava;
					?>">
				</div>
			</div>
			<div class="upload-option" style="<?php 
				if($userId != $_SESSION['id']) {
					echo "display: none;";
				}
			?>">
				<form method="post" enctype="multipart/form-data" action="changeImage.php">
					Upload avatar: <input type="file" name="avatar"><br><br>
					Upload background: <input type="file" name="background"><br><br>
					<input type="submit" name="submit" value="Upload" id="upload-bg">
				</form>
			</div>
			<div class="change-information" style="<?php
				if($userId != $_SESSION['id']) echo "display: none;";
			?>">
				<button id="change-info">Change your information</button>
				<div class="all-post-hihi change-info">
					<form method="post" action="changeInfo.php">
						<label for="change-username" class="label">Change username</label>
						<input type="text" name="change-username" id="change-username" placeholder="New username">
						<label for="old-password" class="label">Confirm your old password</label>
						<input type="password" name="old-password" id="old-password" placeholder="Your old password">
						<label for="new-pass" class="label">Your new password</label>
						<input type="password" name="new-pass" id="new-pass" placeholder="New password">
						<label for="confirm-new-pass" class="label">Confirm your new password</label>
						<input type="password" name="confirm-new-pass" id="confirm-new-pass" placeholder="Confirm new password">
						<input type="submit" name="submit-change" value="Change" id="submit-change">
					</form>
				</div>
			</div>
			<div class="follow-option" data-id="<?php
                    echo $userId;
             ?>">
	             <?php
	             	$checkFollow = new CheckUser();
	             	$checkFollow = $checkFollow->checkFollow($_SESSION['id'], $userId);
	             	$style = "display: block;";
	             	if($checkFollow === true) $style = "display: none;";
	             	$style2 = "display: block;";
	             	if($checkFollow === false) $style2 = "display: none;";
	             ?>
				<button id="unfollow" style="<?php echo $style; ?>">Follow</button>
				<button id="follow" style="<?php echo $style2; ?>">Following</button>
			</div>
			<div class="post-yourself-container all-post-hihi" style="<?php 
				if($userId != $_SESSION['id']) echo "display: none;";
			?>">
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
					$post = new CheckUser();
					$post->showAllPost($userId);
				?>
			</div>
		</div>
	</div>
	<script type="text/javascript" src="Js/chatkit.js"></script>
	<script type="text/javascript" src="Js/notice.js"></script>
	<script type="text/javascript" src="Js/event.js"></script>
</body>
</html>