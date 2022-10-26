<?php
require_once("db.php");
//get username exam_id from jerry after test submission and fill grades with default values
$obj = new stdClass();
$obj->username = $_POST['username'];
$obj->testName = $_POST['test_name'];
$obj->examID = $_POST['exam_id'];
$obj->responses = $_POST['student_responses'];
$obj->earnedPoints = "ITANI"; //also default for updated points
$obj->possiblePoints = "ITANI";
$obj->grade = -1;
$obj->comment = "ITANI";
$obj->released = 0;

$db = getDB();
if (isset($db)){
    $stmt = $db->prepare("INSERT INTO Grades(username, exam_id, test_name, student_responses, earned_points, updated_points, possible_points, grade, comments, released) VALUES(:username, :exam_id, :test_name, :responses, :earned, :updated, :possible, :grade, :comment, :released);");
    $params = array(":username" => $obj->username, ":exam_id" => $obj->examID, ":test_name" => $obj->testName, ":responses" => $obj->responses, ":earned" => $obj->earnedPoints, ":updated" => $obj->earnedPoints, ":possible" => $obj->possiblePoints, ":grade" => $obj->grade, ":comment" => $obj->comment, ":released" => $obj->released);
    $r = $stmt->execute($params);
    $e = $stmt->errorInfo();
    if ($e[0] == "00000") {
        $obj->error = "Successfully entered a default grade";
    } else {
        $obj->error = "An error occurred when entering the default grade";
    }
} else {
    $obj->error = "Error setting db";
}

echo json_encode($obj);
?>
