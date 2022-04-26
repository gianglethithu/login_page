<?php 
include 'dbconnect.php';
require_once 'layout/header.php';
require "vendor/predis/predis/autoload.php";
Predis\Autoloader::register();
$redis = new Predis\Client();
$key = 'Products';
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
$page = intval($page);
$num_results_on_page = 5;

if (!$redis->hget($key, $page)) {
    $source = 'MySQL Server';
    $db = new Database();
    $db->select('books', '*', null, null, 'id', " 5");
    $rows = $db->getResult();
    foreach ($rows as $row ) {
        $products[] = $row;
    }
    $redis->hset($key,$page, serialize($products));
    $redis->expire($key, 3600);
} else {
    $source = 'Redis Server';
    $products = unserialize($redis->hget($key, $page));
}

echo $source. ':<br>';
// print_r($products);
$db1 = new Database();
$db1->select('books', '*', null, null, 'id', null);
$total_page = $db1->getResult();
$total_pages = count($total_page);

?>
<div id="load" class="container">
		<div class="row">
			<div class="col-md-6">
				<a href="cart.php" class="btn btn-link">Cart</a>
			</div>
		</div>
		<?php $cart = isset($_COOKIE["cart"]) ? $_COOKIE["cart"] : "[]";
		$cart = json_decode($cart);
		?>
		<h2 style="text-align: left;">Products list</h2> <br>
		<table class="table-hover">
			<tr>
				<th class="col-3">title</th>
				<th class="col-2">image</th>
				<th class="col-1">price</th>
				<th class="col-1"></th>
			</tr>
			<?php 
			// if (file_exists($cache)) {
			// 	include($cache);
			// } else{
				// $output = null;
				// while ($row = $result->fetch_assoc()) :
                
				foreach($products as $row):?>
				<?php $flag = false;
					foreach ($cart as $c ) {
						if ($c->productCode == $row['id']) {
							$flag = true;
							break;
						}
					}
				?>
				<tr>
				<!-- <php 
					$output .= "<td>".$row['title']. "</td>
								<td> <img style='width: 150px' src='".$row['avatar']."'> </td>
								<td>".$row['price']."</td>";
					$handle = fopen($cache,'w');
					fwrite($handle, $output);
					fclose($str);
					echo $output;
				?>
				 -->
					<td><?php echo $row['title']; ?></td>
					<td> <img style="width: 150px" src="<?php echo $row['avatar']; ?>"> </td>
					<td><?php echo $row['price']; ?></td>
					<td>
						<?php if($flag){ ?>
							<form  method="POST">
							<!-- action="delete-cart.php" -->
								<!-- <input type="hidden" name="productId" value="\"> -->
								<input class="remove-cart-item btn btn-danger" type="button" data-id="<?php echo $row['id']; ?>" value="Delete from cart">
							</form>
					<?php } else { ?>
						<form    method="POST">
						<!-- action="add-cart.php"class="add-to-cart" -->
							<!-- <input type="hidden" name="quantity" value="1">
							<input type="hidden" name="productId" value="
							 -->
							<input class="add-to-cart btn btn-primary " type="button" data-id="<?php echo $row['id']; ?>" data-quantity="1" value="Add to cart">
						</form>
						<?php } ?>
					</td>
				</tr>
			<?php  endforeach; ?>
		</table>
		<?php if (ceil($total_pages / $num_results_on_page) > 0) : ?>
			<ul class="pagination">
				<?php
                $link = "product_redis.php?page="; 
                if ($page > 1) : ?>
					<li class="prev"><a class="nav-link" href="<?php echo $link.($page - 1) ?>">Prev</a></li>
				<?php endif; ?>

				<?php if ($page > 3) : ?>
					<li class="start"><a class="nav-link" href="<?php echo $link?>1">1</a></li>
					<li class="dots"><a>...</a></li>
				<?php endif; ?>

				<?php if ($page - 2 > 0) : ?><li class="page"><a class="nav-link" href="<?php echo $link.($page - 2) ?>"><?php echo $page - 2 ?></a></li><?php endif; ?>
				<?php if ($page - 1 > 0) : ?><li class="page"><a class="nav-link" href="<?php echo $link.($page - 1) ?>"><?php echo $page - 1 ?></a></li><?php endif; ?>

				<li class="currentpage"><a class="nav-link" href="<?php echo $link.$page ?>"><?php echo $page ?></a></li>

				<?php if ($page + 1 < ceil($total_pages / $num_results_on_page) + 1) : ?><li class="page"><a class="nav-link" href="<?php echo $link.($page + 1) ?>"><?php echo $page + 1 ?></a></li><?php endif; ?>
				<?php if ($page + 2 < ceil($total_pages / $num_results_on_page) + 1) : ?><li class="page"><a class="nav-link" href="<?php echo $link.($page + 2) ?>"><?php echo $page + 2 ?></a></li><?php endif; ?>

				<?php if ($page < ceil($total_pages / $num_results_on_page) - 2) : ?>
					<li class="dots"><a>...</a></li>
					<li class="end"><a class="nav-link" href="<?php echo $link.ceil($total_pages / $num_results_on_page) ?>"><?php echo ceil($total_pages / $num_results_on_page) ?></a></li>
				<?php endif; ?>

				<?php if ($page < ceil($total_pages / $num_results_on_page)) : ?>
					<li class="next"><a class="nav-link" href="<?php echo $link.($page + 1) ?>">Next</a></li>
				<?php endif; ?>
			</ul>
		<?php endif; ?>
	</div>

	<?php require_once "layout/footer.php" ?>



