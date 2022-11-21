<?php
require_once 'teacherheader.php';
echo "
<style>
.split {
    height: 100%;
    width: 50%;
    position: fixed;
    z-index: 1;
    top: 100px;
    overflow-x: hidden;
    padding-top: 20px;
  }
  
  /* Control the left side */
  .left {
    left: 0;
    padding-left:10px;
    
  }
  .centered {
  position: absolute;
  left: 50%;
  transform: translate(-50%, -50%);
  text-align: center;
}
  /* Control the right side */
  .right {
    right: 0;
    padding-left:20px;
}
</style>
"; 
echo "
<div id=\"search\" class=\"split right\">
 <script>
    const request = new XMLHttpRequest();
    request.open('POST', 'https://afsaccess4.njit.edu/~nk82/middle_pullQuestions.php', false);  // `false` makes the request synchronous
    request.send(null);

    if (request.status === 200) {
    var result = JSON.parse(request.responseText)
    let x=\"\"
    x+=\"<table id='table'><thead><tr><th>Question</th><th>Topic</th><th>Difficulty</th></tr></thead><tbody>\"
    x+=\"<tr><th><input type='text' id='filter1' onkeyup='mysearch(1)' /></th>\"
    x+=\"<th><select name=topics id='topics' onchange='mysearch(2)'><option value=''>Any</option><option value=Variables>Variables</option><option value=Lists>Lists</option><option value=IfStatements>If Statement</option><option value=ForLoop>For Loop</option><option value=WhileLoop>While Loop</option></select></th>\"
    x+=\"<th><select name=difficulties id='difficulties' onchange='mysearch(3)'><option value=''>Any</option><option value=Easy>Easy</option><option value=Medium>Medium</option><option value=Hard>Hard</option></select></th></tr>\"
    for(let i=0;i<result[\"id\"].length;i++)
        {
                x+=\"<tr class='row'><td class='question'>\"+result[\"question\"][i]+\"</td>\"+\"<td class='topic'>\"+result[\"topic\"][i]+\"</td>\"+\"<td class='difficulty'>\"+result[\"difficulty\"][i]+\"</td></tr>\"
            }
            x+= \"</tbody></table>\"
            document.getElementById(\"search\").innerHTML+=x;
    }

 </script>
 <script>
    var f1=''
    var f2=''
    var f3=''
    function mysearch(num)
    {
        var input, filter, table, tr, td, i, txtValue;
        if(num==1)
        {
            input = document.getElementById(\"filter1\");
            f1=input.value.toUpperCase();
        }

        if(num==2)
        {
            input = document.getElementById(\"topics\");
            f2=input.value.toUpperCase();
        }
        
        if(num==3)
        {
            input = document.getElementById(\"difficulties\");
            f3=input.value.toUpperCase();
        }

        //filter = input.value.toUpperCase();
        table = document.getElementById(\"table\");
        tr = table.getElementsByTagName(\"tr\");
        for (i = 0; i < tr.length; i++) {
            td1 = tr[i].getElementsByTagName(\"td\")[0];
            td2 = tr[i].getElementsByTagName(\"td\")[1];
            td3 = tr[i].getElementsByTagName(\"td\")[2];
            if (td1 && td2 && td3) 
            {
                txtValue1 = td1.textContent || td1.innerText;
                txtValue2 = td2.textContent || td2.innerText;
                txtValue3 = td3.textContent || td3.innerText;
                if (txtValue1.toUpperCase().indexOf(f1) > -1 && txtValue2.toUpperCase().indexOf(f2) > -1 && txtValue3.toUpperCase().indexOf(f3) > -1 ) {
                    tr[i].style.display = \"\";
                } else {
                    tr[i].style.display = \"none\";
                }
            }       
  }
    }
 </script>
</div>
";

  if (isset($_POST['submit'])){
    $difficulty = $_POST['questionDiff'];
    $topic = $_POST['qTopic'];
    $question = $_POST['question'];
    $funcName = $_POST['functionName'];
    $input1 = $_POST['input1'];
    $input2 = $_POST['input2'];
    $output1 = $_POST['output1'];
    $output2 = $_POST['output2'];
    $konstraint = $_POST['konstraint'];
    //pass to backend the form functionName(input)?output
    $case1 = $funcName. "(" . $input1 . ")?" . $output1;
    $case2 = $funcName. "(" . $input2 . ")?" . $output2;

    $URL= 'https://afsaccess4.njit.edu/~nk82/middle_addQuestion.php';
    $post_params="difficulty=$difficulty&topic=$topic&question=$question&function=$funcName&case1=$case1&case2=$case2";

    if ($konstraint != "None")
    {
      $post_params .= "&konstraint=$konstraint";
    }
    else{
      $post_params .= "&konstraint=ITANI";
    }

    if ($_POST['input3'] != "")
    {
      $input3 = $_POST['input3'];
      $output3 = $_POST['output3'];
      $case3 = $funcName. "(" . $input3 . ")?" . $output3;
      $post_params .= "&case3=$case3";
    }

    if ($_POST['input4'] != "")
    {
      $input4 = $_POST['input4'];
      $output4 = $_POST['output4'];
      $case4 = $funcName. "(" . $input4 . ")?" . $output4;
      $post_params .= "&case4=$case4";
    }

    if ($_POST['input5'] != "")
    {
      $input5 = $_POST['input5'];
      $output5 = $_POST['output5'];
      $case5 = $funcName. "(" . $input5 . ")?" . $output5;
      $post_params .= "&case5=$case5";
    }
    //echo $post_params;

    //echo $case4;
    //echo $case5;
    
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

    //echo $result;

    $decodedData = json_decode($result, true);
    echo "<p style=\"color:green;\">" . $decodedData['error'] . "</p>";
    
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
    echo "<option value='for'> For </option>";
    echo "<option value='while'> While </option>";
    echo "<option value='recursion'> Recursion </option>";
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