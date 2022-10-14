<?php
require_once("db.php");
//get username exam_id earned_points possible_points grade comments from nalby autograder
$obj = new stdClass();
$obj->username = $_POST['username'];
$obj->examID = $_POST['exam_id'];
$obj->earnedPoints = $_POST['earned_points']; //also default for updated points
$obj->possiblePoints = $_POST['possible_points'];
$obj->grade = $_POST['grade'];
$obj->comments = $_POST['comments'];

$db = getDB();
if (isset($db)){
    $stmt = $db->prepare("UPDATE Grades SET earned_points = :earned, updated_points = :earned, possible_points = :possible, grade = :grade, comments = :comments WHERE username = :username and exam_id = :examID;");
    $params = array(":username" => $obj->username, ":exam_id" => $obj->examID, ":earned" => $obj->earnedPoints, ":possible" => $obj->possiblePoints, ":grade" => $obj->grade, ":comments" => $obj->comments);
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
