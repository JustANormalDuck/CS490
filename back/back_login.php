<?php
require_once("db.php");
//get username password from jerry
$obj = new stdClass();
$obj->username = $_POST['username'];
$obj->password = $_POST['password'];

$db = getDB();
if (isset($db)){
    $stmt = $db->prepare("SELECT username, hash, role from Users WHERE username = :username");
    $params = array(":username" => $obj->username);
    $r = $stmt->execute($params);
    $obj->error = "DB RETURNED: " . var_export($r, true);
    $e = $stmt->errorInfo();
    if ($e[0] != "00000"){
        $obj->error = "Something went wrong with " . $stmt;
    }
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($result && isset($result["hash"]) && isset($result["role"])){
        if (password_verify($obj->password, $result["hash"])){
            if($result["role"] == "teacher"){
                $obj->role = "T"; //T for teacher
            } else {
                $obj->role = "S"; //S for student
            }
        } else {
            $obj->role = "V"; //V for validation issue
        }
    } else {
        $obj->role = "I"; //I for invalid user
    }
} else {
    $obj->error = "Error setting db";
}

echo json_encode($obj);
?>
