<?php
$username = $_POST["username"];
$examID = $_POST["exam_id"];
$updatedPoints = $_POST["updated_points"];
$grade = $_POST["grade"];
$auto_comments=$_POST["auto_comments"];
$comments = $_POST["comments"];
$URL= 'https://afsaccess4.njit.edu/~jmf64/back_updateGrades.php';
$post_params="username=$username&exam_id=$examID&updated_points=$updatedPoints&grade=$grade&auto_comments=$auto_comments&comments=$comments";
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
