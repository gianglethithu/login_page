<?php 

$productCode = $_POST["productId"];
$quantity = $_POST["quantity"];

$cart = isset($_COOKIE["cart"]) ? $_COOKIE["cart"] : "[]";
$cart = json_decode($cart);

foreach ($cart as $c ) {
    if ($c->productCode == $productCode) {
        $c->quantity = $quantity;
    }
}

setcookie("cart", json_encode($cart));
header("location: cart.php");

?>