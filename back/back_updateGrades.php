<?php
require_once("db.php");
//update Grades table for grades comments release/viewing
$obj = new stdClass();
$obj->username = $_POST["username"];
$obj->examID = $_POST["exam_id"];
$obj->earnedPoints = $_POST["earned_points"];
$obj->grade = $_POST["grade"];
$obj->comments = $_POST["comments"];

$db = getDB();
if (isset($db)){
    $stmt = $db->prepare("UPDATE Grades SET earned_points = :earnedPoints, grade = :grade, comments = :comments, released = 1 WHERE username = :username and exam_id = :examID;");
    $params = array(":earnedPoints" => $obj->earnedPoints, ":grade" => $obj->grade, ":comments" => $obj->comments, ":username" => $obj->username, ":examID" => $obj->examID);
    $r = $stmt->execute($params);
    $e = $stmt->errorInfo();
    if ($e[0] == "00000") {
        $obj->error = "Successfully updated grade";
    } else {
        $obj->error = "An error occurred when updating the grade";
    }
} else {
    $obj->error = "Error setting db";
}

echo json_encode($obj);
?>
