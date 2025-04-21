<?php 
	include 'components/connect.php';

	// Check for user cookie
	if (isset($_COOKIE['user_id'])) {
		$user_id = $_COOKIE['user_id'];
	} else {
		$user_id = '';
	}

	// Handle login
	if (isset($_POST['login'])) {
		$email = $_POST['email'];
		$email = filter_var($email, FILTER_SANITIZE_STRING);

		$pass = sha1($_POST['pass']);
		$pass = filter_var($pass, FILTER_SANITIZE_STRING);

		$select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND password = ? LIMIT 1");
		$select_user->execute([$email, $pass]);
		$row = $select_user->fetch(PDO::FETCH_ASSOC);

		if ($select_user->rowCount() > 0) {
			setcookie('user_id', $row['id'], time() + 60*60*24*30, '/');
			header('location:home.php');
		} else {
			$warning_msg[] = 'confirm your password not matched';
		}
	}

	// Handle Add to Cart
	if (isset($_POST['product_id'])) {
		$product_id = $_POST['product_id'];
		$product_id = filter_var($product_id, FILTER_SANITIZE_STRING);

		if ($user_id) {
			$check_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ? AND product_id = ?");
			$check_cart->execute([$user_id, $product_id]);

			if ($check_cart->rowCount() > 0) {
				$warning_msg[] = 'Product already in cart!';
			} else {
				$insert_cart = $conn->prepare("INSERT INTO `cart` (user_id, product_id, quantity) VALUES (?, ?, ?)");
				$insert_cart->execute([$user_id, $product_id, 1]);
				$success_msg[] = 'Product added to cart!';
			}
		} else {
			$warning_msg[] = 'Please log in to add products to the cart.';
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Bake Me Happy</title>
	<link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
	<link rel="stylesheet" type="text/css" href="css/user_style.css?v=<?php echo time(); ?>">
</head>
<body>
	<?php include 'components/user_header.php'; ?>
	<div class="banner">
		<div class="detail">
			<h1>Search Service and Product Result</h1>
			<p>Bake Me Happy – where sweetness meets happiness in every bite.<br>
			Delight in our freshly baked treats made with love and joy!</p>
	        <span><a href="home.php">Home</a><i class="bx bx-right-arrow-alt"></i>Search Result</span>
		</div>
	</div>

	<section class="services">
		<div class="heading">
			<h1>Search Result</h1>
			<img src="image/layer.png">
		</div>
		<div class="box-container">
			<?php 
				if (isset($_POST['search_service']) || isset($_POST['search_service_btn'])) {
					$search_service = $_POST['search_service'];
					$search_service = filter_var($search_service, FILTER_SANITIZE_STRING);

					$select_service = $conn->prepare("SELECT * FROM `services` WHERE name LIKE ? AND status = ?");
					$select_service->execute(["%{$search_service}%", 'active']);

					$select_product = $conn->prepare("SELECT * FROM `products` WHERE name LIKE ? AND status = ?");
					$select_product->execute(["%{$search_service}%", 'active']);

					$found = false;

					if ($select_service->rowCount() > 0) {
						while($fetch_service = $select_service->fetch(PDO::FETCH_ASSOC)){
							$found = true;
							?>
							<form action="" method="post" class="box">
								<img src="uploaded_files/<?= $fetch_service['image']; ?>" class="image">
								<p class="price">BDT <?= $fetch_service['price']; ?>/-</p>
								<div class="content">
									<div class="button">
										<div><h3><?= $fetch_service['name']; ?></h3></div>
										<div><a href="view_page.php?pid=<?= $fetch_service['id']; ?>" class="bx bxs-show"></a></div>
									</div>
									<input type="hidden" name="service_id" value="<?= $fetch_service['id']; ?>">
									<div class="flex-btn">
										<a href="appointment.php?get_id=<?= $fetch_service['id']; ?>" class="btn">Book Appointment</a>
									</div>
								</div>
							</form>
							<?php 
						}
					}

					if ($select_product->rowCount() > 0) {
						while($fetch_product = $select_product->fetch(PDO::FETCH_ASSOC)){
							$found = true;
							?>
							<form action="" method="post" class="box">
								<img src="uploaded_files/<?= $fetch_product['image']; ?>" class="image">
								<p class="price">BDT <?= $fetch_product['price']; ?>/-</p>
								<div class="content">
									<div class="button">
										<div><h3><?= $fetch_product['name']; ?></h3></div>
										<div><a href="products.php?pid=<?= $fetch_product['id']; ?>" class="bx bxs-show"></a></div>
									</div>
									<input type="hidden" name="product_id" value="<?= $fetch_product['id']; ?>">
									<div class="flex-btn">
										<button type="submit" class="btn">Add to Cart</button>
									</div>
								</div>
							</form>
							<?php 
						}
					}

					if (!$found) {
						echo '
							<div class="empty">
								<p>No services or products found</p>
							</div>
						';
					}
				} else {
					echo '
						<div class="empty">
							<p>No services or products added yet!</p>
						</div>
					';
				}
			?>
		</div>
	</section>	

	<?php include 'components/user_footer.php'; ?>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
	<script type="text/javascript" src="js/user_script.js"></script>
	<?php include 'components/alert.php'; ?>
</body>
</html>
