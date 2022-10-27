<?php
	require_once 'teacherheader.php';

	$username = $_SESSION["username"];
	$role = $_SESSION["role"];

	$SUsername = $_SESSION['Susername'];
	$examID = $_SESSION['examID'];

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
	#echo $result;

	if (isset($_POST['submit']))
	{
		$currentComments = $_SESSION['currentComment'];
		$updatedComments = $_POST['comment'];
		$queryComment = $currentComments . "\n" . $updatedComments;

		$updatedGrades = $_POST['update'];
		

		$score = 0;
		$grades = explode(",", $updatedGrades);
		foreach ($grades as $grade) {
			$score += intval($grade);
		}

		$URL= 'https://afsaccess4.njit.edu/~jmf64/back_updateGrades.php';
		$post_params="username=$SUsername&exam_id=$examID&updated_points=$updatedGrades&grade=$score&comments=$queryComment";
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

		unset($_SESSION['$SUsername']);
		unset($_SESSION['$examID']);
		unset($_SESSION['$currentComment']);
	}

	echo "</br>";
	echo "User: " . $SUsername;
	echo "</br>";
	echo "Exam ID: " . $examID;

	echo "</br>---------------------</br></br>";

	echo "<form action=\"\" method=\"post\">";
	for ($i = 0; $i < sizeof($decodedData['examID']); $i++)
	{
		if (($decodedData['examID'][$i] == $examID) && ($decodedData['username'][$i] == $SUsername))
		{
			echo "Earned Points: </br>";
			$response = explode("?", $decodedData['earnedPoints'][$i]);
			foreach ($response as $ans){
			  echo $ans;
			  echo "</br>";
			}
			echo "</br>";

			echo "Updated Points: </br>";
			$response = explode("?", $decodedData['updatedPoints'][$i]);
			foreach ($response as $ans){
			  echo $ans;
			  echo "</br>";
			}
			echo "<label> Enter the updated grades, seperated by ',' as the delimiter </label>";
			echo "</br>";
			echo '<textarea id="update" name="update" rows="4" cols="50"></textarea>';
			echo "</br>"; echo "</br>";

			echo "Current Grade: " . $decodedData['grade'][$i];
			echo "</br>"; echo "</br>";

			echo "Current Comments: " . $decodedData['comments'][$i];
			#echo "<input name='currentComment' type='hidden' value='".$decodedData['comments'][$i]."'>";
			$_SESSION['currentComment'] = $decodedData['comments'][$i];
			echo "</br>";
			echo "<label> Enter the updated comment </label>";
			echo "</br>";
			echo '<textarea id="comment" name="comment" rows="4" cols="50"></textarea>';
			echo "</br>";

		}
	}
	echo "<input class='submit' name=\"submit\" type=\"submit\" align='center'/>";
	echo "</form>";
?>

<head>
	<title>Updates</title>
</head>