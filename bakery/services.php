<?php 
	include 'components/connect.php';

	if(isset($_COOKIE['user_id'])){
		$user_id = $_COOKIE['user_id'];
	}else{
		$user_id = '';
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
			<h1>Baking workshops</h1>
			<p>Bake Me Happy – where sweetness meets happiness in every bite.<br>
				Delight in our freshly baked treats made with love and joy!</p>
	        <span><a href="home.php">home</a><i class="bx bx-right-arrow-alt"></i>our services</span>
		</div>
	</div>
	<div class="services">
		<div class="box-container">
			<?php 
				$select_services = $conn->prepare("SELECT * FROM `services` WHERE status = ?");
				$select_services->execute(['active']);

				if ($select_services->rowCount() > 0) {
					while($fetch_services = $select_services->fetch(PDO::FETCH_ASSOC)){


			?>
			<form action="" method="post" class="box">
				<img src="uploaded_files/<?= $fetch_services['image']; ?>" class="image">
				<p class="price">BDT <?= $fetch_services['price']; ?>/-</p>
				<div class="content">
					<div class="button">
						<div><h3><?= $fetch_services['name']; ?></h3></div>
						<div><a href="view_page.php?pid=<?= $fetch_services['id']; ?>" class="bx bxs-show"></a></div>
					</div>
					<input type="hidden" name="service_id" value="<?= $fetch_services['id']; ?>">
					<div class="flex-btn">
						<a href="appointment.php?get_id=<?= $fetch_services['id']; ?>" class="btn">book appointment</a>
					</div>
				</div>
				
			</form>
			<?php 
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
	</div>



	<?php include 'components/user_footer.php'; ?>

	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
	
	<script type="text/javascript" src="js/user_script.js"></script>
	
	<?php include 'components/alert.php'; ?>
</body>
</html>