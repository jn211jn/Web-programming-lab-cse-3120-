<?php 
	include 'components/connect.php';

	if(isset($_COOKIE['user_id'])){
		$user_id = $_COOKIE['user_id'];
	}else{
		$user_id = 'login.php';
	}

	if(isset($_GET['order_id'])){
		$order_id = $_GET['order_id'];
	}else{
		$order_id = '';
		header('location:orders.php');
	}

	if (isset($_POST['canceled'])) {
		$order_id = $_POST['order_id']; 
		$update_order = $conn->prepare("UPDATE `orders` SET status = ? WHERE id = ? LIMIT 1");
		$update_order->execute(['canceled', $order_id]);
		header('location:orders.php');
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
			<h1>order details</h1>
			<p>Explore your order details and track your purchase. Stay informed and updated on your baking classes or baked goods.</p>
	        <span><a href="home.php">home</a><i class="bx bx-right-arrow-alt"></i> order details</span>
		</div>
	</div>
	<div class="order-detail">
		<div class="heading">
			<h1>order details</h1>
			<img src="image/layer.png">
		</div>
		<div class="container">
			<?php 
			 	$grand_total = 0;
			 	$select_order = $conn->prepare("SELECT * FROM `orders` WHERE id = ? LIMIT 1");
			 	$select_order->execute([$order_id]);

			 	if ($select_order->rowCount() > 0) {
			 		while($fetch_order = $select_order->fetch(PDO::FETCH_ASSOC)){
			 			$sub_total = $fetch_order['price'] * $fetch_order['quantity'];
			 			$grand_total += $sub_total;
			?>
			<div class="box">
				<div class="col">
					
					<img src="uploaded_files/<?= $fetch_order['image']; ?>" class="image">
					<p class="date"><i class="bx bxs-calendar-alt"></i><span><?= $fetch_order['order_date']; ?></p>
						<div class="detail">
							<h3 class="name"><?= $fetch_order['product_name']; ?></h3>
							<p class="grand-total">total amount paid : <span> BDT <?= $grand_total; ?>/-</span></p>
						</div>
				</div>
				<div class="col">
					<p class="title">order details</p>
					<p class="quantity">Quantity: <?= $fetch_order['quantity']; ?></p>
					<p class="price">Price: BDT <?= $fetch_order['price']; ?>/-</p>
					<p class="total">Subtotal: BDT <?= $sub_total; ?>/-</p>
					<p class="title">customer details</p>
					<p class="user"><i class="bx bxs-user-rectangle"></i><?= $fetch_order['customer_name']; ?></p>
					<p class="user"><i class="bx bxs-phone-outgoing"></i><?= $fetch_order['customer_phone']; ?></p>
					<p class="user"><i class="bx bxs-envelope"></i><?= $fetch_order['customer_email']; ?></p>
					<p class="title">status</p>
					<p class="status" style="color:<?php if($fetch_order['status'] == 'completed'){echo "green";} elseif($fetch_order['status'] == 'canceled'){echo "red";} else {echo "orange";} ?>"><?= $fetch_order['status']; ?></p>

					<?php if($fetch_order['status'] == 'canceled'){ ?>
						<a href="orders.php?order_id=<?= $fetch_order['id'] ?>" class="btn">reorder</a>
					<?php } else { ?>
						<form action="" method="post">
    <input type="hidden" name="order_id" value="<?= $fetch_order['id']; ?>">
    <button type="submit" name="canceled" class="btn" onclick="return confirm('Do you want to cancel this order?');">Cancel this order</button>
</form>

					<?php } ?>	
				</div>
			</div>
			<?php 
							}
			 	}else{
			 		echo '
						<div class="empty">
							<p>No orders found!</p>
						</div>
					';
			 	}
			?>
		</div>
	</div>

	<?php include 'components/user_footer.php'; ?>

	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
	
	<script type="text/javascript" src="js/user_script.js"></script>
	
	<?php include 'components/alert.php'; ?>
</body>
</html>
