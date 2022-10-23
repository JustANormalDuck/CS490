<?php
    $txt = $_POST['code'];
    #$examID=$_POST['examID']; #comment out for now to test
    #$questionIDs=$_POST['questionIDList']; #comment out for now to test
    #$responses=$_POST['responseList']; #comment out for now to test
    #$possible_points=$_POST['possible_points'];
    $possible_points=explode(",",$possible_points);
    #$questionIDs=explode(",",$possible_points);
    $possible_points=array(50,50); #TEsting remove later
    $questionIDs=array(1,2); #TEsting remove later
    $grades='';
    for ($i=0; $i<sizeof($questionIDs);$i++)
    {
        $qGrade=$possible_points[$i];
        echo $qGrade."\n";
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
        $functionName=explode("\n",$txt);
        $functionName=preg_replace('/[\s]+/mu', ' ', $txt);
        $functionName=explode(" ",$functionName);
        #then our second element explode our second element with ( as the delimter
        $functionName=explode("(",$functionName[1]);
        #echo "Function name is: ";
        #echo $functionName[0];
        if($functionName[0]!=$result['func_name'])
        {
            #echo "\n\nReplaced Function Name: \n";
            $txt = preg_replace('/'.$functionName[0].'/',$result['func_name'],$txt,1);
            $qGrade-=5;
        }
        /* Later on use this to count how many test cases we have, for now it's hard coded 2 cases
        $counter=0;
        while(true)
        {

        }
        */
        $lost=$qGrade/2;#divide rest of points between test cases
        for ($x=1; $x<=2;$x++)
        {
            $case=explode('?',$result['case'.$x]);
            $f=fopen("test.py","w");
            fwrite($f,$txt);
            $temp=$case[0];
            fwrite($f,"print($temp)");
            fclose($f);
            $output=exec("/usr/bin/python test.py 2>&1");
            if($output!=$case[1])
            {
                $qGrade-=$lost;
            }
        }
        echo $qGrade."\n";
        if($i+1==sizeof($questionIDs))
        {
            $grades.=strval($qGrade); 
        }
        else
        {
            $grades.=strval($qGrade.',');
        }
    }
    #echo $grades;
    


?>