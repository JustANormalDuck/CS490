<?php
$obj = new stdClass();
$obj->name= $_POST['example'];
$obj->email= $_POST['example2'];
$myJSON=json_encode($obj);
echo $myJSON
?>
