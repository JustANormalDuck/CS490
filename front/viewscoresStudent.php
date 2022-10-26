<?php 
  require_once 'header.php';
  $username = $_SESSION["username"];
  $role = $_SESSION["role"];
  $URL= 'https://afsaccess4.njit.edu/~nk82/middle_pullGrades.php';
  $post_params="username=$username&role=$role";
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
?>

<head>
  <title>Take Exam</title>
</head>