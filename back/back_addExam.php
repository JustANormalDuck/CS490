<?php
require_once("db.php");
//get test_name question_nums points question_ids from jerry
$obj = new stdClass();
$obj->testName = $_POST['test_name'];
$obj->questionNumList = $_POST['question_num_list'];
$obj->questionPointList = $_POST['question_point_list'];
$obj->questionIdList = $_POST['question_id_list'];

$db = getDB();
if (isset($db)) {
    $stmt = $db->prepare("INSERT INTO Exams(test_name, question_num_list, question_point_list, question_id_list) VALUES(:name, :nums, :points, :ids);");
    $params = array(":name" => $obj->testName, ":nums" => $obj->questionNumList, ":points" => $obj->questionPointList, ":ids" => $obj->questionIdList);
    $r = $stmt->execute($params);
    $e = $stmt->errorInfo();
    if ($e[0] == "00000") {
        $obj->error = "Successfully created exam";
    } else {
        $obj->error = "An error occurred when creating the exam";
    }
} else {
    $obj->error = "Error setting db";
}

echo json_encode($obj);
?>
