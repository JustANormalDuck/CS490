<?php
require_once 'teacherheader.php';
if (isset($_POST['submit'])) 
  {
    echo "Grades Submitted";
  }
else
{
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

for($i=0;$i<sizeof($data['examID']);$i++)
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
    <td><form action=\"https://afsaccess4/~nk82/middle_autoGrade.php\" method=\"post\">
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
}
?>

<head>
  <title>Autograde</title>
</head>
