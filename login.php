<?php
session_start();

if(isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>LOGIN</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/login.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <header class="header">
    	<h1>POST APPLICATION</h1>
    </header>
    <div class="page">
    	<div class="login-container">
    		<h2>LOGIN</h2>
    		<form class="login-form" action="checkUser.php" method="post">
    			<p>Username</p>
    			<input type="text" name="username" placeholder="Username">
    			<p>Password</p>
    			<input type="password" name="password" placeholder="Password">
    			<button class="submit" id="submit" name="submit" type="submit" value="submit">Login</button>
    		</form>
            <p class="login-fail" id="login-fail" style="display: none;">Your username or your password is not correct!</p>
    		<p class="notice">Don't have account. Please register <a href="register.php">here</a></p>
    	</div>
    </div>
</body>
</html>