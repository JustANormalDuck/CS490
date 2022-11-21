<!DOCTYPE html>
<html>
    <head>
        <title> Date Range Test </title>
    </head>
    <body>
        <?php
            $serverName = "sql1.njit.edu";
            $username = "jz565";
            $password = "@MTL13618kz";
            $dbName = "jz565";
            $connect = mysqli_connect($serverName, $username, $password, $dbName);
            if (mysqli_connect_errno()){
                echo "Failed to connect to MySQL: " . mysqli_connect_error();
            }

            $id = $_GET['id'];
            $date1 = $_GET['date1'];
            $date2 = $_GET['date2'];

            if(isset($_GET['go'])){
                $sql = "SELECT * FROM date_range WHERE date_time BETWEEN " . $date1 . " AND " . $date2;
            }
            
        ?>

    <form action="date_range.php" method="GET">
        <input type="Date" name="date1">
        <input type="Date" name="date2"> 
        <input type="submit" name="go" value="Go">
    </form>

    <table>
        <th> ID </th>
        <th> Date</th>
        <?php
            $result = $connect->query($sql);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                  echo "<tr>";
                  echo "<td>" . $row['id'] . "</td>";
                  echo "<td>" . $row['date_time'] . "</td>";
                  echo "</tr>";
                }
          }
        ?>
    </table>
    </body>
</html>
