<?php 
  require_once 'teacherheader.php';
  if (isset($_POST['submit'])){
    $difficulty = $_POST['questionDiff'];
    $topic = $_POST['qTopic'];
    $question = $_POST['question'];
    $funcName = $_POST['functionName'];
    $case1 = $_POST['testCase1'];
    $case2 = $_POST['testCase2'];

    $URL= 'https://afsaccess4.njit.edu/~nk82/middle_addQuestion.php';
    $post_params="difficulty=$difficulty&topic=$topic&question=$question&function=$funcName&case1=$case1&case2=$case2";
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
    echo "<form action=\"\" method=\"post\">";

    echo "<label for='qdiff'> Choose a question difficulty: </label>";

    echo "<select name='questionDiff' id='questionDiff'>";
    echo "<option value='Easy' selected> Easy </option>";
    echo "<option value='Medium'> Medium </option>";
    echo "<option value='Hard'> Hard </option>";
    echo "</select>";
    echo "</br></br>";

    echo "<label for='qTopic'> Choose a Topic: </label>";
    echo "<select name='qTopic' id='qTopic'>";
    echo "<option value='ForLoop' selected> For Loops </option>";
    echo "<option value='While Loop'> While Loops </option>";
    echo "<option value='Variables'> Variables </option>";
    echo "<option value='IfStatements'> If Statements </option>";
    echo "<option value='Lists'> Lists </option>";
    echo "</select>";
    echo "</br></br>";

    echo '<label> Question </label></br>';
    echo '<textarea id="question" name="question" rows="5"cols="33" style="white-space: pre-wrap; placeholder="Question"></textarea>';
    echo "</br></br>";

    echo "<input name=\"functionName\" type=\"text\" placeholder='Function Name'/>";
    echo "</br></br>";

    echo "<label> Test Cases must be passed in the form functionName(input)?output</label>  </br> ";
    echo "<input name=\"testCase1\" type=\"text\" placeholder='Test Case 1'/>";
    echo "<input name=\"testCase2\" type=\"text\" placeholder='Test Case 2'/>";
    echo "</br></br>";

    echo "<input class='submit' name=\"submit\" type=\"submit\" align='center'/>";

    echo "</form>";
?>

<head>
  <title>Add Questions</title>
</head>