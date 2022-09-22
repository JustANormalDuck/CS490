<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Login Page</title>
</head>
<body>
	<?php
		//Sending login info to middle end
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


    <?php
    	//Retrieving data from middle end
    	$curl = curl_init();
    	curl_setopt($curl, CURLOPT_URL, "https://afsaccess4/~nk82/middle_login.php");
    	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    	$response = curl_exec($curl);
    	if($e = curl_error($curl)) {
    	    echo $e;
    	} 
    	else {
    	    $decodedData = json_decode($response, true);
    	    if ($response->role == "T"){
    	    	header('Location: teacher.php');
     			exit();
    	    }
    	    else if ($response->role == "S"){
    	        header('Location: student.php');
     			exit();
    	    }
    	    else{
    	    	echo "Invalid username or password";
    	    }
    	}

    	curl_close($curl);
    ?>
</body>
</html>
