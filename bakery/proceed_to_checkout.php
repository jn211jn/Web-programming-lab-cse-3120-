<?php  
include 'components/connect.php';

if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    $user_id = '';
    header('Location: login.php');
    exit();
}

if (isset($_POST['book_order'])) {
    if ($user_id != '') {
        try {
            $name = $_POST['first_name'] . ' ' . $_POST['last_name'];
            $name = filter_var($name, FILTER_SANITIZE_STRING);

            $email = $_POST['email'];
            $email = filter_var($email, FILTER_SANITIZE_EMAIL);

            $number = $_POST['number'];
            $number = filter_var($number, FILTER_SANITIZE_STRING);

            $address = $_POST['address'];
            $address = filter_var($address, FILTER_SANITIZE_STRING);

            $payment = $_POST['payment'];
            $payment = filter_var($payment, FILTER_SANITIZE_STRING);

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
                    $name = $cart_item['name'];
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

                
                if ($payment === 'Bkash') {
                    $bkash_number = $_POST['bkash_number'];
                    
                } elseif ($payment === 'Nagad') {
                    $nagad_number = $_POST['nagad_number'];
                    
                } elseif ($payment === 'Rocket') {
                    $rocket_number = $_POST['rocket_number'];
                    
                } elseif ($payment === 'Credit Card') {
                    $card_number = $_POST['card_number'];
                    $expiry_date = $_POST['expiry_date'];
                    $cvv = $_POST['cvv'];
                    
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
                        <input type="text" name="first_name" placeholder="First Name" class="box" required pattern="[A-Za-z]+" title="Only alphabets are allowed">
                    </div>
                    <div class="input-field">
                        <p>Last Name <span>*</span></p>
                        <input type="text" name="last_name" placeholder="Last Name" class="box" required pattern="[A-Za-z]+" title="Only alphabets are allowed">
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
                        <select name="payment" id="payment-method" class="box select" required>
                            <option selected disabled>Select Payment Method</option>
                            <option value="Bkash">Bkash</option>
                            <option value="Nagad">Nagad</option>
                            <option value="Rocket">Rocket</option>
                            <option value="Credit Card">Credit Card</option>
                        </select>
                    </div>
                    <div id="payment-details" style="display: none;">
                        <div id="bkash-details" class="input-field" style="display: none;">
                            <p>Bkash Account Number <span>*</span></p>
                            <input type="text" name="bkash_number" placeholder="Bkash Number" class="box" pattern="\d{11}" title="Enter a valid 11-digit number">
                        </div>
                        <div id="nagad-details" class="input-field" style="display: none;">
                            <p>Nagad Account Number <span>*</span></p>
                            <input type="text" name="nagad_number" placeholder="Nagad Number" class="box" pattern="\d{11}" title="Enter a valid 11-digit number">
                        </div>
                        <div id="rocket-details" class="input-field" style="display: none;">
                            <p>Rocket Account Number <span>*</span></p>
                            <input type="text" name="rocket_number" placeholder="Rocket Number" class="box" pattern="\d{11}" title="Enter a valid 11-digit number">
                        </div>
                        <div id="credit-card-details" class="input-field" style="display: none;">
                            <p>Card Number <span>*</span></p>
                            <input type="text" name="card_number" placeholder="Card Number" class="box" pattern="\d{16}" title="Enter a valid 16-digit card number">
                            <p>Expiration Date <span>*</span></p>
                            <input type="date" name="expiry_date" class="box">
                            <p>CVV <span>*</span></p>
                            <input type="text" name="cvv" placeholder="CVV" class="box" pattern="\d{3}" title="Enter a valid 3-digit CVV">
                        </div>
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
<script>
    document.getElementById('payment-method').addEventListener('change', function () {
        const paymentMethod = this.value;
        document.getElementById('payment-details').style.display = 'block';

        document.getElementById('bkash-details').style.display = paymentMethod === 'Bkash' ? 'block' : 'none';
        document.getElementById('nagad-details').style.display = paymentMethod === 'Nagad' ? 'block' : 'none';
        document.getElementById('rocket-details').style.display = paymentMethod === 'Rocket' ? 'block' : 'none';
        document.getElementById('credit-card-details').style.display = paymentMethod === 'Credit Card' ? 'block' : 'none';
    });
</script>
</html>
