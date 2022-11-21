<?php
/*
	require_once 'teacherheader.php';

	if (isset($_POST['submit']))
	{
		$questionLst = $_POST['questionlst'];
		$scoresLst = $_POST['scores'];
		$ordering = "";

		$s = explode(",", $questionLst);
		for ($i = 0; $i < sizeof($s); $i++)
		{
			$ordering .= strval($i+1) . ",";
		}

		$ordering = rtrim($ordering, ",");
		$testName = $_POST['test_name'];
		$questionNumList = $ordering;
		$questionPointList = $scoresLst;
		$questionIdList = $questionLst;

		$URL= 'https://afsaccess4.njit.edu/~nk82/middle_addExam.php';
		$post_params="test_name=$testName&question_num_list=$questionNumList&question_point_list=$questionPointList&question_id_list=$questionIdList";
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
	$URL= 'https://afsaccess4.njit.edu/~nk82/middle_pullQuestions.php';
	$ch = curl_init();
	$options = array(CURLOPT_URL => $URL,
				         CURLOPT_HTTPHEADER =>
	array('Content-type:application/x-www-form-urlencoded'),
					 CURLOPT_RETURNTRANSFER => TRUE,
					 CURLOPT_POST => TRUE);
					 #CURLOPT_POSTFIELDS => $post_params) shouldn't need any post fields here;
	curl_setopt_array($ch, $options);
	$result = curl_exec($ch);
	curl_close($ch);

	$decodedData = json_decode($result, true);
	for ($i = 0; $i < sizeof($decodedData['id']); $i++){
		echo "</br>";
		echo "Question ID: ";
		echo $decodedData['id'][$i];
		echo "</br>";

		echo "Question: ";
		echo $decodedData['question'][$i];
		echo "</br>";

		echo "Question Topic: ";
		echo $decodedData['topic'][$i];
		echo "</br>";

		echo "Question Difficulty: ";
		echo $decodedData['difficulty'][$i];
		echo "</br>";
	}

	echo "<form action=\"\" method=\"post\">";
		echo "</br></br><label> Enter Test Name </label> </br>";
		echo "<input name='test_name' id='test_name'> </input></br></br>";
		echo "<label> Input questions id followed by ',' as delimiter </label></br>";
		echo "<textarea id=\"questionlst\" name=\"questionlst\" rows=\"5\" cols=\"33\" style=\"white-space: pre-wrap\"; placeholder=\"Question\" required></textarea></br></br>";
		echo "<label> Input scores for questions followed by ',' as delimiter </label></br>";
		echo "<textarea id=\"scores\" name=\"scores\" rows=\"5\" cols=\"33\" style=\"white-space: pre-wrap\"; placeholder=\"Question\" required></textarea></br></br>";
		echo "<input class='submit' name=\"submit\" type=\"submit\" align='center'/>";
	echo "</form>"
*/
require_once 'teacherheader.php';
echo "
<!DOCTYPE html>
<html>
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

<div id=\"search\" class=\"split left\">
 <script>
    var result;
    const request = new XMLHttpRequest();
    request.open('POST', 'https://afsaccess4.njit.edu/~nk82/middle_pullQuestions.php', false);  // `false` makes the request synchronous
    request.send(null);

    if (request.status === 200) {
    result = JSON.parse(request.responseText)
    let x=\"\"
    x+=\"<table id='table'><thead><tr><th></th><th>Question</th><th>Topic</th><th>Difficulty</th></tr></thead><tbody>\"
    x+=\"<tr><th></th><th><input type='text' id='filter1' onkeyup='mysearch(1)' /></th>\"
    x+=\"<th><select name=topics id='topics' onchange='mysearch(2)'><option value=''>Any</option><option value=Variables>Variables</option><option value=Lists>Lists</option><option value=IfStatements>If Statement</option><option value=ForLoop>For Loop</option><option value=WhileLoop>While Loop</option></select></th>\"
    x+=\"<th><select name=difficulties id='difficulties' onchange='mysearch(3)'><option value=''>Any</option><option value=Easy>Easy</option><option value=Medium>Medium</option><option value=Hard>Hard</option></select></th></tr>\"
    for(let i=0;i<result[\"id\"].length;i++)
        {
                x+=\"<tr class='row'><td> <input type='checkbox' onclick=addList(\"+i+\")>\"+\"</td><td class='question'>\"+result[\"question\"][i]+\"</td>\"+\"<td class='topic'>\"+result[\"topic\"][i]+\"</td>\"+\"<td class='difficulty'>\"+result[\"difficulty\"][i]+\"</td></tr>\"
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
            td1 = tr[i].getElementsByTagName(\"td\")[1];
            td2 = tr[i].getElementsByTagName(\"td\")[2];
            td3 = tr[i].getElementsByTagName(\"td\")[3];
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
 <script>
    var qlist = {
                    question:[],
                    row:[],
                    id:[]
                };
    function addList(j)
    {
        temp=qlist[\"row\"].indexOf(j)
        if (temp!=-1)
        {
            qlist[\"question\"].splice(temp,1);
            qlist[\"id\"].splice(temp,1);
            qlist[\"row\"].splice(temp,1);
        }
        else
        {
        qlist[\"question\"].push(result[\"question\"][j]);
        qlist[\"id\"].push(result[\"id\"][j]);
        qlist[\"row\"].push(j);
        }
        let x=\"\"
        x+=\"<form method='POST' action='examCreated.php'>\" //Change this to whatever page you want to use to format the lists.
        x+=\"<table id='Qlist'><thead><tr><th>Exam Question list</th><th>Points</th></tr></thead><tbody>\"
        for(let i=0;i<qlist[\"id\"].length;i++)
            {
                x+=\"<input type='hidden' name='q\"+i+\"' value='\"+qlist[\"id\"][i]+\"'>\" // so in the POST request you'll just go through q0 to qN to get the question IDS
                x+=\"<input type='hidden' name='qdesc\"+i+\"' value='\"+qlist[\"question\"][i]+\"'>\"//same idea here from qdesc0 to qdescN
                x+=\"<tr class='row'></td><td class='question'>\"+qlist[\"question\"][i]+\"</td><td><input type='text' name='qpoints\"+i+\"' required></td></tr>\"//and Here too
            }
            x+= \"</tbody></table>\"
            if(qlist[\"id\"].length!=0)
            {
                x+=  \"Testname:<input type='text' name='testName' required>\"
                x+=  \"<br><input type='submit' name='submit' value='submit'>\"
            }
        x+= \"</form>\"
            document.getElementById(\"questionList\").innerHTML=x;
            
    }

 </script>
</div>
<div id=\"questionList\" class=\"split right\">
    <table id='QList'><thead><tr><th>Exam Question list</th></tr></thead><tbody>
</div>
</html>
";
?>

<head>
  <title>Add Exams</title>
</head>
