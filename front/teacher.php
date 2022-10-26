<?php	
	require_once 'teacherheader.php';
	echo "TEACHER LANDING PAGE";
  echo '</br>';
  echo '</br>';
  
  echo 'Welcome, ';
  echo $_SESSION["username"];

  echo '</br>';

  echo 'Your role is ';
  echo $_SESSION["role"];
?>

<head>
  <title>Teacher Landing Page</title>
</head>