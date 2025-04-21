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
			<h1>about us</h1>
			<p>Our time together was filled with collaboration, 
			<br>
			creating unforgettable memories and strengthening our teamwork and friendship.</p>
	        <span><a href="home.php">home</a><i class="bx bx-right-arrow-alt"></i>about us</span>
		</div>
	</div>
	<div class="who-container">
		<div class="box-container">
			<div class="box">
				<div class="heading">
					<span>who we are</span>
					<h1>We craft edible elegance from the finest ingredients!</h1>
					<img src="image/layer.png" width="100">
				</div>
				<p>At Bake me Happy, we believe extraordinary ingredients create extraordinary flavors.
					 We source only the finest – European AOP butters, single-origin chocolates, seasonal fruits at their peak, and organic stone-ground flours.
					  Our pastry chefs honor these premium ingredients through time-tested techniques and painstaking attention to detail. 
					  Every croissant layer, cake crumb, and bread crust reflects our refusal to compromise. 
					  This is not just baking – it's culinary craftsmanship for those who demand exceptional quality in every bite.</p>
				<div class="flex-btn">
					<a href="services.php" class="btn">explore our services</a>
					<a href="products.php" class="btn">explore our products</a>
				</div>
			</div>
			<div class="img-box">
				<img src="image/pinkcake.jpg" alt="" class="img">
			</div>
		</div>
	</div>

	<div class="bake-offer">
		<div class="detail">
			<span>New service</span>
			<h1>Children Baking Workshop</h1>
			<h2>save 25%</h2>
			<a href="contact.php" class="btn">contact us</a>
		</div>
	</div>
	<div class="advntages">
		<div class="detail">
			<div class="heading">
				<span>advntages</span>
				<h1>why people choose us</h1>
				<img src="image/layer.png" width="100">
			</div>
			<div class="box-container">
				<div class="box">
					<i class="bx bxs-leaf"></i>
					<h1>premium desserts</h1>
					<p>Using only natural and premium ingridients for our desserts and breads.</p>
				</div>
				<div class="box">
					<i class="bx bxs-flask"></i>
					<h1>author's recipes</h1>
					<p>Using only natural and premium ingridients for our desserts and breads.</p>
				</div>
				<div class="box">
					<i class="bx bxs-droplet"></i>
					<h1>plant based ingridients</h1>
					<p>Using only natural and premium ingridients for our desserts and breads.</p>
				</div>
				<div class="box">
					<i class="bx bxs-user"></i>
					<h1>premium breads</h1>
					<p>Using only natural and premium ingridients for our desserts and breads.</p>
				</div>
			</div>
		</div>
	</div>

	<div class="about">
		<div class="box-container">
			<div class="box">
				<div class="heading">
					<span>about company</span>
					<h1>Bake Me Happy</h1>
					<img src="image/layer.png">
				</div>
				<p>Bake Me Happy – where sweetness meets happiness in every bite.Delight in our freshly baked treats made with love and joy!</p>
			</div>
		</div>
	</div>

	<?php include 'components/user_footer.php'; ?>


	<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
	
	<script type="text/javascript">
		const userBtn = document.querySelector('#user-btn');
		userBtn.addEventListener("click", function(){
			const userBox = document.querySelector('.profile');
			userBox.classList.toggle('active');
		})


		const toggle = document.querySelector('#menu-btn');
		toggle.addEventListener("click", function(){
			const navbar = document.querySelector('.navbar');
			navbar.classList.toggle('active');
		})

		const searchForm = document.querySelector('.search-form');
		document.querySelector('#search-btn').onclick=()=>{
			searchForm.classList.toggle('active');
			
		}

		let slides = document.querySelectorAll('.testimonial-item');
	    let index = 0;

	    function rightSlide(){
	        slides[index].classList.remove('active');
	        index = (index + 1) % slides.length;
	        slides[index].classList.add('active');
	    }
	    function leftSlide(){
	        slides[index].classList.remove('active');
	        index = (index - 1 + slides.length) % slides.length;
	        slides[index].classList.add('active');
	    }
	</script>
	<?php include 'components/alert.php'; ?>
</body>
</html>