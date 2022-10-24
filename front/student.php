<?php	
	require_once 'header.php';

  echo $_SESSION['username'];
  echo $_SESSION['role'];
  
	/*
	$username = $_POST['username'];
    $URL= 'https://afsaccess4.njit.edu/~nk82/middle_login.php';
    $post_params="username=$username&password=$password";
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
    $decodedData = json_decode($result, true);
    echo $result
    */
    
?>

<head>
  <title>Student Landing Page</title>
</head>