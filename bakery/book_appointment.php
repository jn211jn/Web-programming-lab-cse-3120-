<?php 
	include 'components/connect.php';

	if(isset($_COOKIE['user_id'])){
		$user_id = $_COOKIE['user_id'];
	}else{
		$user_id = 'login.php';
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
			<h1>booked appointments</h1>
			<p>Bake Me Happy – where sweetness meets happiness in every bite. <br>
			Delight in our freshly baked treats made with love and joy!</p>
	        <span><a href="home.php">home</a><i class="bx bx-right-arrow-alt"></i>booked appointments</span>
		</div>
	</div>
	<div class="appointments">
		<div class="heading">
			<h1>my appointments</h1>
			<img src="image/layer.png">
		</div>
		<div class="box-container">
			<?php 
				$select_appointments = $conn->prepare("SELECT * FROM appointments WHERE user_id = ?");
				$select_appointments->execute([$user_id]);

				if ($select_appointments->rowCount() > 0) {
					while($fetch_appointments = $select_appointments->fetch(PDO::FETCH_ASSOC)){

						$appointments_id = $fetch_appointments['service_id'];
						$select_service = $conn->prepare("SELECT * FROM services WHERE id = ?");
						$select_service->execute([$fetch_appointments['service_id']]);

						if ($select_service->rowCount() > 0) {
							while($fetch_service = $select_service->fetch(PDO::FETCH_ASSOC)){


			?>
			<div class="box">
				<a href="view_appointment.php?get_id=<?= $fetch_appointments['id']; ?>">
					<img src="uploaded_files/<?= $fetch_service['image']; ?>" class="image">
					<div class="content">
						<p class="date"><i class="bx bxs-calendar-alt"></i><span><?= $fetch_appointments['date']; ?></span></p>
						<div class="row">
							<h3 class="name"><?= $fetch_appointments['name']; ?></h3>
							<p class="price"> BDT <?= $fetch_appointments['price']; ?>/-</p>
							<p class="status" style="color:<?php if($fetch_appointments['status']=='in process'){echo "green";}elseif($fetch_appointments['status']=='canceled'){echo "red";}else{echo "orange";} ?>"><?= $fetch_appointments['status']; ?></p>
							<p class="payment_status"><?= $fetch_appointments['payment_status']; ?></p>
						</div>
					</div>
				</a>
			</div>
			<?php 
							}
						}
					}
				}else{
					echo '
						<div class="empty">
							<p>no appointments take placed yet!</p>
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