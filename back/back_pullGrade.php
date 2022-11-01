<?php
require_once("db.php");
//pull grade from Grades table to send to jerry for updating
$obj = new stdClass();
$obj->username = $_POST["username"];
$obj->examID = $_POST["exam_id"];

$db = getDB();
if (isset($db)){
    $stmt = $db->prepare("SELECT username, exam_id, test_name, student_responses, earned_points, updated_points, possible_points, grade, auto_comments from Grades WHERE username = :username and exam_id = :exam_id;");
    $params = array(":username" => $obj->username, ":exam_id" => $obj->examID);
    $r = $stmt->execute($params);
    $e = $stmt->errorInfo();
    if ($e[0] != "00000"){
        $obj->debug = "Something went wrong with error code " . $e[0];
    }
    $grade = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (count($grade) == 1){
        foreach ($grade as $g){
            $obj->username = $g["username"];
            $obj->examID = $g["exam_id"];
            $obj->testName = $g["test_name"];
            $obj->studentResponses = $g["student_responses"];
            $obj->earnedPoints = $g["earned_points"];
            $obj->updatedPoints = $g["updated_points"];
            $obj->possiblePoints = $g["possible_points"];
            $obj->grade = $g["grade"];
            $obj->comments = $g["auto_comments"];
            $obj->error = "Grade successfully returned";
        }
    } else {
        $obj->error = "No grade returned";
    }
} else {
    $obj->error = "Error setting db";
}

echo json_encode($obj);
?>
