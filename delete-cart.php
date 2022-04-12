<?php 

$productCode = $_POST["productId"];
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;


$cart = isset($_COOKIE["cart"]) ? $_COOKIE["cart"] : "[]";
$cart = json_decode($cart);

$new_cart = array();
foreach ($cart as $c ) {
    if ($c->productCode != $productCode) {
        array_push($new_cart, $c);
    }
}

setcookie("cart", json_encode($new_cart));
header("Location: pagination.php?page=$page");

?>