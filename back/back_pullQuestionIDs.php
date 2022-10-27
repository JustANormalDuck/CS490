<?php
require_once("db.php");
//pull question id list from Exams table to send to nalby for autograding
$obj = new stdClass();
$obj->examID = $_POST["exam_id"];

$db = getDB();
if (isset($db)){
    $stmt = $db->prepare("SELECT question_id_list from Exams WHERE id = :examID;");
    $params = array(":examID" => $obj->examID);
    $r = $stmt->execute($params);
    $e = $stmt->errorInfo();
    if ($e[0] != "00000"){
        $obj->debug = "Something went wrong with error code " . $e[0];
    }
    $question = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (count($question) == 1){
        foreach ($question as $q){
            $obj->questionIDList = $q["question_id_list"];
            $obj->error = "Question id list successfully returned";
        }
    } else {
        $obj->error = "No question id list returned";
    }
} else {
    $obj->error = "Error setting db";
}

echo json_encode($obj);
?>