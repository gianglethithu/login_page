<?php

$host = '127.0.0.1';
$dbname = 'laravelblog';
$username = 'root';
$password = '';

  try {
    $conn = mysqli_connect($host, $username, $password,$dbname);  
  } catch (PDOException $pe ) {
    die("failed" . $pe->getMessage());
  }
