<?php

namespace Login;

class CheckUser {
	private $serverName, $adminName, $adminPassword, $dbName, $conn;

	public function __construct() {
		$this->serverName = "localhost";
		$this->adminName = "pma";
		$this->adminPassword = "hoanganht1k271112002";
		$this->dbName = "POST";
		$this->conn = mysqli_connect($this->serverName, $this->adminName, $this->adminPassword, $this->dbName);
	}

	public function checkUser($username, $password) {
		$sql = "SELECT * FROM `all-user` WHERE `username` = '{$username}' AND `password` = '{$password}'";
		if($this->conn->connect_errno) {
			return "connect failed";
		}

		$res = $this->conn->query($sql);
		if($this->conn->affected_rows >= 1) {
			while($row = $res->fetch_object()) {
				$_SESSION['username'] = $row->username;
				$_SESSION['password'] = $row->password;
				$_SESSION['id'] = $row->id;
			}
			return "success";
		}
		return "not correct";
	}

	public function newUser($username, $password) {
		$sql = "SELECT * FROM `all-user` WHERE `username` = '{$username}'";

		$res = $this->conn->query($sql);

		if($this->conn->affected_rows >= 1) {
			return "trung";
		}
		
		$sql = "INSERT INTO `all-user` (`username`, `password`) VALUES ('{$username}', '{$password}')";

		$res = $this->conn->query($sql);

		if($this->conn->affected_rows >= 1) {
			$sql = "SELECT * FROM `all-user` WHERE `username` = '{$username}'";
			$res = $this->conn->query($sql);
			$row = $res->fetch_object();
			return $row->id;
		}

		return "success";
	}

	public function getIdOfName($username) {
		$sql = "SELECT `id` FROM `all-user` WHERE `username` = '{$username}'";

		$res = $this->conn->query($sql);

		if($this->conn->affected_rows >= 1) {
			$row = $res->fetch_object();
			$row = $row->id;
			if($row != $_SESSION['id']) return "trung";
			return "success";
		}

		return "success";
	}

	public function updateUsername($userId, $username) {
		if($username == "") return "empty";
		$sql = "UPDATE `all-user` SET `username` = '{$username}' WHERE `id` = {$userId}";

		$res = $this->conn->query($sql);

		if($this->conn->affected_rows >= 1) {
			return "success";
		}
		return "failed";
	}

	public function getNameOfId($userId) {
		$sql = "SELECT * FROM `all-user` WHERE `id` = {$userId}";

		$res = $this->conn->query($sql);

		if($this->conn->affected_rows >= 1) {
			$row = $res->fetch_object();
			return $row->username;
		}
		return "noname";
	}

	public function getFollowing($userId) {
		$sql = "SELECT * FROM `all-user` WHERE `id` = {$userId}";

		$res = $this->conn->query($sql);

		if($this->conn->affected_rows >= 1) {
			$row = $res->fetch_object();
			return $row->following;
		}
	}

	public function addFollowing($following, $userId) {
		$sql = "UPDATE `all-user` SET `following` = '{$following}' WHERE `id` = {$userId}";

		$res = $this->conn->query($sql);
	}

	public function getMyPost($userId) {
		$sql = "SELECT * FROM `all-user` WHERE `id` = {$userId}";

		$res = $this->conn->query($sql);

		if($this->conn->affected_rows >= 1) {
			$row = $res->fetch_object();
			return $row->post;
		}
	}

	public function addPost($content, $userId) {
		$userId = intval($userId);
		// if($content == null) return "failed";

		$sql = "UPDATE `all-user` SET `post` = '{$content}' WHERE `id` = {$userId}";

		$res = $this->conn->query($sql);

		if($this->conn->affected_rows >= 1) {
			return "success";
		}

		return "failed";
	}

	public function Stringify($s) {
		// $s = stripslashes($s);
		$s = addslashes($s);
		return $s;
	}

	public function getAllPost($userId) {
		$sql = "SELECT * FROM `all-user` WHERE `id` = {$userId}";

		$res = $this->conn->query($sql);

		if($this->conn->affected_rows >= 1) {
			$row = $res->fetch_object();
			$post = $row->post;
			$post = json_decode($post);
			return $post;
		}
		return array();
	}

	public function showAllPost($userId) {
		$post = $this->getAllPost($userId);
		$res = "";
		$sql = "SELECT * FROM `all-user` WHERE `id` = {$userId}";

		$res = $this->conn->query($sql);

		if($this->conn->affected_rows >= 1) {
			$row = $res->fetch_object();
			$username = $row->username;
			$avaUrl = $row->ava;
		}

		foreach ($post as $key => $value) {
			$comment = $value->comment;
			$likes = $value->likes;
			$likeCount = count($likes);
			$liked = false;
			$class = "";
			foreach ($likes as $likeFrom) {
				if($likeFrom->from == $_SESSION['id']) {
					$liked = true;
					break;
				}
			}
			if($liked) {
				$class = "liked";
			}
			echo '
				<div class="post all-post-hihi" id="'.$userId.'-'.$value->createAt.'">
					<div class="post-info">
						<div class="ava-post">
							<img src="avatar/'.$avaUrl.'">
						</div>
						<div class="author-post">
			' . '<a href="profile.php?id='.$userId.'">'.$username.'</a>'.
			'</div>
					</div>
					<div class="post-content"><p>'.$value->content.'</p></div>
					<div class="reaction-counter">
						<p><b class="dem-like">'.$likeCount.'</b> likes</p>
					</div>
					<div class="post-reaction">
						<div class="reaction-option">
							<ul>
								<li>
									<button>
										<i class="fa fa-thumbs-up '.$class.'"></i>
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
							'.$this->showAllComment($comment).'
						</div>
						<div class="your-comment-container">
							<form class="your-comment">
								<input type="text" name="your-comment" placeholder="What do you think?" class="ip-your-comment">
								<input type="submit" class="submit-yourcomment" name="submit-your-comment" value="Post">
							</form>
						</div>
					</div>
				</div>';
		}
	}

	public function addLike($from, $ava, $username, $toId, $toPost) {
		$sql = "SELECT `post` FROM `all-user` WHERE `id` = {$toId}";

		$res = $this->conn->query($sql);

		if($this->conn->affected_rows >= 1) {
			$row = $res->fetch_object();
			$row = $row->post;
			$post = json_decode($row);
			$likes = [];
			$id = 0;
			foreach ($post as $i => $ob) {
				if($ob->createAt == $toPost) {
					$likes = $ob->likes;
					$id = $i;
					break;
				}
			}
			$ob = (object)[];
			$ob->from = $from;
			$ob->ava = $ava;
			$ob->username = $username;
			array_unshift($likes, $ob);
			$post[$id]->likes = $likes;
			$row = json_encode($post);
			$this->updateLike($toId, $row);
		}
	}

	public function updateLike($userId, $post) {
		$post = $this->Stringify($post);
		$sql = "UPDATE `all-user` SET `post` = '{$post}' WHERE `id` = {$userId}";

		$res = $this->conn->query($sql);

		if($this->conn->affected_rows >= 1) return true;

		return false;
	}

	public function checkFollow($user1, $user2) {
		$sql = "SELECT * FROM `all-user` WHERE `id` = {$user1}";

		$res = $this->conn->query($sql);

		if($this->conn->affected_rows >= 1) {
			$row = $res->fetch_object();
			$row = json_decode($row->following);
			foreach ($row as $key => $value) {
				if($value == intval($user2)) return true;
			}
		}
		return false;
	}

	public function showAllComment($all) {
		$res = '';
		foreach ($all as $ob) {
			$comment = $ob->comment;
			$from = $ob->from;
			$ava = $ob->ava;
			$username = $ob->username;
			$res .= '<div class="comment"><div class="comment-info">
						<div class="ava-author-comment">
							<img src="avatar/'.$ava.'">
						</div>
						<a href="profile.php?id='.$from.'">'.$username.'</a>
					</div>
					<div class="comment-content">
						<p>'.$comment.'</p>
					</div></div>';
		}
		return $res;
	}

	public function showAllFollowingPost($userId) {
		$sql = "SELECT `following` FROM `all-user` WHERE `id` = {$userId}";

		$res = $this->conn->query($sql);

		if($this->conn->affected_rows >= 1) {
			$row = $res->fetch_object();
			$row = $row->following;
			$row = json_decode($row);
			$day = array();
			foreach ($row as $user) {
				$sql = "SELECT `post`, `username`, `ava` FROM `all-user` WHERE `id` = {$user}";

				$res = $this->conn->query($sql);

				if($this->conn->affected_rows >= 1) {
					$post = $res->fetch_object();
					$name = $post->username;
					$avaUrl = $post->ava;
					$post = $post->post;
					$post = json_decode($post);
					foreach ($post as $p) {
						$date = $p->createAt;
						$content = $p->content;
						$example = (object)[];
						$example->content = $content;
						$example->from = $name;
						$example->id = $user;
						$example->ava = $avaUrl;
						$example->comment = $p->comment;
						$example->likes = $p->likes;
						$day[$date] = $example;
					}
					krsort($day);
				}
			}
			foreach ($day as $i => $ob) {
				$user = $ob->id;
				$name = $ob->from;
				$content = $ob->content;
				$comment = $ob->comment;
				$avaUrl = $ob->ava;
				$likes = $ob->likes;
				$likeCount = count($likes);
				$liked = false;
				$class = "";
				foreach ($likes as $likeFrom) {
					if($likeFrom->from == $_SESSION['id']) {
						$liked = true;
						break;
					}
				}
				if($liked) {
					$class = "liked";
				}
				if($user == $_SESSION['id']) continue;
				echo '<div class="post all-post-hihi" id="'.$user.'-'.$i.'">
						<div class="post-info">
							<div class="ava-post">
								<img src="avatar/'.$avaUrl.'">
							</div>
							<div class="author-post">
								<a href="profile.php?id='.$user.'">'.$name.'</a>
							</div>
						</div>
						<div class="post-content">
							<p>'.$content.'</p>
						</div>
						<div class="reaction-counter">
							<p><b class="dem-like">'.$likeCount.'</b> likes</p>
						</div>
						<div class="post-reaction">
							<div class="reaction-option">
								<ul>
									<li>
										<button>
											<i class="fa fa-thumbs-up '.$class.'"></i>
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
								'.$this->showAllComment($comment).'
							</div>
							<div class="your-comment-container">
								<form class="your-comment">
									<input type="text" name="your-comment" placeholder="What do you think?" class="ip-your-comment">
									<input type="submit" class="submit-yourcomment" name="submit-your-comment" value="Post">
								</form>
							</div>
						</div>
					</div>';
			}
		}
	}

	public function getAvatar($userId) {
		$sql = "SELECT `ava` FROM `all-user` WHERE `id` = {$userId}";

		$res = $this->conn->query($sql);

		if($this->conn->affected_rows >= 1) {
			$row = $res->fetch_object();
			$row = $row->ava;
			return $row;
		}
	}

	public function getBackground($userId) {
		$sql = "SELECT `background` FROM `all-user` WHERE `id` = {$userId}";

		$res = $this->conn->query($sql);

		if($this->conn->affected_rows >= 1) {
			$row = $res->fetch_object();
			$row = $row->background;
			return $row;
		}
	}

	public function getAvatarUrl($userId) {
		$sql = "SELECT `ava` FROM `all-user` WHERE `id` = {$userId}";

		$res = $this->conn->query($sql);

		if($this->conn->affected_rows >= 1) {
			$row = $res->fetch_object();
			return $row->ava;
		}
	}

	public function uploadAvatar($tmp, $userId) {
		$sql = "UPDATE `all-user` SET `ava` = '{$userId}/ava.jpg' WHERE `id` = {$userId}";

		$res = $this->conn->query($sql);

		$targetFile = "avatar/{$userId}/ava.jpg";
		move_uploaded_file($tmp, $targetFile);
	}

	public function uploadBackground($tmp, $userId) {
		$sql = "UPDATE `all-user` SET `background` = '{$userId}/bg.jpg' WHERE `id` = {$userId}";

		$res = $this->conn->query($sql);

		$targetFile = "avatar/{$userId}/bg.jpg";
		move_uploaded_file($tmp, $targetFile);
	}

	public function addComment($comment, $from, $toId, $toPost, $ava, $username) {
		$sql = "SELECT `post` FROM `all-user` WHERE `id` = {$toId}";

		$res = $this->conn->query($sql);

		if($this->conn->affected_rows >= 1) {
			$row = $res->fetch_object();
			$post = $row->post;
			$post = json_decode($post);
			$allComment = [];
			foreach ($post as $key => $value) {
				if($value->createAt == $toPost) {
					$allComment = $value->comment;
					break;
				}
			}
			$ob = (object)[];
			$ob->from = $from;
			$ob->comment = $comment;
			$ob->ava = $ava;
			$ob->username = $username;
			array_push($allComment, $ob);
			foreach ($post as $key => $value) {
				if($value->createAt == $toPost) {
					$post[$key]->comment = $allComment;
					break;
				}
			}
			$post = json_encode($post);
			$keep = new CheckUser();
			$post = $keep->Stringify($post);

			$sql = "UPDATE `all-user` SET `post` = '{$post}' WHERE `id` = {$toId}";

			$res = $this->conn->query($sql);
		}
	}

	public function checkPass($userId, $pass) {
		$sql = "SELECT * FROM `all-user` WHERE `id` = {$userId} AND `password` = '{$pass}'";

		$res = $this->conn->query($sql);

		if($this->conn->affected_rows >= 1) {
			return true;
		}

		return false;
	}

	public function changePassword($userId, $pass) {
		if($pass == '') return "empty";

		$sql = "UPDATE `all-user` SET `password` = '{$pass}' WHERE `id` = {$userId}";

		$res = $this->conn->query($sql);

		if($this->conn->affected_rows >= 1) {
			return "success";
		}

		return "failed";
	}

	public function fetchAllUser() {
		$sql = "SELECT `username`, `id` FROM `all-user`";

		$res = $this->conn->query($sql);

		$ans = [];

		while($row = $res->fetch_object()) {
			array_push($ans, $row);
		}
		return $ans;
	}

	public function getFollowers($userId) {
		$sql = "SELECT `followers` FROM `all-user` WHERE `id` = {$userId}";

		$res = $this->conn->query($sql);

		if($this->conn->affected_rows >= 1) {
			$row = $res->fetch_object();
			return $row->followers;
		}

		return "[]";
	}

	public function addFollowers($followers, $userId) {
		$sql = "UPDATE `all-user` SET `followers` = '{$followers}' WHERE `id` = {$userId}";

		$res = $this->conn->query($sql);

		if($this->conn->affected_rows >= 1) {
			return "success";
		}

		return "failed";
	}

	public function getRoomId($userId) {
		$sql = "SELECT `room` FROM `all-user` WHERE `id` = {$userId}";

		$res = $this->conn->query($sql);

		if($this->conn->affected_rows >= 1) {
			$row = $res->fetch_object();
			return $row->room;
		}

		return null;
	}

	public function addNotification($userId) {
		$sql = "SELECT `unread` FROM `all-user` WHERE `id` = {$userId}";

		$res = $this->conn->query($sql);

		if($this->conn->affected_rows >= 1) {
			$row = $res->fetch_object();
			$unread = $row->unread;
			$unread++;
			$sql = "UPDATE `all-user` SET `unread` = {$unread} WHERE `id` = {$userId}";

			$this->conn->query($sql);

			if($this->conn->affected_rows >= 1) {
				return true;
			}
		}
		return false;
	}
}