<?php 
	include 'components/connect.php';

	if(isset($_COOKIE['user_id'])){
		$user_id = $_COOKIE['user_id'];
	}else{
		$user_id = '';
	}

	$pid = $_GET['pid'];
	
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
			<h1>view service</h1>
			<p>Bake Me Happy – where sweetness meets happiness in every bite.<br>
			Delight in our freshly baked treats made with love and joy!</p>
	        <span><a href="home.php">home</a><i class="bx bx-right-arrow-alt"></i>view service</span>
		</div>
	</div>
	<div class="view-service">
		<div class="heading">
			<h1>service details</h1>
			<img src="image/layer.png">
		</div>
		<?php 
			if (isset($_GET['pid'])) {
				$pid = $_GET['pid'];
				$select_service = $conn->prepare("SELECT * FROM `services` WHERE id = '$pid'");
				$select_service->execute();

				if ($select_service->rowCount() > 0) {
					while($fetch_service = $select_service->fetch(PDO::FETCH_ASSOC)){


		?>
		<form action="" method="post" class="box">
			<div class="img-box">
				<img src="uploaded_files/<?= $fetch_service['image']; ?>">
			</div>
			<div class="detail">
				<p class="price">BDT <?= $fetch_service['price']; ?>/-</p>
				<div class="name"><?= $fetch_service['name']; ?></div>
				<p class="service-detail"><?= $fetch_service['service_detail']; ?></p>
				<input type="hidden" name="service_id" value="<?= $fetch_service['id']; ?>">
				<div class="flex-btn">
					<a href="appointment.php?get_id=<?= $fetch_service['id']; ?>" class="btn" style="width: 100%;">book appointment now</a>
				</div>
			</div>
		</form>
		<?php 
					}
				}
			}else{
				echo '
						<div class="empty">
							<p>no services added yet!</p>
						</div>
					';
			}
		?>
	</div>



	<?php include 'components/user_footer.php'; ?>

	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
	
	<script type="text/javascript" src="js/user_script.js"></script>
	
	<?php include 'components/alert.php'; ?>
</body>
</html>