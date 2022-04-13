<?php
include 'dbconnect.php';
// $db = new Database();
// $total_pages = $db->select('books','*',null ,null,null,null)->num_rows;
// Below is optional, remove if you have already connected to your database.
$mysqli = mysqli_connect('127.0.0.1', 'root', '', 'salebookonl');

// Get the total number of records from our table "students".
$total_pages = $mysqli->query('SELECT * FROM books')->num_rows;

// Check if the page number is specified and check if it's a number, if not return the default page number which is 1.
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;

// Number of results to show on each page.
$num_results_on_page = 5;


if ($stmt = $mysqli->prepare('SELECT * FROM books ORDER BY id LIMIT ?,?')) {
	// Calculate the page to get the results we need from our table.
	$calc_page = ($page - 1) * $num_results_on_page;
	$stmt->bind_param('ii', $calc_page, $num_results_on_page);
	$stmt->execute();
	// Get the results...
	$result = $stmt->get_result();

?>
	<?php require_once "layout/header.php" ?>

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
			<?php while ($row = $result->fetch_assoc()) : ?>
				<?php $flag = false;
					foreach ($cart as $c ) {
						if ($c->productCode == $row['id']) {
							$flag = true;
							break;
						}
					}
				?>
				<tr>
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
			<?php endwhile; ?>
		</table>
		<?php if (ceil($total_pages / $num_results_on_page) > 0) : ?>
			<ul class="pagination">
				<?php if ($page > 1) : ?>
					<li class="prev"><a class="nav-link" href="pagination.php?page=<?php echo $page - 1 ?>">Prev</a></li>
				<?php endif; ?>

				<?php if ($page > 3) : ?>
					<li class="start"><a class="nav-link" href="pagination.php?page=1">1</a></li>
					<li class="dots"><a>...</a></li>
				<?php endif; ?>

				<?php if ($page - 2 > 0) : ?><li class="page"><a class="nav-link" href="pagination.php?page=<?php echo $page - 2 ?>"><?php echo $page - 2 ?></a></li><?php endif; ?>
				<?php if ($page - 1 > 0) : ?><li class="page"><a class="nav-link" href="pagination.php?page=<?php echo $page - 1 ?>"><?php echo $page - 1 ?></a></li><?php endif; ?>

				<li class="currentpage"><a class="nav-link" href="pagination.php?page=<?php echo $page ?>"><?php echo $page ?></a></li>

				<?php if ($page + 1 < ceil($total_pages / $num_results_on_page) + 1) : ?><li class="page"><a class="nav-link" href="pagination.php?page=<?php echo $page + 1 ?>"><?php echo $page + 1 ?></a></li><?php endif; ?>
				<?php if ($page + 2 < ceil($total_pages / $num_results_on_page) + 1) : ?><li class="page"><a class="nav-link" href="pagination.php?page=<?php echo $page + 2 ?>"><?php echo $page + 2 ?></a></li><?php endif; ?>

				<?php if ($page < ceil($total_pages / $num_results_on_page) - 2) : ?>
					<li class="dots"><a>...</a></li>
					<li class="end"><a class="nav-link" href="pagination.php?page=<?php echo ceil($total_pages / $num_results_on_page) ?>"><?php echo ceil($total_pages / $num_results_on_page) ?></a></li>
				<?php endif; ?>

				<?php if ($page < ceil($total_pages / $num_results_on_page)) : ?>
					<li class="next"><a class="nav-link" href="pagination.php?page=<?php echo $page + 1 ?>">Next</a></li>
				<?php endif; ?>
			</ul>
		<?php endif; ?>
	</div>

	<?php require_once "layout/footer.php" ?>
<?php
	$stmt->close();
}
?>
<script></script>