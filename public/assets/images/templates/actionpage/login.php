<!DOCTYPE html>


<link rel="icon" type="image/x-icon" href="./../images/favicon.ico">
<html lang="en">
<head>
	<title>OpenCAD</title>
	<style>
		html {
  				height: 100%;
		}
		body {
			background: linear-gradient(to bottom, #14051d, #333);
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
		.center {
            text-align: center;
            font-size:16px;
			font-weight: bold;
			color: #c7c7c7;
        }
	</style>
</head>
<body>
	<form action="login.php" method="POST">
		
        <div class="image">

      <img src="./../images/logo.png" alt="OpenCAD"
	  width="320" 
     height="80" />

</div>
<div class="center">
    <p> "< COMMUNTY_NAME >" </p>
</div>

		<label for="username">Username:</label>
		<input type="text" id="username" name="username" placeholder="Enter your username">
		<label for="password">Password:</label>
		<input type="password" id="password" name="password" placeholder="Enter your password">
		<input type="submit" value="Login">
	</form>
</body>
</html>
