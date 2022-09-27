<?php
  if (isset($_POST['submit'])) 
  {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $URL= 'https://afsaccess4.njit.edu/~nk82/middle_login.php';
    $post_params="username=$username&password=$password";
    $ch = curl_init();
    $options = array(CURLOPT_URL => $URL,
               CURLOPT_HTTPHEADER =>
         array('Content-type:application/x-www-form-urlencoded'),
         CURLOPT_RETURNTRANSFER => TRUE,
         CURLOPT_POST => TRUE,
         CURLOPT_POSTFIELDS => $post_params);
    curl_setopt_array($ch, $options);
    $result = curl_exec($ch);
    curl_close($ch);
    $decodedData = json_decode($result, true);
    if ($decodedData["role"] == "T"){
      die(header('Location: teacher.php'));
    }
    else if ($decodedData["role"] == "S"){
      die(header('Location: student.php'));
    }
    else if ($decodedData["role"] == "I" || $decodedData["role"] == "V"){
      echo "Invalid password or username";
    }
    else{
      echo "Unknown Error";
    }
    echo "<form action=\"\" method=\"post\">";
    echo "Username: <input name=\"username\" type=\"text\" />";
    echo "Password: <input name=\"password\" type=\"password\" />";
    echo "<input name=\"submit\" type=\"submit\" />";
    echo "</form>";
  }
  
  else {
        
    echo "<form action=\"\" method=\"post\">";
    echo "Username: <input name=\"username\" type=\"text\" />";
    echo "Password: <input name=\"password\" type=\"password\" />";
    echo "<input name=\"submit\" type=\"submit\" />";
    echo "</form>";

  }
?>
