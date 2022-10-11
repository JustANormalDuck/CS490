<?php
require_once("db.php");
//pull function name and all test cases from Questions table to send to nalby for autograde comparisons
$obj = new stdClass();
$obj->questionID = $_POST['question_id'];

$db = getDB();
if (isset($db)){
    $stmt = $db->prepare("SELECT func_name, case1, case2, case3, case4, case5 from Questions WHERE id = :question_id;");
    $params = array(":question_id" => $obj->questionID);
    $r = $stmt->execute($params);
    $e = $stmt->errorInfo();
    if ($e[0] != "00000"){
        $obj->error = "Something went wrong with " . $stmt;
    }
    $cases = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (count($cases) == 1){
        foreach ($cases as $c){
            $obj->func_name = $c["func_name"];
            $obj->case1 = $c["case1"];
            $obj->case2 = $c["case2"];
            $obj->case3 = $c["case3"];
            $obj->case4 = $c["case4"];
            $obj->case5 = $c["case5"];
            $obj->error = "Test cases successfully returned";
        }
    } else {
        $obj->error = "Error finding test cases";
    }
} else {
    $obj->error = "Error setting db";
}

echo json_encode($obj);
?>
