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

		return "success";
	}
}