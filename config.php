<?php


  $host = 'localhost'; // or IP address of your MySQL server
  $username = 'root'; // MySQL username
  $password = ''; // MySQL password
  $database = 'csbc_ct_01_2023_cat_change'; // The database you want to connect to
  $port = 3306; // Port number, default is 3306
  
  // Create connection
  $dbhandle = mysqli_connect($host, $username, $password, $database, $port)or die("Unable to connect to MySQL");

?>