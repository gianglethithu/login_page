<?php 
 include "dbconnect.php";
 $conn = mysqli_connect('127.0.0.1', 'root', '', 'salebookonl');
//add products to cart

 if(isset($_POST['addCart'])){
   
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
  
}
// remove products from cart
if(isset($_POST['removeCartItem'])){
    $p_id = $_POST['removeCartItem'];
    
    if($_COOKIE['cart_count'] == '1'){
        setcookie('cart_count','',time() - (180),'/','','',TRUE);
        setcookie('user_cart','',time() - (180),'/','','',TRUE);
    }else{
        if(isset($_COOKIE['user_cart'])){
            $user_cart = json_decode($_COOKIE['user_cart']);
            if(is_object($user_cart)){
                $user_cart = get_object_vars($user_cart);
            }
            if (($key = array_search($p_id, $user_cart)) !== false) {
                unset($user_cart[$key]);
            }
        }
        $cart_count = count($user_cart);
        $u_cart = json_encode($user_cart);

        if(setcookie('user_cart',$u_cart,time() + (180),'/','','',TRUE)){
            setcookie('cart_count',$cart_count,time() + (180),'/','','',TRUE);
            echo 'cookie set successfully';
        }else{
            echo 'false';
        }
    }
}



?>