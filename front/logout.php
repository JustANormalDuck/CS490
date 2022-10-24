<?php
	session_start();
	unset($_SESSION['username']);
  	unset($_SESSION['role']);

  	die(header('Location: login.php'));
?>