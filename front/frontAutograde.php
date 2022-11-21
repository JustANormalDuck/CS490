<?php

require_once 'teacherheader.php';
if (isset($_POST['submit'])) 
  {
    $examID=$_POST['examID'];
    $username=$_POST['username'];
    $questionIDs=$_POST['questionIDList'];
    $responses=$_POST['responseList'];
    $responses=str_replace('+','%2b',$responses);
    $possible_points=$_POST['possible_points'];

    $URL="https://afsaccess4.njit.edu/~nk82/middle_autoGrade.php";
    $post_params="examID=$examID&username=$username&questionIDList=$questionIDs&responseList=$responses&possible_points=$possible_points";
    $ch = curl_init();
    $options = array(CURLOPT_URL => $URL,
			         CURLOPT_HTTPHEADER =>
    array('Content-type:application/x-www-form-urlencoded'),
				   CURLOPT_RETURNTRANSFER => TRUE,
				   CURLOPT_POST => TRUE,
           CURLOPT_POSTFIELDS => $post_params);
    curl_setopt_array($ch, $options);
    $result = curl_exec($ch);
    $data=json_decode($result,true);

    echo "Grades Submitted";
  }
$URL= 'https://afsaccess4.njit.edu/~nk82/middle_pullUngraded.php';
$ch = curl_init();
$options = array(CURLOPT_URL => $URL,
               CURLOPT_HTTPHEADER =>
array('Content-type:application/x-www-form-urlencoded'),
         CURLOPT_RETURNTRANSFER => TRUE,
         CURLOPT_POST => TRUE);
curl_setopt_array($ch, $options);
$result = curl_exec($ch);
$data=json_decode($result,true);

  echo '
        <style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
</style>';



echo "
<table>
  <tr>
    <th>Exam</th>
    <th>User Name</th>
    <th></th>
  </tr>";

$length = 0;

if (empty($data['examID']))
{
  $length = 0;
}
else
{
  $length = sizeof($data['examID']);
}

for($i=0;$i<$length;$i++)
{
  $URL= 'https://afsaccess4.njit.edu/~nk82/middle_pullQuestionIDs.php';
  $post_params="exam_id=".$data['examID'][$i];
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
  $temp=json_decode($result,true);
  $temp=$temp["questionIDList"];
  echo"
  <tr>
    <td>".$data['testName'][$i]."</td>
    <td>".$data['username'][$i]."</td>
    <td><form action=\"\" method=\"post\">
  <input type=\"hidden\" name=\"examID\" value='".trim($data['examID'][$i],"\r")."'>
  <input type=\"hidden\" name=\"username\" value='".trim($data['username'][$i],"\r")."'>
  <input type=\"hidden\" name=\"questionIDList\" value='".trim($temp,"\r")."'>
  <input type=\"hidden\" name=\"responseList\" value='".trim($data['studentResponses'][$i],"\r")."'>
  <input type=\"hidden\" name=\"possible_points\" value='".trim($data['possiblePoints'][$i],"\r")."'>
  <input name=\"submit\" type=\"submit\" value='Auto Grade' >
  </form></td>
  </tr>
  ";
}

?>
