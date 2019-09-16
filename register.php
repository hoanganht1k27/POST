<!DOCTYPE html>
<html>
<head>
	<title>REGISTER</title>
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
    	<div class="login-container" style="padding-bottom: 10px;">
    		<h2>REGISTER</h2>
    		<form class="login-form" action="newUser.php" method="POST">
    			<p>Username</p>
    			<input type="text" name="username" placeholder="Username">
    			<p>Userid</p>
    			<input type="text" name="userid" placeholder="Userid">
    			<p>Password</p>
    			<input type="password" name="password" placeholder="Password">
    			<p>Confirm password</p>
    			<input type="password" name="confirm-password" placeholder="Confirm password">
    			<button class="submit" id="submit" name="submit" type="submit" value="submit">Register</button>
    		</form>
    	</div>
    </div>
</body>
</html>