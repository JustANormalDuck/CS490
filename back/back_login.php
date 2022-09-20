<?php
require_once("db.php");

//get username password from jerry
$username = null;
$password = null;

$db = getDB();
if (isset($db)){
    $stmt = $db->prepare("SELECT username, hash, role from Users WHERE username = :username");
    $params = array(":username" => $username);
    $r = $stmt->execute($params);
    echo "DB RETURNED: " . var_export($r, true);
    $e = $stmt->errorInfo();
    if ($e[0] != "00000"){
        echo "Something went wrong with " . $stmt;
    }
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($result && isset($result["hash"]) && isset($result["role"])){
        if (password_verify($password, $result["hash"])){
            if($result["role"] == "teacher"){
                echo "REDIRECT TO TEACHER PAGE";
            } else {
                echo "REDIRECT TO STUDENT PAGE";
            }
        } else {
            echo "There was a validation issue";
        }
    } else {
        echo "Invalid user";
    }
}
?>
