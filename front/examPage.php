<?php
  require_once 'header.php';

  if (isset($_POST['submit']))
  {

    $counter = 0;
    $responses = "";
    while (1){
      if(isset($_POST["answer$counter"])){
        #echo $_POST["answer$counter"];
        $responses .= $_POST["answer$counter"] . "?";
        $counter++;
      }
      else{
        break;
      }
    }

    $responses = rtrim($responses, "?");
    $username = $_SESSION['username'];
    $examNum = $_SESSION['examNum'];
    $testName = $_SESSION['testName'];
    $questionPts = $_SESSION['questionPts'];
    $ptList = $_SESSION['ptlst'];
    #$URL = 'https://afsaccess4.njit.edu/~jmf64/back_addDefaultGrade.php';
    $URL= 'https://afsaccess4.njit.edu/~nk82/middle_addDefaultGrade.php';
    $responses = str_replace('+','%2b',$responses);
    $post_params="username=$username&exam_id=$examNum&test_name=$testName&student_responses=$responses&possible_points=$ptList";
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

    if ($decodedData['error'] == "Successfully entered a default grade"){
      echo "Exam has been successfully submitted.";
    }

    unset($_SESSION['examNum']);
    unset($_SESSION['questionLst']);
    unset($_SESSION['questionPts']);
    unset($_SESSION['testName']);
    echo "<script type=\"text/javascript\">
    window.location.href = 'takeexam.php';
    </script>";
    }
?>
<script type="text/javascript">
    var username="<?php echo $_SESSION['username']; ?>";
    var examNum="<?php echo $_SESSION['examNum']; ?> ";
    var testName="<?php echo $_SESSION['testName']; ?>";
    var questionPts=<?php echo json_encode($_SESSION['questionPts']); ?>;
    var questionLst=<?php echo json_encode($_SESSION['questionLst']); ?>;
</script>

<!DOCTYPE html>
<html>
    <div id="exam"> <!--Display exam here -->
        <?php
        $username = $_SESSION['username'];
        $examNum = $_SESSION['examNum'];
        $questionLst = $_SESSION['questionLst'];
        $questionPts = $_SESSION['questionPts'];
      
        $questionDiff = array();
        $questionTopic = array();
        $question = array();
        $qpts = array();
        $error = array();
      
        $length = 0;
        if (empty($questionLst))
        {
          $length = 0;
        }
        else
        {
          $length = sizeof($questionLst);
        }
      
        for ($i = 0; $i < $length; $i++){
          $qID= $questionLst[$i];
          $URL= 'https://afsaccess4.njit.edu/~nk82/middle_pullQuestion.php';
          $post_params="question_id=$qID";
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
      
          array_push($questionDiff, $decodedData['difficulty']);
          array_push($questionTopic, $decodedData['topic']);
          array_push($qpts, $decodedData['question_point_list']);
          array_push($question, $decodedData['question']);
        }
        echo "<form action=\"\" method=\"post\">";
        for ($i = 0; $i < sizeof($questionDiff); $i++){
            if($i==0)
                echo "<div id=field".$i.">";
            else
                echo "<div id=field".$i." style='display:none;'>";
          echo "</br>";
          echo "Difficulty: ";
          echo $questionDiff[$i];
          echo "</br>";
      
          echo "Topic: ";
          echo $questionTopic[$i];
          echo "</br>";
      
          echo "Points: ";
          echo $questionPts[$i];
          echo "</br>";
      
          echo "Question: ";
          echo $question[$i];
          echo "</br>";
      
          echo "<textarea id=\"answer$i\" name=\"answer$i\" rows=\"5\" cols=\"33\" style=\"white-space: pre-wrap\"; placeholder=\"Question\" required></textarea>";
          echo "</div>";
        }
        echo "<input class='submit' name=\"submit\" type=\"submit\" value='submit' align='center'/>";
        echo "</form>";
        ?>
    </div>

    <div id="buttons"> <!--Display buttons here -->

    </div>
    <script>
        /*
        var f=questionLst.length;//This would actual be the question count we get
        let x='';
        x+="<form action='' method='POST' id='submission'>"; //could redirect to itself again like old examPage.php
        for(let i=0;i<f;i++)
        {
            if(i==0)
                x+="<div id=field"+i+">";
            else
                x+="<div id=field"+i+" style='display:none;'>";
            x+="<br>Question"+i+": bla bla<br>";
            x+="<textarea id='answer"+i+"' name='answer"+i+"' rows='5' cols='33' style='white-space: pre-wrap'; placeholder='Answer' required></textarea>";
            x+="</div>";
        }
        x+="<input type='submit' name='submit' value='submit'>";
        x+="</form>";
        */
        let y='';
        for(let i=0;i<questionPts.length;i++)
        {
            y+="<button id='button"+i+"' onclick='hideStuff("+i+")'>"+(i+1)+"</button>";
        }

        //document.getElementById("exam").innerHTML=x;
        document.getElementById('buttons').innerHTML=y;
        function hideStuff(x)
        {
            for(let i=0;i<questionPts.length;i++)
            {

                let y = document.getElementById("field"+i);
                if(i==x)
                {
                    y.style.display = "";
                }
                else
                    y.style.display = "none";
            }
        } 
        
    </script>
</html> 