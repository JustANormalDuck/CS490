<?php 
  require_once 'teacherheader.php';
  if (isset($_POST['submit'])){
    $difficulty = $_POST['questionDiff'];
    $topic = $_POST['qTopic'];
    $question = $_POST['question'];
    $funcName = $_POST['functionName'];
    $input1 = $_POST['input1'];
    $input2 = $_POST['input2'];
    $output1 = $_POST['output1'];
    $output2 = $_POST['output2'];
    //pass to backend the form functionName(input)?output
    $case1 = $funcName. "(" . $input1 . ")?" . $output1;
    $case2 = $funcName. "(" . $input2 . ")?" . $output2; 
    $URL= 'https://afsaccess4.njit.edu/~nk82/middle_addQuestion.php';
    $post_params="difficulty=$difficulty&topic=$topic&question=$question&function=$funcName&case1=$case1&case2=$case2";

    if (isset($_POST['input3']))
    {
      $input3 = $_POST['input3'];
      $output3 = $_POST['output3'];
      $case3 = $funcName. "(" . $input3 . ")?" . $output3;
      $post_params .= "&case3=$case3";
    }

    if (isset($_POST['input4']))
    {
      $input4 = $_POST['input4'];
      $output4 = $_POST['output4'];
      $post_params .= "&case4=$case4";
    }

    if (isset($_POST['input5']))
    {
      $input5 = $_POST['input5'];
      $output5 = $_POST['output5'];
      $post_params .= "&case5=$case5";
    }

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

    echo "<label> Choose a Constraint: </label>";
    echo "<select name='konstraint' id='konstraint'>";
    echo "<option value='None' selected> None </option>";
    echo "<option value='For'> For </option>";
    echo "<option value='While'> While </option>";
    echo "<option value='Recursion'> Recursion </option>";
    echo "</select>";
    echo "</br></br>";

    echo "<label> Enter Input Test Cases </label>  </br> ";
    echo "<input name=\"input1\" type=\"text\" placeholder='Input Case 1' required/>";
    echo "<input name=\"input2\" type=\"text\" placeholder='Input Case 2' required/>";
    echo "<input name=\"input3\" type=\"text\" placeholder='Input Case 3' />";
    echo "<input name=\"input4\" type=\"text\" placeholder='Input Case 4' />";
    echo "<input name=\"input5\" type=\"text\" placeholder='Input Case 5' />";
    echo "</br></br>";

    echo "<label> Enter Output Test Cases </label>  </br> ";
    echo "<input name=\"output1\" type=\"text\" placeholder='Output Case 1' required/>";
    echo "<input name=\"output2\" type=\"text\" placeholder='Output Case 2' required/>";
    echo "<input name=\"output3\" type=\"text\" placeholder='Output Case 3' />";
    echo "<input name=\"output4\" type=\"text\" placeholder='Output Case 4' />";
    echo "<input name=\"output5\" type=\"text\" placeholder='Output Case 5' />";
    echo "</br></br>";

    echo "<input class='submit' name=\"submit\" type=\"submit\" align='center'/>";

    echo "</form>";
?>

<head>
  <title>Add Questions</title>
</head>