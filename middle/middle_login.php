<?php
$obj = new stdClass();
$name= $_POST['username'];
$password = $_POST['password'];
$URL= 'https://afsaccess4.njit.edu/~jmf64/back_login.php';
$post_params="username=$name&password=$password";
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
