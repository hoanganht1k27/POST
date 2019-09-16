<?php
session_start();

if(!isset($_SESSION['username'])) {
	header("Location: login.php");
	exit();
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>
		<?php
			echo $_SESSION['username'];
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
					<a href="profile.php" title="Profile">
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
			<li>
				<a href="#">Nguyen Hoang Anh commented your post</a>
			</li>
			<li>
				<a href="#">Nguyen Hoang Anh commented your post</a>
			</li>
			<li>
				<a href="#">Nguyen Hoang Anh commented your post</a>
			</li>
			<li>
				<a href="#">Nguyen Hoang Anh commented your post heh kskd k lsk ksl kdl sk kslk dk lskd llkskdk  k ksk ks</a>
			</li>
		</ul>
	</div>
	<div class="main">
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
				<div class="background-ava">
					<img src="images/img4.jpg">
				</div>
				<div class="main-ava">
					<img src="images/img5.jpg">
				</div>
			</div>
			<div class="upload-option">
				<form>
					Upload avatar: <input type="file" name="avatar"><br><br>
					Upload background: <input type="file" name="background"><br><br>
					<input type="submit" name="submit" value="Upload" id="upload-bg">
				</form>
			</div>
			<div class="follow-option">
				<button id="unfollow">Follow</button>
				<button id="follow">Following</button>
			</div>
			<div class="post-yourself-container all-post-hihi">
				<header>Post something here</header>
				<form class="post-yourself">
					<div class="ava-post-yourself">
						<img src="images/img1.jpg">
					</div>
					<input type="text" name="post-yourself" placeholder="What are you thinking?" id="post-yourself">
					<input type="submit" name="submit-post-yourself" id="submit-post-yourself" value="Post">
				</form>
			</div>
			<div class="all-post">
				<div class="post all-post-hihi">
					<div class="post-info">
						<div class="ava-post">
							<img src="images/img2.jpg">
						</div>
						<div class="author-post">
							<a href="#">Anh Nguyen</a>
						</div>
					</div>
					<div class="post-content">
						<p>blaaj jkds sks sks sls  s s s sa s ad fas fs f asdf asdf asf asf sf sd fd df sf sdf sdfsd fs dfs  sfd fsdf sdfsd s dfs dfs </p>
					</div>
					<div class="reaction-counter">
						<p>100 likes</p>
					</div>
					<div class="post-reaction">
						<div class="reaction-option">
							<ul>
								<li>
									<button>
										<i class="fa fa-thumbs-up"></i>
									</button>
								</li>
								<li>
									<button>
										<i class="fa fa-comment"></i>
									</button>
								</li>
							</ul>
						</div>
						<div class="comment-container">
							<div class="comment">
								<div class="comment-info">
									<div class="ava-author-comment">
										<img src="images/img3.jpg">
									</div>
									<a href="#">Nguyen Hoang Anh</a>
								</div>
								<div class="comment-content">
									<p>This is so interesting!</p>
								</div>
							</div>
							<div class="your-comment-container">
								<form class="your-comment">
									<input type="text" name="your-comment" placeholder="What do you think?" id="ip-your-comment">
									<input type="submit" id="submit-yourcommet" name="submit-your-comment" value="Post">
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		$(document).ready(function() {
			$('.bg-for-notice').click(function(event) {
				$(this).hide();
				$('.dropdown-notice').hide();
			});
			$('#notification').click(function(event) {
				$('.dropdown-notice').show();
				$('.bg-for-notice').show();
			});
		});
	</script>
</body>
</html>