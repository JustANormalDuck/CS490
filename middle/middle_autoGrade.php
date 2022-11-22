<?php
    $examID=intval($_POST['examID']);
    $username=$_POST['username'];
    $questionIDs=$_POST['questionIDList'];
    $responses=$_POST['responseList'];
    $responses=explode("?",$responses);
    $possible_points=$_POST['possible_points'];
    $possible_pointsArray = array_map('intval', explode(',', $possible_points));
    $questionIDs = array_map('intval', explode(',', $questionIDs));
    #$questionIDs=explode(',',$questionIDList);
    $grades='';
    $finalGrade=0;
    $questionNum=1;
    $comments='';
    for ($i=0; $i<sizeof($questionIDs);$i++)
    {
        $qmax=0; //Used to split points evenly for the normal test cases
        $qGrade=$possible_pointsArray[$i];

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

        #use these functions to trim and find function header:
        $functionName=explode("\n",$responses[$i]);
        $functionName=preg_replace('/[\s]+/mu', ' ', $responses[$i]);
        $functionName=explode(" ",$functionName);
        #then our second element explode our second element with ( as the delimter
        $functionName=explode("(",$functionName[1]);
        if($result['constraint']=='recursion')
        {
          if(substr_count($responses[$i],$functionName[0])<2)
          {
            $comments=$comments."Constraint?Expected:{$result['constraint']}?Recieved:None?Points:0/5\n";
            $qlost-=5;
          }
          else
          {
            $comments=$comments."Constraint?Expected:{$result['constraint']}?Recieved:Constraint Satisfied?Points:5/5\n";
            $qmax-=5;
          }
        
        }
        else if($result['constraint']!='ITANI')
        {
          if (strpos($responses[$i], $result['constraint']) == false) 
          {
            $comments=$comments."Constraint?Expected:{$result['constraint']}?Recieved:None?Points:0/5\n";
            $qGrade-=5;
          }
          else
          {
            $comments=$comments."Constraint?Expected:{$result['constraint']}?Recieved:Constraint Satisfied?Points:5/5\n";
            $qmax-=5;
          }
        }
        if($functionName[0]!=$result['func_name'])
        {

            $responses[$i] = preg_replace('/'.$functionName[0].'/',$result['func_name'],$responses[$i]); // remove the 1 parameter at the end for recursion
            $comments=$comments."Function Name?Expected:{$result['func_name']}?Recieved:{$functionName[0]}?Points:0/5\n";
            $qGrade-=5;
        }
        else
        {
          $comments=$comments."Function Name?Expected:{$result['func_name']}?Recieved:{$functionName[0]}?Points:5/5\n";
          $qmax-=5;
        }

        $counter=0;
        while($counter<5)
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
        $lost=($qGrade+$qmax)/$counter;#divide rest of points between test cases ($qGrade+$qmax) is there because if they got the other correct they still need to split evenly
        for ($x=1; $x<=$counter;$x++)
        {
            $case=explode('?',$result['case'.$x]);
            $f=fopen("test.py","w");
            fwrite($f,$responses[$i]);
            $temp=$case[0];
            fwrite($f,"\nprint($temp)");
            fclose($f);
            $output=exec("/usr/bin/python test.py 2>&1");
            if($output!=$case[1])
            {
                $qGrade-=$lost;
                if(strpos($output,"Error") !== false)
                {
                 $comments=$comments."{$case[0]}?Expected:{$case[1]}?Recieved:No output due to error in code?Points:0/$lost\n";
                }
                else
                {
                  $comments=$comments."{$case[0]}?Expected:{$case[1]}?Recieved:$output?Points:0/$lost\n";
                }
            }
            else
            {
              $comments=$comments."{$case[0]}?Expected:{$case[1]}?Recieved:$output?Points:$lost/$lost\n";
            }
        }
        $comments=$comments."$$$"; #This will be our question delimter for parsing.
        if($i+1==sizeof($questionIDs))
        {
            $grades.=strval($qGrade); 
        }
        else
        {
            $grades.=strval($qGrade.',');
        }
        $finalGrade+=$qGrade;
        $finalGrade=round($finalGrade,2);
        $questionNum+=1;
    }

    
    $URL='https://afsaccess4.njit.edu/~jmf64/back_addGrade.php';
    $post_params="username=$username&exam_id=$examID&earned_points=$grades&grade=$finalGrade&auto_comments=$comments";
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
    echo $result; // remove if it causes issues 
    $data=json_decode($result,true);
    //die(header('Location: https://afsaccess4.njit.edu/~jz565/frontAutograde.php'));
    
    

?>