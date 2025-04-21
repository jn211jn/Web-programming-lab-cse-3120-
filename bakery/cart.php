<?php
session_start();
include 'components/connect.php';


if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    $user_id = '';
    header("Location: login.php");
    exit;
}


$cart_query = $conn->prepare("
    SELECT c.*, p.name, p.price 
    FROM cart c
    JOIN products p ON c.product_id = p.id
    WHERE c.user_id = ?
");
$cart_query->execute([$user_id]);
$cart_items = $cart_query->fetchAll(PDO::FETCH_ASSOC);


function calculateTotal($cart_items) {
    $total = 0;
    foreach ($cart_items as $item) {
        $total += $item['price'] * $item['quantity'];
    }
    return $total;
}


if (isset($_GET['remove'])) {
    $itemId = $_GET['remove'];
    $remove_item = $conn->prepare("DELETE FROM cart WHERE id = ? AND user_id = ?");
    $remove_item->execute([$itemId, $user_id]);
    header("Location: cart.php");
    exit;
}


if (isset($_POST['update_cart'])) {
    foreach ($_POST['quantity'] as $itemId => $quantity) {
        if ($quantity > 0) {
            $update_quantity = $conn->prepare("UPDATE cart SET quantity = ? WHERE id = ? AND user_id = ?");
            $update_quantity->execute([$quantity, $itemId, $user_id]);
        } else {
            $remove_item = $conn->prepare("DELETE FROM cart WHERE id = ? AND user_id = ?");
            $remove_item->execute([$itemId, $user_id]);
        }
    }
    header("Location: cart.php");
    exit;
}

$total = calculateTotal($cart_items);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" type="text/css" href="css/user_style.css?v=<?php echo time(); ?>">
</head>
<body>
    <?php include 'components/user_header.php'; ?>
    
    <div class="banner">
        <div class="detail">
            <h1>Your Cart</h1>
            <p>Review your selected products before proceeding to checkout.</p>
            <span><a href="home.php">home</a><i class="bx bx-right-arrow-alt"></i>your cart</span>
        </div>
    </div>

    <div class="summary">
        <h3>Cart Summary</h3>
        <div class="container">
            <?php if (empty($cart_items)): ?>
                <div class="empty">
                    <p>Your cart is empty!</p>
                </div>
            <?php else: ?>
                <form action="cart.php" method="post">
                    <table>
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($cart_items as $item): ?>
                                <tr>
                                    <td><?= htmlspecialchars($item['name']) ?></td>
                                    <td>BDT <?= number_format($item['price'], 2) ?></td>
                                    <td>
                                        <input type="number" name="quantity[<?= $item['id'] ?>]" value="<?= $item['quantity'] ?>" min="1" required>
                                    </td>
                                    <td>BDT <?= number_format($item['price'] * $item['quantity'], 2) ?></td>
                                    <td>
                                        <a href="cart.php?remove=<?= $item['id'] ?>" class="remove-btn">Remove</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                    
                    <button type="submit" name="update_cart" class="btn">Update Cart</button>
                </form>

                <div class="grand-total">
                    <span>Total Amount Payable: </span> BDT <?= number_format($total, 2) ?>/-
                </div>

                
                <a href="proceed_to_checkout.php" class="btn">Proceed to Checkout</a>
            <?php endif; ?>
        </div>
    </div>

    <?php include 'components/user_footer.php'; ?>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script type="text/javascript" src="js/user_script.js"></script>
</body>
</html>
