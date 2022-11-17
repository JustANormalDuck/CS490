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
  #var_dump($decodedData);

  /*
  if (isset($_POST['submit'])){

    $_SESSION['examID'] = $_POST['examID'];
    echo "<script type=\"text/javascript\">
    window.location.href = 'viewExams.php';
    </script>";
  }*/

  echo "<table>";
  echo "<tr>";
    echo "<th style=\"height:100px;width:150px\">Exam ID</th>";
    echo "<th style=\"height:100px;width:150px\">Test Name</th>";
    echo "<th style=\"height:100px;width:150px\">View Exam</th>";
  echo "</tr>";

  $length = 0;
  if (empty($decodedData['examID']))
  {
    $length = 0;
  }
  else
  {
    $length = sizeof($decodedData['examID']);
  }

  for ($i = 0; $i < $length; $i++)
  {
    /*
    echo "<tr>";
    echo "<td style=\"style=\"height:100px;width:150px;text-align: center;\">" .  . "</td>";
    echo "<td style=\"style=\"height:100px;width:150px;text-align: center;\">" .  . "</td>";
    echo '<td><form action="" method=\"post\">';
    echo "<input type=\"hidden\" name=\"examID\" value='".trim($decodedData['examID'][$i],"\r")."'>";
    echo "<td style=\"style=\"height:100px;width:150px;text-align: center;\">" . "<input class='submit' name=\"submit\" type=\"submit\" align='center' value='View'/>" . "</td>";


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

    $response = explode("?", $decodedData['updatedPoints'][$i]);
    echo "<td style=\"style=\"height:100px;width:150px;text-align:center;\">";
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
    
    echo "</form></td>";
    echo "</tr>";
    */
    echo "
    <tr>
      <td>".$decodedData['examID'][$i]."</td>
      <td>".$decodedData['testName'][$i]."</td>
      <td><form action=\"viewExams.php\" method=\"post\">
      <input type=\"hidden\" id=\"examID\" name=\"examID\" value='".trim($decodedData['examID'][$i],"\r")."'>
      <input name=\"submit\" type=\"submit\" value='View' >
    </form></td>
    </tr>
    ";
  }
    echo "</table>";
?>


<head>
  <title>Take Exam</title>
</head>