<?php
$username= $_POST['username'];
$examID = $_POST['exam_id'];
$testName= $_POST['test_name'];
$responses=$_POST['student_responses'];
$responses=str_replace('%','%25',$responses); 
$responses=str_replace('+','%2b',$responses); 
$possible_points=$_POST['possible_points'];
$URL= 'https://afsaccess4.njit.edu/~jmf64/back_addDefaultGrade.php';
$post_params="username=$username&exam_id=$examID&test_name=$testName&student_responses=$responses&possible_points=$possible_points";
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
