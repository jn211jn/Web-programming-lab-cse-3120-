<?php 
session_start();
include 'components/connect.php';

if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    $user_id = '';
}

if (isset($_POST['add_to_cart'])) {
    $productId = $_POST['product_id'];
    $quantity = $_POST['quantity'] ?? 1; 

    if ($user_id != '') {
        
        $check_cart = $conn->prepare("SELECT * FROM cart WHERE user_id = ? AND product_id = ?");
        $check_cart->execute([$user_id, $productId]);

        if ($check_cart->rowCount() > 0) {
            
            $update_cart = $conn->prepare("UPDATE cart SET quantity = quantity + ? WHERE user_id = ? AND product_id = ?");
            $update_cart->execute([$quantity, $user_id, $productId]);
        } else {
           
            $add_to_cart = $conn->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)");
            $add_to_cart->execute([$user_id, $productId, $quantity]);
        }

        header("Location: cart.php");
        exit;
    } else {
       
        header("Location: login.php");
        exit;
    }
}


$productId = isset($_GET['product_id']) ? $_GET['product_id'] : '';
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
            <h1>View Products</h1>
            <p>Bake Me Happy – where sweetness meets happiness in every bite.<br>
                Delight in our freshly baked treats made with love and joy!</p>
            <span><a href="home.php">home</a><i class="bx bx-right-arrow-alt"></i>view product</span>
        </div>
    </div>
    <div class="view-product">
        <div class="heading">
            <h1>Product Details</h1>
            <img src="image/layer.png">
        </div>
        <?php 
        if (!empty($productId)) {
            $select_product = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
            $select_product->execute([$productId]);

            if ($select_product->rowCount() > 0) {
                while ($fetch_product = $select_product->fetch(PDO::FETCH_ASSOC)) {
        ?>
        <form action="" method="post" class="box">
            <div class="img-box">
                <img src="uploaded_files/<?= htmlspecialchars($fetch_product['image']); ?>">
            </div>
            <div class="detail">
                <p class="price">BDT <?= htmlspecialchars($fetch_product['price']); ?>/-</p>
                <div class="name"><?= htmlspecialchars($fetch_product['name']); ?></div>
                <p class="product-detail"><?= htmlspecialchars($fetch_product['products_detail']); ?></p>
                <input type="hidden" name="product_id" value="<?= htmlspecialchars($fetch_product['id']); ?>">
                <input type="hidden" name="quantity" value="1"> 
                <div class="flex-btn">
                    <button type="submit" name="add_to_cart" class="btn" style="width: 100%;">Add to Cart</button>
                </div>
            </div>
        </form>
        <?php 
                }
            } else {
                echo '
                    <div class="empty">
                        <p>No product found!</p>
                    </div>
                ';
            }
        } else {
            echo '
                <div class="empty">
                    <p>No Product Selected!</p>
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
