<?php
require_once 'teacherheader.php';
 $qidlist='';
 $qnumlist='';
 $qptlist='';
 $i=0;
 while(1)
 {
   if(isset($_POST["q$i"]))
   {
     $qidlist.=','.$_POST["q$i"];
     $qnumlist.=','.($i+1);
     $qptlist.=','.$_POST["qpoints$i"];
     $i+=1;
   }
   else
     break;
 }
 $qptlist=ltrim($qptlist,',');
 $qidlist=ltrim($qidlist,',');
 $qnumlist=ltrim($qnumlist,',');
 $testName = $_POST['testName'];
 /*
 echo $_POST['testName'];
 echo "<br>";
 echo $qnumlist;
 echo "<br>";
 echo $qidlist;
 echo "<br>";
 echo $qptlist;
 */

 $URL= 'https://afsaccess4.njit.edu/~nk82/middle_addExam.php';
 $post_params="test_name=$testName&question_num_list=$qnumlist&question_point_list=$qptlist&question_id_list=$qidlist";
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
?>