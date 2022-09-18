<?php
  if (isset($_POST['submit'])) 
  {
    $example = $_POST['example'];
    $example2 = $_POST['example2'];
    $URL= 'https://afsaccess4.njit.edu/~nk82/middleEnd.php';
    $post_params="example=$example&example2=$example2";
    $ch = curl_init();
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
		echo $result;
  }
  
  else {
        
    echo"<form action=\"\" method=\"post\">";
    echo "Example value: <input name=\"example\" type=\"text\" />";
    echo "Example value 2: <input name=\"example2\" type=\"text\" />";
    echo "<input name=\"submit\" type=\"submit\" />";
    echo "</form>";

  }
?>
