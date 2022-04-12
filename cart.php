<?php 
include 'dbconnect.php';
require_once 'layout/header.php';
?>

<div class="container" style="margin-top: 50px;">
<?php 
    $cart = isset($_COOKIE["cart"]) ? $_COOKIE["cart"] : "[]";
    $cart = json_decode($cart);

    $total = 0;

    foreach ($cart as $c ) {
        $total += $c->product->price * $c->quantity;
        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="card" style="height: 200px;">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $c->product->title; ?></h5>
                        <p class="card-text"><?php echo $c->product->price * $c->quantity;?></p>

                        <form action="delete-cart.php" method="POST" style="float: right; margin-left:10px;">
                            <input type="hidden" name="productId" value="<?php echo $c->productCode; ?>">
                            <button type="submit" class="btn btn-danger" value="Delete from cart">X</button>
                        </form>

                        <form action="update-cart.php" method="POST" style="float: right;">
                            <input type="number" name="quantity" min="1" value="<?php echo $c->quantity; ?>">
							<input type="hidden" name="productId" value="<?php echo $c->productCode; ?>">
							<input type="submit" class="btn btn-warning" value="Update">
						</form>
                    </div>
            </div>
            </div>
        </div>
<?php } 
?>
<p><?php echo $total;?></p>
</div>

<?php require_once 'layout/footer.php'; ?>