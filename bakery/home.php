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
	
	
	<section class="home">
		<div class="slider">
			
			<div class="slider_slide slide1">
				<div class="slider-detail">
					<p class="date">8th December 2024</p>
					<h1>Bake Me Happy</h1>
					<p>At our bakery, we offer an exquisite selection of artisanal creations crafted with passion and precision.<br> From buttery, flaky croissants and rustic sourdough breads to decadent entremets and custom-designed celebration cakes,<br> each item is made using the finest ingredients and time-honored techniques. .</p>
					
				</div>
				<div class="right-dec-top"></div>
				<div class="right-dec-bottom"></div>
				<div class="left-dec-top"></div>
				<div class="left-dec-bottom"></div>
			</div>
			
			
			<div class="slider_slide slide2">
				<div class="slider-detail">
					<p class="date">14 February 2025</p>
					<h1>Bake Me Happy</h1>
					<p>Bake Me Happy – where sweetness meets happiness in every bite.Delight in our freshly baked treats made with love and joy!</p>
					
				</div>
				<div class="right-dec-top"></div>
				<div class="right-dec-bottom"></div>
				<div class="left-dec-top"></div>
				<div class="left-dec-bottom"></div>
			</div>
			
			<div class="slider_slide slide3">
				<div class="slider-detail">
					<p class="date">14 March 2025</p>
					<h1>Bake Me Happy</h1>
					<p>Bake Me Happy – where sweetness meets happiness in every bite.Delight in our freshly baked treats made with love and joy!</p>
					
				</div>
				<div class="right-dec-top"></div>
				<div class="right-dec-bottom"></div>
				<div class="left-dec-top"></div>
				<div class="left-dec-bottom"></div>
			</div>

			<div class="slider_slide slide4">
				<div class="slider-detail">
					<p class="date">14 March 2025</p>
					<h1>Bake Me Happy</h1>
					<p>Bake Me Happy – where sweetness meets happiness in every bite.Delight in our freshly baked treats made with love and joy!</p>
					
				</div>
				<div class="right-dec-top"></div>
				<div class="right-dec-bottom"></div>
				<div class="left-dec-top"></div>
				<div class="left-dec-bottom"></div>
			</div>

			<div class="slider_slide slide5">
				<div class="slider-detail">
					<p class="date">14 March 2025</p>
					<h1>Bake Me Happy</h1>
					<p>Bake Me Happy – where sweetness meets happiness in every bite.Delight in our freshly baked treats made with love and joy!</p>
					
				</div>
				<div class="right-dec-top"></div>
				<div class="right-dec-bottom"></div>
				<div class="left-dec-top"></div>
				<div class="left-dec-bottom"></div>
			</div>
			
			<div class="left-arrow"><i class="bx bxs-left-arrow"></i></div>
			<div class="right-arrow"><i class="bx bxs-right-arrow"></i></div>
		</div>
	</section>

	<div class="service">
		<div class="heading">
			<h1>our services</h1>
		</div>
		<div class="box-container">
			<div class="box">
				<div class="icon">
					<div class="icon-box">
						<img src="image/baked goods.png" class="img1">
					</div>
				</div>
				<div class="detail">
					<h4>baked goods</h4>
				</div>
			</div>
			<div class="box">
				<div class="icon">
					<div class="icon-box">
						<img src="image/desserts.png" class="img1">
					</div>
				</div>
				<div class="detail">
					<h4>desserts</h4>
				</div>
			</div>
			<div class="box">
				<div class="icon">
					<div class="icon-box">
						<img src="image/decore.png" class="img1">
					</div>
				</div>
				<div class="detail">
					<h4>custom cake decorating</h4>
				</div>
			</div>
			<div class="box">
				<div class="icon">
					<div class="icon-box">
						<img src="image/classb.png" class="img1">
					</div>
				</div>
				<div class="detail">
					<h4>baking classes and workshops</h4>
				</div>
			</div>
			<div class="box">
				<div class="icon">
					<div class="icon-box">
						<img src="image/event.jpg" class="img1">
					</div>
				</div>
				<div class="detail">
					<h4>event services</h4>
				</div>
			</div>
			<div class="box">
				<div class="icon">
					<div class="icon-box">
						<img src="image/tata.jpg" class="img1">
					</div>
				</div>
				<div class="detail">
					<h4>master classes</h4>
				</div>
			</div>
		</div>
		<div class="detail">
			<p>Our team together was filled with collaboration, laughter, and learning, 
				creating unforgettable memories and strengthening our teamwork and friendship.</p>
			<a href="services.php" class="btn">view our services</a>
		</div>
	</div>
	

	<div class="frame-container">
		<div class="box-container">
			<div class="box">
				<div class="box-detail">
					<img src="image/bookbb1.jpg" class="img">
					<div class="detail">
						<span>wide range</span>
						<h1>baking services</h1>
						<a href="services.php" class="btn">view our services</a>
					</div>
				</div>
				<div class="box-detail">
					<img src="image/choco.jpg" class="img">
					<div class="detail">
						<span>wide range</span>
						<h1>cakes and pastries</h1>
						<a href="products.php" class="btn">view our products</a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="about-us">
		<div class="box-container">
			<div class="img-box">
				<img src="image/white cake.jpg" class="img">
				<img src="image/eggw.jpg" class="img1">
				
			</div>
			<div class="box">
				<div class="heading">
					<span>why choose us</span>
					<h1>why bake me happy?</h1>
					<img src="image/layer.png" alt="" width="100">
				</div>
				<p>Pure ingredients. Perfect technique. Uncompromising passion. 
					We transform the world's finest butter, chocolate, and flour into edible art—because
					 you deserve nothing less than extraordinary. 
					Every bite tells the story of our craft.</p>
				<a href="about.php" class="btn">know more</a>
				<a href="#" class="btn">contact us</a>
			</div>
		</div>
	</div>


	<div class="center">
		<div class="heading">
			<span>taking care of you</span>
			<h1>professional <br> bakery and pastry shop</h1>
			<img src="image/layer.png">
		</div>
		<div class="box-container">
			<div class="box">
				<img src="image/slider2.jpg">
				<span>best products</span>
				<h1>online appointments</h1>
				<p>Dedicated to excellence and growth</p>
			</div>
			<div class="box">
				<img src="image/spa-2.jpg">
				<span>best products</span>
				<h1>gifts cards available</h1>
				<p>Committed to quality and innovation</p>
			</div>
			<div class="box">
				<img src="image/spa-2.jpg">
				<span>best foods</span>
				<h1>special offers</h1>
				<p>Where creativity meets precision</p>
			</div>
			<div class="box">
				<img src="image/app-bg.jpg">
				<span>best products</span>
				<h1>special classes</h1>
				<p>Driven by knowledge and progress</p>
			</div>
		</div>
	</div>
	<div class="offer">
		<div class="detail">
			<h1>it takes professional hands <br> To get fresh foods..</h1>
			<p>Bake Me Happy offers a delightful range of freshly baked cakes, pastries, and cookies.  
             We specialize in custom cakes for birthdays, weddings, and all special occasions.  
            From classic flavors to unique creations, every treat is made with love and premium ingredients.</p>
			<a href="services.php" class="btn">book appointment</a>
		</div>
	</div>

	<div class="accordian">
		<div class="box-container">
			<div class="box">
				<div class="heading">
					<h1>Curious about our desserts or workshops?</h1>
					<p>Start here for quick answers!</p>
				</div>
				<div class="contentBox">
					<div class="label">Do I need to book a spot for the baking workshop in advance?</div>
					<div class="content">
					<p>Yes, advance booking is recommended as seats are limited.</p>
					</div>
				</div>
				<div class="contentBox">
					<div class="label">Are the workshops suitable for beginners?</div>
					<div class="content">
					<p>Yes, our workshops are beginner-friendly and guided step-by-step.</p>
					</div>
				</div>
				<div class="contentBox">
					<div class="label">Can children join the baking classes?</div>
					<div class="content">
					<p>Absolutely! We have special sessions designed for kids too</p>
					</div>
				</div>
				<div class="contentBox">
					<div class="label">Are your baked goods made fresh daily?</div>
					<div class="content">
					<p>Yes, everything is freshly baked each day with quality ingredients.</p>
					</div>
				</div>
				<div class="contentBox">
					<div class="label">Can I pre-order custom cakes or pastries?</div>
					<div class="content">
					<p>Yes, we take custom orders with at least 24 hours’ notice.</p>
					</div>
				</div>
				<div class="contentBox">
					<div class="label">How long can I store your desserts at home?</div>
					<div class="content">
					<p>Most desserts stay fresh for 2–3 days if refrigerated properly.</p>
					</div>
				</div>
				<div class="contentBox">
					<div class="label">Do you provide home delivery for desserts?</div>
					<div class="content">
					<p>Yes, we offer home delivery within select areas—just call or order online!</p>
					</div>
				</div>
			</div>
			<div class="box">
				<img src="image/pointt.png" height="700" width="600">
			</div>
		</div>
	</div>


    <script>
	 
	</script>

	<?php include 'components/user_footer.php'; ?>


	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
	
	<script type="text/javascript" src="js/user_script.js"></script>
	
	<?php include 'components/alert.php'; ?>
</body>
</html>