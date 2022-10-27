<?php
	require_once 'teacherheader.php';

	if (isset($_POST['submit']))
	{
		$questionLst = $_POST['questionlst'];
		$scoresLst = $_POST['scores'];
		$ordering = "";

		$s = explode(",", $questionLst);
		for ($i = 0; $i < sizeof($s); $i++)
		{
			$ordering .= strval($i+1) . ",";
		}

		$ordering = rtrim($ordering, ",");
		$testName = $_POST['test_name'];
		$questionNumList = $ordering;
		$questionPointList = $scoresLst;
		$questionIdList = $questionLst;

		$URL= 'https://afsaccess4.njit.edu/~nk82/middle_addExam.php';
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
		$decodedData = json_decode($result, true);

		echo $decodedData['error'];

	}
	$URL= 'https://afsaccess4.njit.edu/~nk82/middle_pullQuestions.php';
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

	$decodedData = json_decode($result, true);
	for ($i = 0; $i < sizeof($decodedData['id']); $i++){
		echo "</br>";
		echo "Question ID: ";
		echo $decodedData['id'][$i];
		echo "</br>";

		echo "Question: ";
		echo $decodedData['question'][$i];
		echo "</br>";

		echo "Question Topic: ";
		echo $decodedData['topic'][$i];
		echo "</br>";

		echo "Question Difficulty: ";
		echo $decodedData['difficulty'][$i];
		echo "</br>";
	}

	echo "<form action=\"\" method=\"post\">";
		echo "</br></br><label> Enter Test Name </label> </br>";
		echo "<input name='test_name' id='test_name'> </input></br></br>";
		echo "<label> Input questions id followed by ',' as delimiter </label></br>";
		echo "<textarea id=\"questionlst\" name=\"questionlst\" rows=\"5\" cols=\"33\" style=\"white-space: pre-wrap\"; placeholder=\"Question\" required></textarea></br></br>";
		echo "<label> Input scores for questions followed by ',' as delimiter </label></br>";
		echo "<textarea id=\"scores\" name=\"scores\" rows=\"5\" cols=\"33\" style=\"white-space: pre-wrap\"; placeholder=\"Question\" required></textarea></br></br>";
		echo "<input class='submit' name=\"submit\" type=\"submit\" align='center'/>";
	echo "</form>"

?>

<head>
  <title>Add Exams</title>
</head>