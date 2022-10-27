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
  echo "<table>";
  echo "<tr>";
    echo "<th style=\"height:100px;width:150px\">Test Name</th>";
    echo "<th style=\"height:100px;width:150px\">Student Responses</th>";
    echo "<th style=\"height:100px;width:150px\">Earned Points</th>";
    echo "<th style=\"height:100px;width:150px\">Updated Points</th>";
    echo "<th style=\"height:100px;width:150px\">Possible Points</th>";
    echo "<th style=\"height:100px;width:150px\">Comments</th>";
  echo "</tr>";

  for ($i = 0; $i < sizeof($decodedData['examID']); $i++)
  {

    echo "<tr>";
    echo "<td style=\"style=\"height:100px;width:150px;text-align: center;\">" . $decodedData['testName'][$i] . "</td>";

    $response = explode("?", $decodedData['studentResponses'][$i]);
    echo "<td style=\"height:100px;width:150px;text-align:center;\">";
    foreach ($response as $ans){
      echo $ans;
      echo "</br>";
    }
    echo "</td>";

    $response = explode("?", $decodedData['earnedPoints'][$i]);
    echo "<td style=\"height:100px;width:150px;text-align:center;\">";
    foreach ($response as $ans){
      echo $ans;
      echo "</br>";
    }
    echo "</td>";

    $response = explode("?", $decodedData['possiblePoints'][$i]);
    echo "<td style=\"style=\"height:100px;width:150px;text-align:center;\">";
    foreach ($response as $ans){
      echo $ans;
      echo "</br>";
    }
    echo "</td>";

    echo "<td>" . $decodedData['grade'][$i] . "</td>";
    echo "<td>" . $decodedData['comments'][$i] . "</td>";
    echo "</tr>";
  }
    echo "</table>";
?>


<head>
  <title>Take Exam</title>
</head>