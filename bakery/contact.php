<?php 
	include 'components/connect.php';

	if(isset($_COOKIE['user_id'])){
		$user_id = $_COOKIE['user_id'];
	}else{
		$user_id = '';
	}

	if (isset($_POST['send_message'])) {
		if ($user_id != '') {

			$id = unique_id();

			$name = $_POST['name'];
			$name = filter_var($name, FILTER_SANITIZE_STRING);

			$email = $_POST['email'];
			$email = filter_var($email, FILTER_SANITIZE_STRING);

			$subject = $_POST['subject'];
			$subject = filter_var($subject, FILTER_SANITIZE_STRING);

			$message = $_POST['message'];
			$message = filter_var($message, FILTER_SANITIZE_STRING);

			$verify_msg = $conn->prepare("SELECT * FROM `message` WHERE user_id = ? AND name = ? AND email = ? AND subject = ? AND message = ?");
			$verify_msg->execute([$user_id, $name, $email, $subject, $message]);

			if ($verify_msg->rowCount() > 0) {
				$warning_msg[] = 'message already send';
			}else{
				$insert_msg = $conn->prepare("INSERT INTO `message`(id, user_id, name, email, subject, message) VALUES(?,?,?,?,?,?)");
				$insert_msg->execute([$id, $user_id, $name, $email, $subject, $message]);
				$success_msg[] = 'message send';
			}
		}else{
			$warning_msg[] = 'please login first';
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
			<h1>contact us</h1>
			<p>Bake Me Happy – where sweetness meets happiness in every bite. <br>
			Delight in our freshly baked treats made with love and joy!
	        <span><a href="home.php">home</a><i class="bx bx-right-arrow-alt"></i>contact us</span>
		</div>
	</div>
	<div class="contact">
		<div class="heading">
			<h1>drop a line</h1>
			<p>Bake Me Happy is a charming pastry shop where every dessert is crafted with love and creativity. <br> 
               From rich, indulgent cakes to delicate pastries, each treat is made using the finest ingredients.<br>  
               Our cozy atmosphere and friendly service make every visit a sweet experience.<br>  
               We’re passionate about baking smiles and creating memorable moments for every customer.<br>  
               Whether you're celebrating or simply craving something sweet, Bake Me Happy is your happy place!</p>
	       <img src="image/layer.png">
		</div>
		<div class="form-container">
			<form action="" method="post" enctype="multipart/form-data" class="login">
				<div class="input-field">
					<p>your name <span>*</span></p>
					<input type="text" name="name" placeholder="enter your name" maxlength="50" required class="box">
				</div>
				<div class="input-field">
					<p>your email <span>*</span></p>
					<input type="email" name="email" placeholder="enter your email" maxlength="60" required class="box">
				</div>
				<div class="input-field">
					<p>subject <span>*</span></p>
					<input type="text" name="subject" placeholder="enter your reason" maxlength="150" required class="box">
				</div>
				<div class="input-field">
					<p>message <span>*</span></p>
					<textarea name="message" class="box"></textarea>
				</div>
				<button type="submit" name="send_message" class="btn">send message</button>
			</form>
		</div>
	</div>
	<div class="contact_details">
		<div class="heading">
			<h1>our contact details</h1>
			<p>Bake Me Happy is a charming pastry shop where every dessert is crafted with love and creativity.  <br>
From rich, indulgent cakes to delicate pastries, each treat is made using the finest ingredients.<br>  
Our cozy atmosphere and friendly service make every visit a sweet experience.  <br>
We’re passionate about baking smiles and creating memorable moments for every customer.<br>  
Whether you're celebrating or simply craving something sweet, Bake Me Happy is your happy place!</p>
	       <img src="image/layer.png">
		</div>
		<div class="box-container">
			<div class="box">
				<i class="bx bxs-map-alt"></i>
				<div>
					<h4>address</h4>
					<p>mohammadpur <br>Dhaka, 1207</p>
				</div>
			</div>
			<div class="box">
				<i class="bx bxs-phone-incoming"></i>
				<div>
					<div>
					<h4>phone number</h4>
					<p>01750759386</p>
				</div>
				</div>
			</div>
			<div class="box">
				<i class="bx bxs-envelope"></i>
				<div>
					<h4>email</h4>
					<p>jannatshimu@gmail.com</p>
				</div>
			</div>
		</div>
	</div>

	<?php include 'components/user_footer.php'; ?>

	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
	
	<script type="text/javascript" src="js/user_script.js"></script>
	
	<?php include 'components/alert.php'; ?>
</body>
</html>