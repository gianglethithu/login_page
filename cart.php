<?php
include 'dbconnect.php';
require_once 'layout/header.php';
?>


<div class="container" style="margin-top: 50px;">
    <?php
    $cart = isset($_COOKIE["cart"]) ? $_COOKIE["cart"] : "[]";
    $cart = json_decode($cart);

    $total = 0;

    foreach ($cart as $c_item) {
        $total += $c_item->product->price * $c_item->quantity;
    ?>
        <div class="row">
            <div class="col-md-12">
                <div class="card" style="height: 200px;">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $c_item->product->title; ?></h5>
                        <p class="card-text"><?php echo $c_item->product->price * $c_item->quantity; ?></p>
                        <div style="float: right; margin-left:10px;" class="remove-cart-item btn btn-danger">
                            <input class="remove-cart-item btn btn-danger" type="button" data-id="<?php echo $c_item->productCode; ?>" value="X">
                        </div>
                        <div style="float: right;" >
                            <input type="number" name="" class="cart-qty-single" data-item-id="<?php echo $c_item->productCode; ?>" min="1" value="<?php echo $c_item->quantity; ?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php }
    ?>

    <p><?php echo $total; ?></p>
    <div><a href="pagination.php">Back to products page</a></div>
</div>

<?php require_once 'layout/footer.php'; ?>