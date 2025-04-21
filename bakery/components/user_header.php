<header class="header">
	<section class="flex">
		<a href="home.php" class="logo"><img src="image/pho.png" width="130"></a>
		<nav class="navbar">
			<a href="home.php">home</a>
			<a href="about.php">about us</a>
			<a href="services.php">services</a>
			<a href="products.php">products</a>
			<a href="orders.php">orders</a>
			<a href="team.php">team</a>
			<a href="book_appointment.php">appointment</a>
			<a href="contact.php">contact</a>
		</nav>
		<form action="search.php" method="post" class="search-form">
			<input type="text" name="search_service" placeholder="search service or products" required maxlength="100">
			<button type="submit" class="bx bx-search-alt-2" name="search_service_btn"></button>
		</form>
		<div class="icons">
           <div id="menu-btn" class="bx bx-list-plus"></div>
           <div id="search-btn" class="bx bx-search-alt-2"></div>
           <div id="user-btn" class="bx bxs-user"></div>
           <a href="cart.php" class="cart-icon">
           <div class="bx bx-cart"></div>
           <span class="cart-count">
		   <?php 
    $cart_count = 0; 

    
    if (isset($_COOKIE['user_id'])) {
        $user_id = $_COOKIE['user_id'];

        
        $cart_count_query = $conn->prepare("SELECT SUM(quantity) AS total_items FROM cart WHERE user_id = ?");
        $cart_count_query->execute([$user_id]);
        $cart_count_result = $cart_count_query->fetch(PDO::FETCH_ASSOC);
        $cart_count = $cart_count_result['total_items'] ?? 0; 
    }

    echo $cart_count; 
?>

        </span>
    </a>
</div>
		<div class="profile">
			<?php 
				$select_profile = $conn->prepare("SELECT * FROM users WHERE id = ?");
				$select_profile->execute([$user_id]);

				if ($select_profile->rowCount() > 0) {
					$fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
				
			?>
			<img src="uploaded_files/<?= $fetch_profile['image']; ?>">
			<h3 style="margin-bottom: 1rem;" ><?= $fetch_profile['name']; ?></h3>
			<div class="flex-btn">
				<a href="profile.php" class="btn">view profile</a>
				<a href="components/user_logout.php" onclick="return confirm('logout from this website');" class="btn">logout</a>
			</div>
			<?php
				}else{

			?>
			<img src="image/vector.webp">
			<h3 style="margin-bottom: 1rem;" >please login or register</h3>
			<div class="flex-btn">
				<a href="login.php" class="btn">login</a>
				<a href="register.php" class="btn">register</a>
			</div>
			<?php 
				}
			?>
		</div>
	</section>
</header>