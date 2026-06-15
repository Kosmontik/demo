<?php 
session_start();
error_reporting (E_ALL);
$localhost='localhost';
$user='root';
$password='';
$bd='demo';
$link = mysqli_connect($localhost,$user,$password,$bd);
?>
