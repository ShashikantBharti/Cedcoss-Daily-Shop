<?php 
require 'config.inc.php';
//require 'add_to_cart.inc.php';

$id = get_safe_value($conn, $_REQUEST['id']);
if(isset($_REQUEST['qty'])) {
    $qty = get_safe_value($conn, $_REQUEST['qty']);
} else {
    $qty = 1;
}
$type = get_safe_value($conn, $_REQUEST['type']);

$cart  = new cart;
if ($type == 'add') {
    $cart -> addProduct($id, $qty);
}
if ($type == 'update') {
    $cart -> updateProduct($id, $qty);
}
if ($type == 'remove') {
    $cart -> removeProduct($id);
}
echo  $cart -> totalProduct();
 
?>