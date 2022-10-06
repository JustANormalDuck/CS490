<?php
require_once("db.php");
//pull all questions from Questions table to send to jerry for exam creation
$obj = new stdClass();

$db = getDB();
if (isset($db)){
    //need to change to greater than 4 that way it doesnt pull the dummy questions
    $stmt = $db->prepare("SELECT * from Questions WHERE id > 0");
    $stmt->execute();
    $e = $stmt->errorInfo();
    if ($e[0] != "00000"){
        $obj->error = "Something went wrong with " . $stmt;
    }
    $questionsQuery = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (count($questionsQuery) > 0){
        $ids = array();
        $difficulties = array();
        $topics = array();
        $questions = array();
        foreach ($questionsQuery as $q){
            array_push($ids, $q["id"]);
            array_push($difficulties, $q["difficulty"]);
            array_push($topics, $q["topic"]);
            array_push($questions, $q["question"]);
        }
        $obj->id = $ids;
        $obj->difficulty = $difficulties;
        $obj->topic = $topics;
        $obj->question = $questions;
        $obj->error = "Questions successfully returned";
    } else {
        $obj->error = "No questions returned";
    }
} else {
    $obj->error = "Error setting db";
}

echo json_encode($obj);
?>
