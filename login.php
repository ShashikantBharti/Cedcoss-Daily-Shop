<?php 
require 'config.inc.php';

$email = get_safe_value($conn, $_REQUEST['email_id']);
$pasword = get_safe_value($conn, $_REQUEST['login_password']);
$sql = "SELECT * FROM `users` WHERE `email` = '$email' AND `password` = '$pasword'";
$result = $conn -> query($sql) or die("Query Failed !!!.");
if ($result -> num_rows > 0) {
    $row = $result -> fetch_assoc();
    $_SESSION['USER_ID'] = $row['id'];
    $_SESSION['USER_NAME'] = $row['name'];
    echo 1;
} else {
    echo 0;
}
?>