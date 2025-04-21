<?php  
include 'components/connect.php';

if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    header('Location: login.php');
    exit();
}


if (isset($_POST['cancel_order'])) {
    $order_id = $_POST['order_id']; 
    $update_order = $conn->prepare("UPDATE `orders` SET status = ? WHERE id = ? AND user_id = ? LIMIT 1");
    $update_order->execute(['canceled', $order_id, $user_id]);
    $success_message = "Order #{$order_id} has been canceled.";
}


$select_orders = $conn->prepare("SELECT o.*, p.name AS product_name, p.price AS product_price 
                                  FROM `orders` o 
                                  JOIN `products` p ON o.product_id = p.id 
                                  WHERE o.user_id = ?");
$select_orders->execute([$user_id]);

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Your Orders</title>
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" type="text/css" href="css/user_style.css?v=<?php echo time(); ?>">
</head>
<body>
    <?php include 'components/user_header.php'; ?>

    <div class="banner">
        <div class="detail">
            <h1>Your Orders</h1>
            <p>Here are the orders you have placed.</p>
            <span><a href="home.php">Home</a><i class="bx bx-right-arrow-alt"></i>Your Orders</span>
        </div>
    </div>

    <div class="order-section">
        <h3>Your Orders</h3>
        <?php if (isset($success_message)) { ?>
            <p class="success-message"><?= htmlspecialchars($success_message); ?></p>
        <?php } ?>
        <div class="order-list">
            <?php 
            if ($select_orders->rowCount() > 0) {
                while ($order = $select_orders->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                    <div class="order-details">
                        <h4>Order ID: <?= htmlspecialchars($order['id']); ?></h4>
                        <p><strong>Product Name:</strong> <?= htmlspecialchars($order['product_name']); ?></p>
                        <p><strong>Price:</strong> BDT <?= htmlspecialchars($order['product_price']); ?>/-</p>
                        <p><strong>Quantity:</strong> <?= htmlspecialchars($order['total_products']); ?></p>
                        <p><strong>Total Price:</strong> BDT <?= htmlspecialchars($order['total_price']); ?>/-</p>
                        <p><strong>Placed On:</strong> <?= htmlspecialchars($order['placed_on']); ?></p>
                        <p><strong>Payment Status:</strong> <?= htmlspecialchars($order['payment_status']); ?></p>
                        <p><strong>Status:</strong> 
   <span style="
       color: <?= ($order['status'] === 'canceled') ? 'red' : (($order['status'] === 'in process') ? 'green' : 'inherit'); ?>;
       text-transform: uppercase;">
       <?= htmlspecialchars($order['status']); ?>
   </span>
</p>




                        <?php if ($order['status'] !== 'canceled' && $order['status'] !== 'completed') { ?>
                            
                            <form action="" method="post">
                                <input type="hidden" name="order_id" value="<?= htmlspecialchars($order['id']); ?>">
                                <button type="submit" name="cancel_order" class="btn" onclick="return confirm('Do you want to cancel this order?');">Cancel Order</button>
                            </form>
                        <?php } else { ?>
                            <p class="info">Order cannot be canceled.</p>
                        <?php } ?>
                        <hr>
                    </div>
                    <?php
                }
            } else {
                echo '<div class="empty"><p>You have not placed any orders yet!</p></div>';
            }
            ?>
        </div>
    </div>

    <?php include 'components/user_footer.php'; ?>
</body>
</html>
