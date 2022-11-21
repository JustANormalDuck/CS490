<?php
require_once 'header.php';
$username = $_SESSION["username"];
$role = $_SESSION["role"];
$examID = $_POST['examID'];

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

$length = 0;
if (empty($decodedData['examID']))
{
  $length = 0;
}
else
{
  $length = sizeof($decodedData['examID']);
}

echo "</br>Exam #: " . $examID . "</br></br>";
$questionAuto = array();
$earnedPoints = array();
$updatedPoints = array();
$possiblePoints = array();
$studentResponse = array();
$grade = 0;
$comment = "";

for ($i = 0; $i < $length; $i++)
{
    if ($decodedData['examID'][$i] == $examID){
        $questionAuto = explode("$$$", $decodedData['auto'][$i]);
        $earnedPoints = explode(",", $decodedData['earnedPoints'][$i]);
        $updatedPoints = explode(",", $decodedData['updatedPoints'][$i]);
        $possiblePoints = explode(",", $decodedData['possiblePoints'][$i]);
        $studentResponse = explode("?", $decodedData['studentResponses'][$i]);
        $grade = $decodedData['grade'][$i];
        $comment = $decodedData['comments'][$i];
    }
}

$comments = explode("$", $comment);
for ($i = 0; $i < sizeof($questionAuto) - 1; $i++){
    echo "<table>";
    echo nl2br("<tr> <td colspan='4'> Student Response: </br>" . $studentResponse[$i] . "</td></tr>");
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
    }
    echo "<tr><td colspan='4'> Comments: $comments[$i]</td></tr>";
    //echo "<tr><td colspan='4'> Final Grade: $grade</td></tr>";
    echo "</table></br>";
    /*
    if (empty($questionAuto[$i])){
        continue;
    }

    
    echo "<table>";
    echo "<tr> <td colspan='3'> Student Response: </br>" . $studentResponse[$i] . "</td></tr>";
    $autoCol = explode("\n", $questionAuto[$i]);
    $autoLen = sizeof($autoCol) - 1;
    var_dump($autoCol);

    echo "<tr>";
        $auto = explode(",", $autoCol[0]);
        foreach ($auto as $s){
            echo "<td>";
            echo $s . "</br>";
            echo "</td>";
        }
    echo "</tr>";

    echo "<tr>";
    $auto = explode(",", $autoCol[1]);
    foreach ($auto as $s){
        echo "<td>";
        echo $s . "</br>";
        echo "</td>";
    }
    echo "</tr>";

    echo "<tr>";
    $auto = explode(",", $autoCol[2]);
    foreach ($auto as $s){
        echo "<td>";
        echo $s . "</br>";
        echo "</td>";
    }
    echo "</tr>";

    echo "<tr>";
    $auto = explode(",", $autoCol[3]);
    foreach ($auto as $s){
        echo "<td>";
        echo $s . "</br>";
        echo "</td>";
    }
    echo "</tr>";

    if ($autoLen == 5){
    echo "<tr>";
    $auto = explode(",", $autoCol[4]);
    foreach ($auto as $s){
        echo "<td>";
        echo $s . "</br>";
        echo "</td>";
    }
    echo "</tr>";
    }

    if ($autoLen == 6){
        echo "<tr>";
        $auto = explode(",", $autoCol[5]);
        foreach ($auto as $s){
            echo "<td>";
            echo $s . "</br>";
            echo "</td>";
        }
        echo "</tr>";
    }

    if ($autoLen == 7){
        echo "<tr>";
        $auto = explode(",", $autoCol[6]);
        foreach ($auto as $s){
            echo "<td>";
            echo $s . "</br>";
            echo "</td>";
        }
        echo "</tr>";
    }
    */

    /*
        <th style=\"height:100px;width:150px\">Function Name</th>
        <th style=\"height:100px;width:150px\">Test Case 1</th>
        <th style=\"height:100px;width:150px\">Test Case 2</th>
        <th style=\"height:100px;width:150px\">Test Case 3</th>
        <th style=\"height:100px;width:150px\">Test Case 4</th>
        <th style=\"height:100px;width:150px\">Test Case 5</th>
    */

    /*
    echo "<th style=\"height:100px;width:150px\">Student Response</th>";
    echo "<th style=\"height:100px;width:150px\">Earned Points</th>";
    echo "<th style=\"height:100px;width:150px\">Updated Points</th>";
    echo "<th style=\"height:100px;width:150px\">Worth</th>";
    echo "<th style=\"height:100px;width:150px\">Auto Comment1</th>";
    echo "<th style=\"height:100px;width:150px\">Auto Comment2</th>";
    echo "<th style=\"height:100px;width:150px\">Auto Comment3</th>";
    echo "<th style=\"height:100px;width:150px\">Auto Comment4</th>";
    */
}
echo "<table><tr><th>Grade: $grade</th></tr></table>";


/*
echo "<table>";
echo "<tr>";
  echo "<th style=\"height:100px;width:150px\">Student Response</th>";
  echo "<th style=\"height:100px;width:150px\">Earned Points</th>";
  echo "<th style=\"height:100px;width:150px\">Updated Points</th>";
  echo "<th style=\"height:100px;width:150px\">Worth</th>";
  echo "<th style=\"height:100px;width:150px\">Auto Comment1</th>";
  echo "<th style=\"height:100px;width:150px\">Auto Comment2</th>";
  echo "<th style=\"height:100px;width:150px\">Auto Comment3</th>";
  echo "<th style=\"height:100px;width:150px\">Auto Comment4</th>";
echo "</tr>";

for ($i = 0; $i < sizeof($studentResponse); $i++){
    echo "<tr>";
    echo "<td>" . $studentResponse[$i] . "</td>";
    echo "<td>" . $earnedPoints[$i] . "</td>";
    echo "<td>" . $updatedPoints[$i] . "</td>";
    echo "<td>" . $possiblePoints[$i] . "</td>";
    $autoComments = explode(",", $auto[$i]);
    var_dump($autoComments);
    $iterator = 0;
    for ($j = 0; $j < 4; $j++){
        echo "<td>";
        for ($k = 0; $k < 4; $k++){
            echo $autoComments[$k + $iterator] . "</br></br>";
        }
        echo "</td>";
        $iterator += 4;
    }
    echo "</tr>";
}

echo "<tr>";
echo "<td colspan = '1'> Total Grade: " . $grade . "<td>";
echo "<td colspan = '4'> Comments: " . $comment . "<td>";
echo "</tr>";
echo "</table>";
*/
?>