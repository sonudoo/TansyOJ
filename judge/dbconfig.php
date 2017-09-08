<?php

// Replace your database servername, username, password, database name here
$conn = mysqli_connect("your_mysql_server_here","your_database_username_here","your_mysql_password_here","your_database_name_here");
if(!$conn){
	die("An unknown error occured while connecting to the database");
}
?>
