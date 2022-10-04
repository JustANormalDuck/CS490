<?php
require_once("db.php");
//get difficulty topic question from jerry
$obj = new stdClass();
$obj->difficulty = $_POST['difficulty'];
$obj->topic = $_POST['topic'];
$obj->question = $_POST['question'];

$db = getDB();
if (isset($db)) {
    $stmt = $db->prepare("INSERT INTO Questions(difficulty, topic, question) VALUES(:difficulty, :topic, :question);");
    $params = array(":difficulty" => $obj->difficulty, ":topic" => $obj->topic, ":question" => $obj->question);
    $r = $stmt->execute($params);
    $e = $stmt->errorInfo();
    if ($e[0] == "00000") {
        $obj->error = "Successfully entered question";
    } else {
        $obj->error = "An error occurred when inserting the question";
    }
} else {
    $obj->error = "Error setting db";
}

echo json_encode($obj);
?>
