<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link href="styles.css" rel="stylesheet" type="text/css"/>
    <title> Customer Directory </title>
  </head>
  <body>
    <a href="assignment3.html"> Home </a> <br>
    <?php
      $servername = "sql1.njit.edu";
      $username = "jz565";
      $password = "@MTL13618kz";
      $dbname = "jz565";

      $con = mysqli_connect($servername,$username,$password,$dbname);
      if (mysqli_connect_errno())
      {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
      }
    ?>
    <br>
    <table>
    <th>First Name</th>
    <th>Last Name</th>
    <th>ID</th>
    <?php
      $sql = "SELECT * FROM customer_record";
      $result = $con->query($sql);
      if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
          echo "<tr>";
          echo "<td>" . $row['customer_fn'] . "</td>";
          echo "<td>" . $row['customer_ln'] . "</td>";
          echo "<td>" . $row['customer_id'] . "</td>";
          echo "</tr>";
        }
      }
    ?>
  </table>
  </body>
</html>
