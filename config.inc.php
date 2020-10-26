<?php 
session_start();
$conn = new mysqli('localhost', 'root', '', 'dailyshop') or die("Connection Failed !!!.");

define('SERVER_PATH', $_SERVER['DOCUMENT_ROOT'].'/cedcoss/Daily-Shop/');
define('SITE_PATH', 'http://127.0.0.1/cedcoss/Daily-Shop/');

define('PRODUCT_IMAGE_SERVER_PATH', SERVER_PATH.'media/products/');
define('PRODUCT_IMAGE_SITE_PATH', SITE_PATH.'media/products/');

include_once('functions.inc.php');
?>