<?php
require_once("db.php");
//pull grades from Grades table to send to jerry for release/viewing
$obj = new stdClass();
$obj->username = $_POST["username"];
$role = $_POST["role"];

$db = getDB();
if (isset($db)){
    if ($role == "T"){
        $stmt = $db->prepare("SELECT * from Grades;");
        $stmt->execute();
    } else {
        $stmt = $db->prepare("SELECT username, exam_id, test_name, student_responses, earned_points, updated_points, possible_points, grade, comments from Grades WHERE username = :username and released = 1;");
        $params = array(":username" => $obj->username);
        $r = $stmt->execute($params);
    }
    $e = $stmt->errorInfo();
    if ($e[0] != "00000"){
        $obj->debug = "Something went wrong with error code " . $e[0];
    }
    $grades = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (count($grades) > 0){
        $usernames = array();
        $ids = array();
        $names = array();
        $responses = array();
        $earned = array();
        $updated = array();
        $possible = array();
        $scores = array();
        $teacherComments = array();
        foreach ($grades as $g){
            array_push($usernames, $g["username"]);
            array_push($ids, $g["exam_id"]);
            array_push($names, $g["test_name"]);
            array_push($responses, $g["student_responses"]);
            array_push($earned, $g["earned_points"]);
            array_push($updated, $g["updated_points"]);
            array_push($possible, $g["possible_points"]);
            array_push($scores, $g["grade"]);
            array_push($teacherComments, $g["comments"]);
        }
        $obj->username = $usernames;
        $obj->examID = $ids;
        $obj->testName = $names;
        $obj->studentResponses = $responses;
        $obj->earnedPoints = $earned;
        $obj->updatedPoints = $updated;
        $obj->possiblePoints = $possible;
        $obj->grade = $scores;
        $obj->comments = $teacherComments;
        $obj->error = "Grades successfully returned";
    } else {
        $obj->error = "No grades returned";
    }
} else {
    $obj->error = "Error setting db";
}

echo json_encode($obj);
?>
