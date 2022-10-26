<?php
$username = $_POST["username"];
$examID = $_POST["exam_id"];
$updatedPoints = $_POST["updated_points"];
$grade = $_POST["grade"];
$comments = $_POST["comments"];
$URL= 'https://afsaccess4.njit.edu/~jmf64/back_updateGrades.php';
$post_params="username=$username&exam_id=$examID&updated_Points=$updatedPoints&grade=$grade&comments=$comments";
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
