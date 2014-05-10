<?php

$db_host = "localhost";
$db_username = "root";
$db_pass = "";
$db_name = "pentamath";

$name = $_POST['name'];
$rating = $_POST['rating'];
$id = $_POST['id'];


$con = mysqli_connect("$db_host","$db_username","$db_pass", "$db_name") or die("Could not connect to MySQL");

mysqli_query($con,"REPLACE INTO scoreboard (id, name, rating) VALUES ($id, '$name', $rating)");

mysqli_close($con);

?>
