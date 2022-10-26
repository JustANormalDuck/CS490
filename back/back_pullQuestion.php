<?php
require_once("db.php");
//pull difficulty topic question from Questions table to send to jerry for pulling for exam
$obj = new stdClass();
$obj->questionID = $_POST['question_id'];

$db = getDB();
if (isset($db)){
    $stmt = $db->prepare("SELECT difficulty, topic, question from Questions WHERE id = :question_id;");
    $params = array(":question_id" => $obj->questionID);
    $r = $stmt->execute($params);
    $e = $stmt->errorInfo();
    if ($e[0] != "00000"){
        $obj->debug = "Something went wrong with error code " . $e[0];
    }
    $question = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (count($question) == 1){
        foreach ($question as $q){
            $obj->difficulty = $q["difficulty"];
            $obj->topic = $q["topic"];
            $obj->question = $q["question"];
            $obj->error = "Question successfully returned";
        }
    } else {
        $obj->error = "Error finding question";
    }
} else {
    $obj->error = "Error setting db";
}

echo json_encode($obj);
?>
