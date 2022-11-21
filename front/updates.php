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

		//echo $_SESSION['autoComment'];
		$autoQ = explode('$$$', $_SESSION['autoComment']);
		$len = sizeof($autoQ) - 1;
		$comments = "";
		$updatedGrades = array();

		//var_dump($autoQ);
		$s = "";
		for ($i = 0; $i < $len; $i++){
			//echo $autoQ[$i];
			$autoRow = explode("\n", $autoQ[$i]);
			$len2 = sizeof($autoRow) - 1;
			$grade = 0;
			for ($j = 0; $j < $len2; $j++){
				$auto = explode("Points:", $autoRow[$j]);
				$points = explode("/", $auto[1]);
				$points[0] = $_POST["grade$i$j"];
				$grade += floatval($_POST["grade$i$j"]);
				$s .= $auto[0] . "Points:" . implode("/", $points) . "\n";
				
				/*
				$auto = explode("?", $autoRow[$j]);
				$points = explode(":", $auto[3]);
				$points = explode("/", $points[1]);
				*/
				
				/*
				$points = explode("Points:", $auto[3]);
				$grades = array();
				for ($x = 0; $x < sizeof($points); $x++){
					$split = explode("/", $points[$x]);
					$split[0] =  $_POST["grade$i$j"];
					if ($x % 2 == 1){
						$s = $split[0] . "/" . $split[1] . "</br>";
						array_push($grades, $s);
					}
				}
				//Function Name?Expected:quadrupleIt?Recieved:quadrupleIt?Points:5/5 quadrupleIt(3)?Expected:12?Recieved:12?Points:47.5/47.5 quadrupleIt(4)?Expected:16?Recieved:16?Points:47.5/47.5
				*/
			}
			$s = $s . "$$$";
			$comments .= "$" . $_POST["comment$i"];
			array_push($updatedGrades, $grade);
		}

		$comments = ltrim($comments,"$");
		$stringUpdatedGrades = "";
		$grade = 0;
		foreach ($updatedGrades as $g){
			$stringUpdatedGrades .= strval($g) . ",";
			$grade += $g;
		}

		$stringUpdatedGrades = trim($stringUpdatedGrades, ",");
		
		$updatedPoints = $stringUpdatedGrades;
		$auto_comments=$s;
		$URL= 'https://afsaccess4.njit.edu/~nk82/middle_updateGrades.php';
		$post_params="username=$SUsername&exam_id=$examID&updated_points=$updatedPoints&grade=$grade&auto_comments=$auto_comments&comments=$comments";
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
		/*
		for ($i = 0; $i < $_SESSION['numQ']; $i++){
			for ($j = 0; $j < $_SESSION['numRows']; $j++){
				echo $_POST["grade$i$j"] . " ";
			}
		}
		*/
		/*
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
		*/

		

		unset($_SESSION['$examID']);
		unset($_SESSION['$SUsername']);
		unset($_SESSION['$examID']);
		unset($_SESSION['$numQ']);
		unset($_SESSION['$numRows']);

	}
	else
	{

	echo "</br>";
	echo "User: " . $SUsername;
	echo "</br>";
	echo "Exam ID: " . $examID;

	echo "</br>---------------------</br></br>";

	echo "<form action=\"\" method=\"post\">";

	#error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE); 
	$length = 0;
	if (empty($decodedData['examID']))
	{
	  $length = 0;
	}
	else
	{
	  $length = sizeof($decodedData['examID']);
	}

	$questionAuto = array();
	$earnedPoints = array();
	$updatedPoints = array();
	$possiblePoints = array();
	$studentResponse = array();
	$grade = 0;
	$comment = "";
	$_SESSION['autoComment'];
	for ($i = 0; $i < $length; $i++)
	{
		if (($decodedData['examID'][$i] == $examID) && ($decodedData['username'][$i] == $SUsername))
		{
			$_SESSION['autoComment'] = $decodedData['auto'][$i];
			$questionAuto = explode("$$$", $decodedData['auto'][$i]);
			$earnedPoints = explode(",", $decodedData['earnedPoints'][$i]);
			$updatedPoints = explode(",", $decodedData['updatedPoints'][$i]);
			$possiblePoints = explode(",", $decodedData['possiblePoints'][$i]);
			$studentResponse = explode("?", $decodedData['studentResponses'][$i]);
			$grade = $decodedData['grade'][$i];
			$comment = $decodedData['comments'][$i];
			/*
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
			echo '<textarea id="update" name="update" rows="4" cols="50">';
			echo $decodedData['earnedPoints'][$i];
			echo '</textarea>';
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
			*/

		}
	}

	$_SESSION['numQ'] = sizeof($questionAuto);

	$numRows = array();
	for ($i = 0; $i < sizeof($questionAuto); $i++){
		if (empty($questionAuto[$i])){
			continue;
		}
		echo "<table>";
		echo nl2br("<tr> <td colspan='5'> Student Response: </br>" . $studentResponse[$i] . "</td></tr>");
		$_SESSION['questions'][$i] = array();

		$autoRow = explode("\n", $questionAuto[$i]);
		$autoLen = sizeof($autoRow) - 1;
		
		for ($j = 0; $j < $autoLen; $j++){
			echo "<tr>";
			$auto = explode("?", $autoRow[$j]);
			$autoLen2 = sizeof($auto);
			$str = "";
			for ($k = 0; $k < $autoLen2; $k++){
				echo "<td>";
				echo $auto[$k] . "</br>";
				echo "</td>";
				if ($k == $autoLen2 - 1){
					$str = $auto[$k];
				}
			}
			$str2 = explode(":", $str);
			$str3 = explode("/", $str2[1]);
			echo "<td><input type=\"text\" id=\"grade$i$j\" name=\"grade$i$j\" value=\"$str3[0]\"> /$str3[1] </input> </td></tr>";
		}
		echo "<tr><td> Comments </td>";
		echo "<td> <textarea id=\"comment$i\" name=\"comment$i\" rows=\"4\" cols=\"50\"></textarea> </td>";
		echo "</tr>";

		//array_push($numRows, $autoLen);
		#var_dump($autoCol);
	
		/*
		$auto = explode("?", $autoCol[0]);
		var_dump($auto);
		if (!empty($auto)){
				echo "<tr>";
				foreach ($auto as $s){
					echo "<td>";
					echo $s . "</br>";
					echo "</td>";
				}
			echo "<td><input type=\"text\" id=\"cUpdate$i\" name=\"cUpdate$i\"> </input> </td>";
			echo "</tr>";
		}
	
		echo "<tr>";
		$auto = explode("?", $autoCol[1]);
		foreach ($auto as $s){
			echo "<td>";
			echo $s . "</br>";
			echo "</td>";
		}
		echo "<td><input type=\"text\" id=\"funcUpdate$i\" name=\"funcUpdate$i\"> </input> </td>";
		echo "</tr>";
	
		echo "<tr>";
		$auto = explode("?", $autoCol[2]);
		foreach ($auto as $s){
			echo "<td>";
			echo $s . "</br>";
			echo "</td>";
		}
		echo "<td><input type=\"text\" id=\"case1Update$i\" name=\"case1Update$i\"> </input> </td>";
		echo "</tr>";
	
		echo "<tr>";
		$auto = explode("?", $autoCol[3]);
		foreach ($auto as $s){
			echo "<td>";
			echo $s . "</br>";
			echo "</td>";
		}
		echo "<td><input type=\"text\" id=\"case2Update$i\" name=\"case2Update$i\"> </input> </td>";
		echo "</tr>";
	
		if ($autoLen == 5){
		echo "<tr>";
		$auto = explode("?", $autoCol[4]);
		foreach ($auto as $s){
			echo "<td>";
			echo $s . "</br>";
			echo "</td>";
		}
		echo "<td><input type=\"text\" id=\"case3Update$i\" name=\"case3Update$i\"> </input> </td>";
		echo "</tr>";
		}
	
		if ($autoLen == 6){
			echo "<tr>";
			$auto = explode("?", $autoCol[5]);
			foreach ($auto as $s){
				echo "<td>";
				echo $s . "</br>";
				echo "</td>";
			}
			echo "<td><input type=\"text\" id=\"case4Update$i\" name=\"case4Update$i\"> </input> </td>";
			echo "</tr>";
		}
	
		if ($autoLen == 7){
			echo "<tr>";
			$auto = explode("?", $autoCol[6]);
			foreach ($auto as $s){
				echo "<td>";
				echo $s . "</br>";
				echo "</td>";
				echo "<td><input type=\"text\" id=\"case5Update$i\" name=\"case5Update$i\"> </input> </td>";
			}
			echo "</tr>";
		}


	}
	$_SESSION['numRows'] = $numRows;
	*/

	}
	
	echo "</table><table> <tr> <th> Grade: $grade </th> </tr> </table></br></br><input class='submit' name=\"submit\" type=\"submit\" value='Release' align='center'/>";
	echo "</form>";
	}
?>

<head>
	<title>Updates</title>
</head>