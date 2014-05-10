<?php

$db_host = "localhost";
$db_username = "root";
$db_pass = "";
$db_name = "pentamath";

$con = mysqli_connect("$db_host","$db_username","$db_pass", "$db_name") or die("Could not connect to MySQL");

$result = mysqli_query($con,"SELECT * FROM scoreboard");

while($row = mysqli_fetch_array($result)) {
	echo $row['name'] . " " . $row['rating'];
	echo "<br />";
}

mysqli_close($con);

?>
