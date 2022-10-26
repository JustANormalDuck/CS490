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
    
    for ($i = 0; $i < $decodeLength; $i++){
      if ($decodedData['id'][$i] == $examNum){
        $questionLst =  explode(",", $decodedData['qIDs'][$i]);
        $questionptLst = explode(",", $decodedData['pointList'][$i]);
        $_SESSION['testName'] = $decodedData['testName'][$i];
        break;
      }
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

    echo "<form action=\"\" method=\"post\">";
    echo "<label for='exam'> Choose Exam You would Like to Take: </label></br></br>";
    for ($i = 0; $i < $decodeLength; $i++){
    echo "-----------------</br>Exam ID: ";
    echo $decodedData['id'][$i];
    echo "</br>";

    echo "Test Name: ";
    echo $decodedData['testName'][$i];
    echo "</br>";

    echo "Number of Questions: ";
    echo $decodedData['numQuestions'][$i];
    echo "</br>";
  }

  echo "<input name=\"id\" type=\"text\" placeholder='Enter Exam ID'/>"; 
  echo "<input class='submit' name=\"submit\" type=\"submit\" align='center'/>";
  echo "</form>";
?>


<head>
  <title>Take Exam</title>
</head>
