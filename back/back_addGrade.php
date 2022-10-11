<?php
require_once("db.php");
//get username exam_id earned_points possible_points grade from nalby autograder
$obj = new stdClass();
$obj->username = $_POST['username'];
$obj->examID = $_POST['exam_id'];
$obj->earnedPoints = $_POST['earned_points'];
$obj->possiblePoints = $_POST['possible_points'];
$obj->grade = $_POST['grade'];
$obj->comment = "Add comments here";
$obj->release = 0;

$db = getDB();
if (isset($db)) {
    $stmt = $db->prepare("INSERT INTO Grades(username, exam_id, earned_points, possible_points, grade, comments, release) VALUES(:username, :exam_id, :earned, :possible, :grade, :comment, :release);");
    $params = array(":username" => $obj->username, ":exam_id" => $obj->examID, ":earned" => $obj->earnedPoints, ":possible" => $obj->possiblePoints, ":grade" => $obj->comment, ":release" => $obj->release);
    $r = $stmt->execute($params);
    $e = $stmt->errorInfo();
    if ($e[0] == "00000") {
        $obj->error = "Successfully entered a grade";
    } else {
        $obj->error = "An error occurred when entering the grade";
    }
} else {
    $obj->error = "Error setting db";
}

echo json_encode($obj);
?>
