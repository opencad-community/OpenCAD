<!DOCTYPE html>
<link rel="icon" type="image/x-icon" href="./../images/favicon.ico">
<html>
<head>
	<title>OpenCAD</title>
	<style>
		body {
			background-color: #14051d;
			color: #fff;
			font-family: Arial, sans-serif;
		}
		
		form {
			background-color: #333;
			border-radius: 10px;
			padding: 20px;
			margin: 50px auto;
			width: 300px;
		}
		
		input[type="text"], input[type="password"] {
			background-color: #ddd;
			border: none;
			border-radius: 5px;
			box-sizing: border-box;
			font-size: 16px;
			margin-bottom: 10px;
			padding: 10px;
			width: 100%;
		}
		
		input[type="submit"] {
			background-color: #4CAF50;
			border: none;
			border-radius: 5px;
			color: #fff;
			cursor: pointer;
			font-size: 16px;
			padding: 10px;
			width: 100%;
		}
	</style>
</head>
<body>
	<form action="register.php" method="POST">
		
        <div class="image">

      <img src="./../images/logo.png" alt="OpenCAD"
	  width="320" 
     height="80" />

</div>

		<label for="username">Username:</label>
		<input type="text" id="username" name="username" placeholder="Enter your username">
		<label for="password">Password:</label>
		<input type="password" id="password" name="password" placeholder="Enter your password">
		<input type="submit" value="Register">
	</form>
</body>
</html>