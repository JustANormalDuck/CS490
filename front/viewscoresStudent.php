<?php 
  #ASK IF IT HAS TO BE IN TABLES :)
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
  for ($i = 0; $i < sizeof($decodedData['examID']); $i++){
    echo "------------------</br>";
    echo "Test Name: ";
    echo $decodedData['testName'][$i];
    echo "</br></br>";

    echo "Student Responses: ";
    $response = explode("?", $decodedData['studentResponses'][$i]);
    echo "</br>";
    foreach ($response as $ans){
      echo $ans;
      echo "</br>";
    }
    echo "</br>";

    echo "Earned Points: ";
    $response = explode("?", $decodedData['earnedPoints'][$i]);
    echo "</br>";
    foreach ($response as $ans){
      echo $ans;
      echo "</br>";
    }
    echo "</br>";

    echo "Updated Points: ";
    $response = explode(",", $decodedData['updatedPoints'][$i]);
    echo "</br>";
    foreach ($response as $ans){
      echo $ans;
      echo "</br>";
    }
    echo "</br>";

    echo "Possible Points: ";
    $response = explode(",", $decodedData['possiblePoints'][$i]);
    echo "</br>";
    foreach ($response as $ans){
      echo $ans;
      echo "</br>";
    }
    echo "</br>";

    echo "Grade: ";
    echo $decodedData['grade'][$i];
    echo "</br></br>";

    echo "Comments: ";
    echo $decodedData['comments'][$i];
    echo "</br></br>";
  }
?>

<head>
  <title>Take Exam</title>
</head>