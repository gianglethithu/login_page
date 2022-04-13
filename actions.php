<?php
include "dbconnect.php";

// add products to cart
if (isset($_POST['addCart'])) {
  // $productId = $_POST['addCart'];
  $conn = mysqli_connect('127.0.0.1', 'root', '', 'salebookonl');
  
  $productCode = $_POST["addCart"];
  $quantity = $_POST["quantity"];

  $cart = isset($_COOKIE["cart"]) ? $_COOKIE["cart"] : "[]";
  $cart = json_decode($cart);

  $result = mysqli_query($conn, "SELECT * FROM books WHERE id = '".$productCode."'");
  $product = mysqli_fetch_object($result);

  array_push($cart, array(
    "productCode" => $productCode,
    "quantity" => $quantity,
    "product" => $product
  ));

  setcookie("cart", json_encode($cart));
}

if (isset($_POST['removeCartItem'])) {
  $productCode = $_POST["removeCartItem"];
  $cart = isset($_COOKIE["cart"]) ? $_COOKIE["cart"] : "[]";
  $cart = json_decode($cart);

  $new_cart = array();
  foreach ($cart as $c) {
    if ($c->productCode != $productCode) {
      array_push($new_cart, $c);
    }
  }

  setcookie("cart", json_encode($new_cart));
}

if (isset($_POST['updateCart'])) {
  $productCode = $_POST["updateCart"];
  $quantity = $_POST["quantity"];

  $cart = isset($_COOKIE["cart"]) ? $_COOKIE["cart"] : "[]";
  $cart = json_decode($cart);

 foreach ($cart as $c ) {
    if ($c->productCode == $productCode) {
        $c->quantity = $quantity;
    }
}

  setcookie("cart", json_encode($cart));
}

