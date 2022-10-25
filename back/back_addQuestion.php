<?php
require_once("db.php");
//get difficulty topic question from jerry
$obj = new stdClass();
$obj->difficulty = $_POST['difficulty'];
$obj->topic = $_POST['topic'];
$obj->question = $_POST['question'];
$obj->funcName = $_POST['function'];
$obj->case1 = $_POST['case1'];
$obj->case2 = $_POST['case2'];
if (!isset($_POST['case3'])){
    $obj->case3 = "ITANI";
} else {
    $obj->case3 = $_POST['case3'];
}
if (!isset($_POST['case4'])){
    $obj->case4 = "ITANI";
} else {
    $obj->case4 = $_POST['case4'];
}
if (!isset($_POST['case5'])){
    $obj->case5 = "ITANI";
} else {
    $obj->case5 = $_POST['case5'];
}

$db = getDB();
if (isset($db)) {
    $stmt = $db->prepare("INSERT INTO Questions(difficulty, topic, question, func_name, case1, case2, case3, case4, case5) VALUES(:difficulty, :topic, :question, :func_name, :case1, :case2, :case3, :case4, :case5);");
    $params = array(":difficulty" => $obj->difficulty, ":topic" => $obj->topic, ":question" => $obj->question, ":func_name" => $obj->funcName, ":case1" => $obj->case1, ":case2" => $obj->case2, ":case3" => $obj->case3, ":case4" => $obj->case4, ":case5" => $obj->case5);
    $r = $stmt->execute($params);
    $e = $stmt->errorInfo();
    if ($e[0] == "00000") {
        $obj->error = "Successfully entered question";
    } else {
        $obj->error = "An error occurred when inserting the question";
    }
} else {
    $obj->error = "Error setting db";
}

echo json_encode($obj);
?>
