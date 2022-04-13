<?php
include 'dbconnect.php';
require_once 'layout/header.php';
require 'cart-item.php';

?>


<div class="container" style="margin-top: 50px;">
    <?php
    $cart = isset($_COOKIE["cart"]) ? $_COOKIE["cart"] : "[]";
    $cart = json_decode($cart);

    $total = 0;

    foreach ($cart as $c) {
        $total += $c->product->price * $c->quantity;
    ?>
        <div class="row">
            <div class="col-md-12">
                <div class="card" style="height: 200px;">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $c->product->title; ?></h5>
                        <p class="card-text"><?php echo $c->product->price * $c->quantity; ?></p>
                        <div style="float: right; margin-left:10px;" class="remove-cart-item btn btn-danger">
                            <input class="remove-cart-item btn btn-danger" type="button" data-id="<?php echo $c->productCode; ?>" value="X">
                        </div>
                        <div style="float: right;" class="update-cart">
                            <input type="hidden" name="update">
                            <input type="number" name="quantity[]" min="1" value="<?php echo $c->quantity; ?>">
                        </div>
                        <!-- <form class="remove-cart-item" method="POST" style="float: right; margin-left:10px;"> -->
                        <!-- action="delete-cart.php" -->
                        <!-- <input type="hidden" name="productId" value="">
                            <button type="submit" class="btn btn-danger" value="Delete from cart">X</button>
                        </form> -->
                        <!-- <form method="POST" style="float: right; margin-left:10px;"> -->
                            <!-- action="delete-cart.php" -->
                            <!-- <input type="hidden" name="productId" value=""> -->
                            <!-- <input id="remove-cart-item" type="button" data-id="" class="btn btn-danger" value="Delete from cart"> -->

                        <!-- </form> -->
                        
                    </div>
                </div>
            </div>
        </div>
    <?php }
    ?>
    <!-- <form class="update-cart" method="POST" style="float: right;">
        <!-- action="update-cart.php" 
        <input type="number" class="update-cart-quantity<php echo $c->productCode; >" name="quantity" min="1" placeholder="<php echo $c->quantity; ?>">
        <input type="hidden" class="productCode" name="productId" value="<php echo $c->productCode; ?>">
        <input type="submit" class="btn btn-warning" value="Update">
    </form> -->
    <p><?php echo $total; ?></p>
</div>

<?php require_once 'layout/footer.php'; ?>