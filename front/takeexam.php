<?php 
  require_once 'header.php';
  $username = $_SESSION["username"];
  $URL= 'https://afsaccess4.njit.edu/~nk82/middle_pullExams.php';
  $post_params="username=$username";
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

  if (!isset($decodedData['id']))
  {
    echo "No exams to take at the moment";
    $decodeLength = 0;
  }
  else{
    $decodeLength = sizeof($decodedData['id']);
  }


  if (isset($_POST['submit'])){
    $username = $_SESSION["username"];
    $examNum = $_POST['id'];
    
    $found = false;
    for ($i = 0; $i < $decodeLength; $i++){
      if ($decodedData['id'][$i] == $examNum){
        $questionLst =  explode(",", $decodedData['qIDs'][$i]);
        $questionptLst = explode(",", $decodedData['pointList'][$i]);
        $_SESSION['testName'] = $decodedData['testName'][$i];
        $_SESSION['ptlst'] = $decodedData['pointList'][$i];
        $found = true;
        break;
      }
    }

    if (!$found){
      echo "<script type=\"text/javascript\">
      window.location.href = 'takeexam.php';
      </script>";
    }

    /*
    foreach ($questionLst as $q) {
      echo $q;
      echo "</br>";
    }
    */

    $_SESSION['examNum'] = $examNum;
    $_SESSION['questionLst'] = $questionLst;
    $_SESSION['questionPts'] = $questionptLst;

    echo "<script type=\"text/javascript\">
    window.location.href = 'examPage.php';
    </script>";

  }

    
    echo "<label for='exam'> Choose Exam You would Like to Take: </label></br></br>";
    echo "<table>";
    for ($i = 0; $i < $decodeLength; $i++){
    echo "<tr>";
    echo "<form action=\"\" method=\"post\">";
    echo "<td> Exam ID: ". $decodedData['id'][$i] . "</td>";

    echo  "<td> Test Name: ". $decodedData['testName'][$i] . "</td>";

    echo  "<td> Number of Questions: ". $decodedData['numQuestions'][$i] . "</td>";
    echo "<input type=\"hidden\" id=\"id\" name=\"id\" value='".trim($decodedData['id'][$i],"\r")."'>";
    echo "<td><input name=\"submit\" type=\"submit\" value='Take Exam'></td>";
    echo "</form>";
    echo "</tr>";
    
  }
  /*
  echo "<input name=\"id\" type=\"text\" placeholder='Enter Exam ID'/>"; 
  echo "<input class='submit' name=\"submit\" type=\"submit\" align='center'/>";
  */
  echo "</table>";

?>


<head>
  <title>Take Exam</title>
</head>