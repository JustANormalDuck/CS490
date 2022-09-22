<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Login Page</title>
</head>
<body>
	<?php
		$username = $_POST['username'];
		$password = $_POST['password'];

		$hash_password = password_hash($password, PASSWORD_BCRYPT);
		$URL = "https://afsaccess4/~nk82/middle_login.php";

		$post_params="username=$username&password=$password";
		$ch = curl_init();
		$ch = curl_init();

		$options = array(CURLOPT_URL => $URL,
			         	CURLOPT_HTTPHEADER =>
						array('Content-type:application/x-www-form-urlencoded'),
				 		CURLOPT_RETURNTRANSFER => TRUE,
				 		CURLOPT_POST => TRUE,
				 		CURLOPT_POSTFIELDS => $post_params);

		curl_setopt_array($ch, $options);
		$result = curl_exec($ch);
		curl_close($ch);
		echo $result;
	?>

	<form method="POST">
		<label for="username">Username: </label>
		<input type="text" id="username" name="username" required/>
        </br> </br>

        <label for="pass">Password:</label>
        <input type="password" id="password" name="password" required/>
        </br> </br>
        
        <input type="submit" name="login" value="Login"/>
    </form>
</body>
</html>
