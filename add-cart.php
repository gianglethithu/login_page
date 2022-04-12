<?php 

include 'dbconnect.php';

$conn = mysqli_connect('127.0.0.1', 'root', '', 'salebookonl');
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;

$quantity = $_POST["quantity"];
$productCode = $_POST["productId"];


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
header("location: pagination.php?page=$page");

?>