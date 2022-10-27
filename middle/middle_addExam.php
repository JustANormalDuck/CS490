<?php
$testName = $_POST['test_name'];
$questionNumList = $_POST['question_num_list'];
$questionPointList = $_POST['question_point_list'];
$questionIdList = $_POST['question_id_list'];
$URL= 'https://afsaccess4.njit.edu/~jmf64/back_addExam.php';
$post_params="test_name=$testName&question_num_list=$questionNumList&question_point_list=$questionPointList&question_id_list=$questionIdList";
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
