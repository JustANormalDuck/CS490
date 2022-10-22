<?php
require_once("db.php");
//pull all exams from Exams table to send to jerry for exam selection
$obj = new stdClass();
$obj->username = $_POST["username"];

$db = getDB();
if (isset($db)){
    //need to change to greater than 3 that way it doesnt pull the dummy exams
    $stmt = $db->prepare("SELECT id, test_name, question_num_list, question_id_list from Exams WHERE id > 0 and id not in (Select exam_id from Grades where username = :username);");
    $params = array(":username" => $obj->username);
    $r = $stmt->execute($params);
    $e = $stmt->errorInfo();
    if ($e[0] != "00000"){
        $obj->debug = "Something went wrong with error code " . $e[0];
    }
    $exams = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (count($exams) > 0){
        $ids = array();
        $names = array();
        $questions = array();
        $questionIDs = array();
        foreach ($exams as $ee){
            array_push($ids, $ee["id"]);
            array_push($names, $ee["test_name"]);
            array_push($questions, $ee["question_num_list"][strlen($ee["question_num_list"])-1]);
            array_push($questionIDs, $ee["question_id_list"]);
        }
        $obj->id = $ids;
        $obj->testName = $names;
        $obj->numQuestions = $questions;
        $obj->qIDs = $questionIDs;
        $obj->error = "Exams successfully returned";
    } else {
        $obj->error = "No exams returned";
    }
} else {
    $obj->error = "Error setting db";
}

echo json_encode($obj);
?>
