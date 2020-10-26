<?php 

session_start();
unset($_SESSION['USERNAME']);
session_destroy();
header('location: ./');

?>