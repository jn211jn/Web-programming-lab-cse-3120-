<?php  
include 'components/connect.php';

if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    header('Location: login.php');
    exit();
}


if (isset($_POST['book_order'])) {
    if ($user_id != '') {
        try {
            
            $name = filter_var($_POST['first_name'] . ' ' . $_POST['last_name'], FILTER_SANITIZE_STRING);
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $number = filter_var($_POST['number'], FILTER_SANITIZE_STRING);
            $address = filter_var($_POST['address'], FILTER_SANITIZE_STRING);
            $payment = filter_var($_POST['payment'], FILTER_SANITIZE_STRING);
            $placed_on = date('Y-m-d');
            $grand_total = 0;

            
            $conn->beginTransaction();

            
            $select_cart = $conn->prepare("SELECT c.*, p.name AS name, p.price 
                                           FROM `cart` c 
                                           JOIN `products` p ON c.product_id = p.id 
                                           WHERE c.user_id = ?");
            $select_cart->execute([$user_id]);

            if ($select_cart->rowCount() > 0) {
                while ($cart_item = $select_cart->fetch(PDO::FETCH_ASSOC)) {
                    $product_id = $cart_item['product_id'];
                    $product_price = $cart_item['price'];
                    $quantity = $cart_item['quantity'];
                    $total_price = $product_price * $quantity;
                    $grand_total += $total_price;

                    
                    $insert_order = $conn->prepare("INSERT INTO `orders` 
                        (user_id, name, email, number, product_id, address, total_products, total_price, placed_on, payment_status) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                    $insert_order->execute([
                        $user_id, $name, $email, $number, $product_id,
                        $address, $quantity, $total_price, $placed_on, $payment
                    ]);
                }

                
                $clear_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
                $clear_cart->execute([$user_id]);

                
                $conn->commit();

                
                header('Location: place_order.php?success=order_placed');
                exit();

            } else {
                echo "<script>alert('Your cart is empty!');</script>";
                header('Location: cart.php');
                exit();
            }

        } catch (PDOException $e) {
            
            $conn->rollBack();
            echo "Database Error: " . $e->getMessage();
        }
    } else {
        echo "<script>alert('Please log in first!');</script>";
        header('Location: login.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Place Your Order</title>
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" type="text/css" href="css/user_style.css?v=<?php echo time(); ?>">
</head>
<body>
    <?php include 'components/user_header.php'; ?>

    <div class="banner">
        <div class="detail">
            <h1>Place Your Order</h1>
            <p>Bake Me Happy – where sweetness meets happiness in every bite.<br>
            Delight in our freshly baked treats made with love and joy!</p>
            <span><a href="home.php">Home</a><i class="bx bx-right-arrow-alt"></i>Place Order</span>
        </div>
    </div>

    <div class="summary">
        <h3>Order Summary</h3>
        <div class="container">
        <?php 
            $grand_total = 0;

            
            $select_cart = $conn->prepare("SELECT c.*, p.name AS name, p.price 
                                           FROM `cart` c 
                                           JOIN `products` p ON c.product_id = p.id 
                                           WHERE c.user_id = ?");
            $select_cart->execute([$user_id]);

            if ($select_cart->rowCount() > 0) {
                while ($cart_item = $select_cart->fetch(PDO::FETCH_ASSOC)) {
                    $sub_total = $cart_item['price'] * $cart_item['quantity'];
                    $grand_total += $sub_total;
        ?>
        <div class="cart-item">
            <div>
                <h3 class="name"><?= htmlspecialchars($cart_item['name']); ?></h3>
                <p class="price">Price: BDT <?= htmlspecialchars($cart_item['price']); ?>/-</p>
                <p class="quantity">Quantity: <?= htmlspecialchars($cart_item['quantity']); ?></p>
                <p class="total">Subtotal: BDT <?= htmlspecialchars($sub_total); ?>/-</p>
            </div>
        </div>

        <?php 
                }
            } else {
                echo '<div class="empty"><p>No items in your cart!</p></div>';
            }
        ?>
        <div class="grand-total"><span>Total Amount Payable: </span> BDT <?= htmlspecialchars($grand_total); ?>/-</div>
    </div>
</div>

<div class="form-container appointment">
    <form action="" method="post" enctype="multipart/form-data" class="register">
        <div class="flex">
            <div class="col">
                <div class="input-field">
                    <p>First Name <span>*</span></p>
                    <input type="text" name="first_name" placeholder="First Name" class="box" required>
                </div>
                <div class="input-field">
                    <p>Last Name <span>*</span></p>
                    <input type="text" name="last_name" placeholder="Last Name" class="box" required>
                </div>
                <div class="input-field">
                    <p>Your Number <span>*</span></p>
                    <input type="number" name="number" placeholder="Your Number" class="box" required>
                </div>
                <div class="input-field">
                    <p>Your Email <span>*</span></p>
                    <input type="email" name="email" placeholder="Your Email" class="box" required>
                </div>
            </div>
            <div class="col">
                <div class="input-field">
                    <p>Address <span>*</span></p>
                    <input type="text" name="address" placeholder="Your Address" class="box" required>
                </div>
                <div class="input-field">
                    <p>Payment Method <span>*</span></p>
                    <select name="payment" class="box select" required>
                        <option selected disabled>Select Payment Method</option>
                        <option value="Bkash">Bkash</option>
                        <option value="Nagad">Nagad</option>
                        <option value="Rocket">Rocket</option>
                        <option value="Credit Card">Credit Card</option>
                    </select>
                </div>
            </div>
        </div>
        <button type="submit" name="book_order" class="btn">Place Order</button>
    </form>
</div>

<?php include 'components/user_footer.php'; ?>
</body>
<?php if (isset($_GET['success']) && $_GET['success'] == 'order_placed'): ?>
<script>
    alert('Order placed successfully!');
    window.history.replaceState({}, document.title, window.location.pathname);
</script>
<?php endif; ?>

</html>
