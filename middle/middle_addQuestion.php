<?php
$difficulty = $_POST['difficulty'];
$topic = $_POST['topic'];
$question = $_POST['question'];
$funcName = $_POST['function'];
$case1 = $_POST['case1'];
$case1=str_replace('%','%25',$case1); 
$case1=str_replace('+','%2b',$case1); 
$case2 = $_POST['case2'];
$case2=str_replace('%','%25',$case2); 
$case2=str_replace('+','%2b',$case2); 
$konstraint=$_POST['konstraint'];
$post_params="difficulty=$difficulty&function=$funcName&topic=$topic&question=$question&case1=$case1&case2=$case2";
if (isset($_POST['konstraint']));
{ 
    $temp=$_POST['konstraint'];
    $post_params.="&konstraint=$temp";
}
if (isset($_POST['case3']))
{
    $temp=$_POST['case3'];
    $temp=str_replace('%','%25',$temp); 
    $temp=str_replace('+','%2b',$temp);
    $post_params.="&case3=$temp";
    
} 
if (isset($_POST['case4']))
{
    $temp=$_POST['case4'];
    $temp=str_replace('%','%25',$temp); 
    $temp=str_replace('+','%2b',$temp);
    $post_params.="&case4=$temp";
} 
if (isset($_POST['case5']))
{
    $temp=$_POST['case5'];
    $temp=str_replace('%','%25',$temp); 
    $temp=str_replace('+','%2b',$temp);
    $post_params.="&case5=$temp";
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
