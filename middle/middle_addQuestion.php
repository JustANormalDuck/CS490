<?php
$difficulty = $_POST['difficulty'];
$topic = $_POST['topic'];
$question = $_POST['question'];
$funcName = $_POST['function'];
$case1 = $_POST['case1'];
$case2 = $_POST['case2'];
$konstraint=$_POST['konstraint']
$post_params="difficulty=$difficulty&function=$funcName&topic=$topic&question=$question&case1=$case1&case2=$case2&konstraint=$konstraint";
if (isset($_POST['case3']))
{
    $post_params.="&case3=$case3";
} 
if (isset($_POST['case4']))
{
    $post_params.="&case4=$case4";
} 
if (isset($_POST['case5']))
{
    $post_params.="&case5=$case5";
} 
$URL= 'https://afsaccess4.njit.edu/~jmf64/back_addQuestion.php';
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
