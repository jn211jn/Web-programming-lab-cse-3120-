<?php 
	include 'components/connect.php';

	if(isset($_COOKIE['user_id'])){
		$user_id = $_COOKIE['user_id'];
	}else{
		$user_id = 'login.php';
	}

	if(isset($_GET['get_id'])){
		$get_id = $_GET['get_id'];
	}else{
		$get_id = '';
		header('location:book_appointment.php');
	}


	if (isset($_POST['canceled'])) {
		
		$update_appointment = $conn->prepare("UPDATE `appointments` SET status = ? WHERE id = ? LIMIT 1");
		$update_appointment->execute(['canceled', $get_id]);
		header('location:book_appointment.php');
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
			<h1>appointment details</h1>
			<p>Bake Me Happy – where sweetness meets happiness in every bite.<br>
			Delight in our freshly baked treats made with love and joy!</p>
	        <span><a href="home.php">home</a><i class="bx bx-right-arrow-alt"></i> appointment details</span>
		</div>
	</div>
	<div class="appointment-detail">
		<div class="heading">
			<h1>appointment details</h1>
			<img src="image/layer.png">
		</div>
		<div class="container">
			<?php 
			 	$grand_total = 0;
			 	$select_appointment = $conn->prepare("SELECT * FROM `appointments` WHERE id = ? LIMIT 1");
			 	$select_appointment->execute([$get_id]);

			 	if ($select_appointment->rowCount() > 0) {
			 		while($fetch_appointment = $select_appointment->fetch(PDO::FETCH_ASSOC)){
			 			$select_service = $conn->prepare("SELECT * FROM `services` WHERE id = ? LIMIT 1");
			 			$select_service->execute([$fetch_appointment['service_id']]);

			 			if ($select_service->rowCount() > 0) {
			 				while($fetch_service = $select_service->fetch(PDO::FETCH_ASSOC)){
			 					$sub_total = $fetch_appointment['price'];
			 					$grand_total += $sub_total;

			 		
			?>
			<div class="box">
				<div class="col">
					<img src="uploaded_files/<?= $fetch_service['image']; ?>" class="image">
					<p class="date"><i class="bx bxs-calendar-alt"></i><span><?= $fetch_appointment['date']; ?></p>
						<div class="detail">
							<h3 class="name"><?= $fetch_appointment['name']; ?></h3>
							<p class="grand-total">total amount paid : <span> BDT <?= $grand_total; ?>/-</span></p>
						</div>
				</div>
				<div class="col">
					<?php 
						$select_employee = $conn->prepare("SELECT * FROM `employee` WHERE id = ? LIMIT 1");
						$select_employee->execute([$fetch_appointment['employee_id']]);

						if ($select_employee->rowCount() > 0) {
							while($fetch_employee = $select_employee->fetch(PDO::FETCH_ASSOC)){


					?>
					<p class="title">employee select</p>
					<div class="employee_detail">
						<img src="uploaded_files/<?= $fetch_employee['profile']; ?>" class="employee"><br>
						<div>
							<p><?= $fetch_employee['name']; ?></p>
							<p><?= $fetch_employee['profession']; ?></p>
						</div>
					</div>
					<?php 
							}
						}
					?>
					<p class="title">customer details</p>
					<p class="user"><i class="bx bxs-user-rectangle"></i><?= $fetch_appointment['name']; ?></p>
					<p class="user"><i class="bx bxs-phone-outgoing"></i><?= $fetch_appointment['number']; ?></p>
					<p class="user"><i class="bx bxs-envelope"></i><?= $fetch_appointment['date']; ?></p>
					<p class="user"><i class="bx bxs-user-rectangle"></i><?= $fetch_appointment['time']; ?></p>
					<p class="title">status</p>
					<p class="status" style="color:<?php if($fetch_appointment['status']=='in process'){echo "green";}elseif($fetch_appointment['status']=='canceled'){echo "red";}else{echo "orange";} ?>"><?= $fetch_appointment['status']; ?></p>
					

					<?php if($fetch_appointment['status'] == 'canceled'){ ?>
						<a href="appointment.php?get_id=<?= $fetch_service['id'] ?>" class="btn">book appointment again</a>
					<?php }else{ ?>
						<form action="" method="post">
							<button type="submit" name="canceled" class="btn" onclick="return confirm('do you want to canceled this appointment');">cancele this appointment</button>
						</form>
					<?php } ?>	
				</div>
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