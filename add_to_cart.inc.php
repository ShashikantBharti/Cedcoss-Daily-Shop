<?php 

class cart {
    function addProduct($id, $qty) {
        $_SESSION['CART'][$id]['qty'] = $qty;
    }
    function updateProduct($id, $qty) {
        if (isset($_SESSION['CART'][$id])) {
            $_SESSION['CART'][$id]['qty'] = $qty;
        }
    }
    function removeProduct($id) {
        if (isset($_SESSION['CART'][$id])) {
            unset($_SESSION['CART'][$id]);
        }
    }
    function emptyCart(){
        if (isset($_SESSION['CART'])) {
            unset($_SESSION['CART']);
        }
    }
    function totalProduct() {
        if (isset($_SESSION['CART'])) {
            return count($_SESSION['CART']);
        } else {
            return 0;
        }
    }

}


?>