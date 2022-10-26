<?php
    $examID=$_POST['examID'];
    $username=$_POST['username'];
    $questionIDs=$_POST['questionIDList']; 
    $responses=$_POST['responseList'];
    $responses=explode("?",$responses);
    $possible_points=$_POST['possible_points'];
    $possible_pointsArray = array_map('intval', explode(',', $possible_points));
    $possible_points=explode(",",$possible_points);
    $questionIDs=explode(",",$questionIDList);
    $grades='';
    $finalGrade=0;
    $questionNum=1;
    $comments='';
    for ($i=0; $i<sizeof($questionIDs);$i++)
    {
        $qGrade=$possible_pointsArray[$i];
        #echo $qGrade."\n";
        $qGrade=intval($qGrade);
        $URL= 'https://afsaccess4.njit.edu/~jmf64/back_pullTestCases.php';
        $post_params="question_id=$questionIDs[$i]";
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
        $result=json_decode($result,true);
        #echo $result['func_name'];
        #use these functions to trim and find function header:
        $functionName=explode("\n",$responses[$i]);
        $functionName=preg_replace('/[\s]+/mu', ' ', $responses[$i]);
        $functionName=explode(" ",$functionName);
        #then our second element explode our second element with ( as the delimter
        $functionName=explode("(",$functionName[1]);
        #echo "Function name is: ";
        #echo $functionName[0];
        if($functionName[0]!=$result['func_name'])
        {
            #echo "\n\nReplaced Function Name: \n";
            $txt = preg_replace('/'.$functionName[0].'/',$result['func_name'],$responses[$i],1);
            $comments=$comments."\n Autograder: Question $questionNum failed to match function name (Expected: {$result['func_name']}, Wrote: {$functionName[0]})";
            $qGrade-=5;
        }
        $counter=0;
        while(true)
        {
          $temp=$counter+1;
          if($result['case'.$temp]!="ITANI")
          {
            $counter=$counter+1;
          }
          else
          {
            break;
          }
          
        }
        $lost=$qGrade/$counter;#divide rest of points between test cases
        for ($x=1; $x<=$counter;$x++)
        {
            $case=explode('?',$result['case'.$x]);
            $f=fopen("test.py","w");
            fwrite($f,$txt);
            $temp=$case[0];
            fwrite($f,"\nprint($temp)");
            fclose($f);
            $output=exec("/usr/bin/python test.py 2>&1");
            if($output!=$case[1])
            {
                $qGrade-=$lost;
                if(strpos($output,"Error") !== false)
                {
                 $comments=$comments."\n Autograder: Question $questionNum test case $x failed due to an error in the code";
                }
                else
                {
                  $comments=$comments."\n Autograder: Question $questionNum test case $x failed (Expected output: {$case[1]}, Recieved output: $output)";
                }
            }
        }
        #echo $qGrade."\n";
        if($i+1==sizeof($questionIDs))
        {
            $grades.=strval($qGrade); 
        }
        else
        {
            $grades.=strval($qGrade.',');
        }
        $finalGrade+=$qGrade;
        $finalGrade=round($finalGrade);
        $questionNum+=1;
    }
    $URL= 'https://afsaccess4.njit.edu/~jmf64/back_addGrade.php';
    $post_params="username=$username&exam_id=$examID&earned_points=$grades&possible_points=$possible_points&grade=$finalGrade&comments=$comments";
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
    echo $result;
    

?>