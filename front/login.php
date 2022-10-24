<?php
  session_start();
  if (isset($_POST['submit'])) 
  {
    ob_start();
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
      $_SESSION['username'] = $_POST['username'];
      $_SESSION['role'] = 'T';
      die(header('Location: teacher.php'));
      exit();
    }
    else if ($decodedData["role"] == "S"){
      $_SESSION['username'] = $_POST['username'];
      $_SESSION['role'] = 'S';
      die(header('Location: student.php'));
      exit();
    }
    else if ($decodedData["role"] == "I" || $decodedData["role"] == "V"){
      echo '<p class="sign" align="center">Invalid Username or Password</p>';
    }
    else{
      echo "Unknown Error";
    }
    echo '<div class="main">';
    echo '<p class="sign" align="center">Sign in</p>';
    echo "<form class='form1' action=\"\" method=\"post\">";
    echo "<input class='un ' type='text' align='center' name=\"username\" type=\"text\" placeholder='Username'/>";
    echo "<input class='pass' type='password' align='center' name=\"password\" type=\"password\" placeholder='Password'/>";
    echo "<input class='submit' name=\"submit\" type=\"submit\" align='center'/>";
    echo "</form>";
    echo "</div>";
  }
  
  else {
    echo '<div class="main">';
    echo '<p class="sign" align="center">Sign in</p>';
    echo "<form class='form1' action=\"\" method=\"post\">";
    echo "<input class='un ' type='text' align='center' name=\"username\" type=\"text\" placeholder='Username'/>";
    echo "<input class='pass' type='password' align='center' name=\"password\" type=\"password\" placeholder='Password'/>";
    echo "<input class='submit' name=\"submit\" type=\"submit\" align='center'/>";
    echo "</form>";
    echo "</div>";

  }
?>

<head>
  <link rel="stylesheet" href="css/style.css">
  <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="logincss.css">
  <title>Login</title>
</head>