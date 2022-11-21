<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Login Page</title>
</head>
<form method="POST" action="">
	<label for="username">Username: </label>
	<input type="text" id="username" name="username" required/>
    </br> </br>

    <label for="pass">Password:</label>
    <input type="password" id="password" name="password" required/>
    </br> </br>
    
    <input type="submit" name="login" value="Login"/>
</form>

<?php
if isset($_POST['login']){

	$username = $_POST['username'];
	$password = $_POST['password'];
	$URL = "https://afsaccess4/~nk82/middle_login.php";

	$post_params="username=$username&password=$password";
	echo "Made it to the curl stage";
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
	echo "Made it to the end of the curl";
	echo json_decode($result);

}
//Sending login info to middle end

?>

<?php
	/*
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
	    if ($decodedData->role == "T"){
	    	die(header('Location: teacher.php'));
	    }
	    else if ($decodedData->role == "S"){
	        die(header('Location: student.php'));
	    }
	    else{
	    	echo "Invalid username or password";
	    }
	}

	curl_close($curl);
	*/
?>
