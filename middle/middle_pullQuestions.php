<?php
$URL= 'https://afsaccess4.njit.edu/~jmf64/back_pullQuestions.php';
$ch = curl_init();
$options = array(CURLOPT_URL => $URL,
			         CURLOPT_HTTPHEADER =>
array('Content-type:application/x-www-form-urlencoded'),
				 CURLOPT_RETURNTRANSFER => TRUE,
				 CURLOPT_POST => TRUE);
				 #CURLOPT_POSTFIELDS => $post_params) shouldn't need any post fields here;
curl_setopt_array($ch, $options);
$result = curl_exec($ch);
curl_close($ch);
echo $result;
?>
