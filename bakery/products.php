<?php
session_start();
include 'components/connect.php';

if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    $user_id = '';
}

// Handle AJAX requests first
if (isset($_POST['add_to_cart'])) {
    header('Content-Type: application/json');
    
    $productId = $_POST['product_id'];
    $quantity = $_POST['quantity'] ?? 1; 

    if ($user_id != '') {
        try {
            // Check if product exists
            $check_product = $conn->prepare("SELECT id FROM products WHERE id = ? AND status = 'active'");
            $check_product->execute([$productId]);
            
            if ($check_product->rowCount() == 0) {
                echo json_encode(['success' => false, 'message' => 'Product not available']);
                exit;
            }

            // Check if product is in cart
            $check_cart = $conn->prepare("SELECT * FROM cart WHERE user_id = ? AND product_id = ?");
            $check_cart->execute([$user_id, $productId]);

            if ($check_cart->rowCount() > 0) {
                $update_cart = $conn->prepare("UPDATE cart SET quantity = quantity + ? WHERE user_id = ? AND product_id = ?");
                $update_cart->execute([$quantity, $user_id, $productId]);
                $message = "Product quantity updated in cart";
            } else {
                $add_to_cart = $conn->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)");
                $add_to_cart->execute([$user_id, $productId, $quantity]);
                $message = "Product added to cart";
            }

            // Get updated cart count
            $cart_count_query = $conn->prepare("SELECT SUM(quantity) AS total_items FROM cart WHERE user_id = ?");
            $cart_count_query->execute([$user_id]);
            $cart_count_result = $cart_count_query->fetch(PDO::FETCH_ASSOC);
            $cart_count = $cart_count_result['total_items'] ?? 0;

            echo json_encode([
                'success' => true, 
                'cart_count' => $cart_count,
                'message' => $message
            ]);
        } catch (PDOException $e) {
            echo json_encode([
                'success' => false, 
                'message' => 'Database error: ' . $e->getMessage()
            ]);
        }
    } else {
        echo json_encode([
            'success' => false, 
            'message' => 'Please login to add products to cart',
            'login_required' => true
        ]);
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bake Me Happy</title>
    <link href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/user_style.css?v=<?php echo time(); ?>">
    
</head>
<body>
    <?php include 'components/user_header.php'; ?>

    <div class="banner">
        <div class="detail">
            <h1>Our foods and desserts</h1>
            <p>Bake Me Happy – where sweetness meets happiness in every bite. <br>
                Delight in our freshly baked treats made with love and joy!</p>
            <span><a href="home.php">home</a><i class="bx bx-right-arrow-alt"></i>our foods and desserts</span>
        </div>
    </div>

    <div class="products">
        <div class="box-container">
            <?php
                $select_product = $conn->prepare("SELECT * FROM `products` WHERE status = ?");
                $select_product->execute(['active']);

                if ($select_product->rowCount() > 0) {
                    while ($fetch_product = $select_product->fetch(PDO::FETCH_ASSOC)) {
            ?>
            <form class="box" data-product="<?= $fetch_product['id']; ?>">
                <img src="uploaded_files/<?= htmlspecialchars($fetch_product['image']); ?>" class="image" alt="<?= htmlspecialchars($fetch_product['name']); ?>">
                <p class="price">BDT <?= htmlspecialchars($fetch_product['price']); ?>/-</p>
                <div class="content">
                    <div class="button">
                        <div><h3><?= htmlspecialchars($fetch_product['name']); ?></h3></div>
                        <div><a href="view_ppage.php?product_id=<?= $fetch_product['id']; ?>" class="bx bxs-show"></a></div>
                    </div>
                    <input type="hidden" name="product_id" value="<?= $fetch_product['id']; ?>">
                    <input type="hidden" name="quantity" value="1">
                    <div class="flex-btn">
                        <button type="submit" class="btn">Add to Cart</button>
                    </div>
                </div>
            </form>
            <?php 
                    }
                } else {
                    echo '<div class="empty"><p>No products added yet!</p></div>';
                }
            ?>
        </div>
    </div>

    <?php include 'components/user_footer.php'; ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function() {
        $("form").submit(function(e) {
            e.preventDefault();
            var form = $(this);
            var formData = form.serialize();
            
            $.ajax({
                url: window.location.href,
                method: "POST",
                data: formData + '&add_to_cart=1',
                dataType: "json",
                success: function(response) {
                    if (response.success) {
                        // Update cart count
                        $(".cart-count").text(response.cart_count);
                        
                        // Show success message
                        swal({
                            title: "Success",
                            text: response.message,
                            icon: "success",
                            button: "OK"
                        });
                    } else {
                        if (response.login_required) {
                            swal({
                                title: "Login Required",
                                text: response.message,
                                icon: "warning",
                                buttons: {
                                    cancel: "Cancel",
                                    confirm: "Login Now"
                                }
                            }).then((value) => {
                                if (value) {
                                    window.location.href = "login.php";
                                }
                            });
                        } else {
                            swal({
                                title: "Error",
                                text: response.message,
                                icon: "error",
                                button: "OK"
                            });
                        }
                    }
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                    swal({
                        title: "Error",
                        text: "Failed to add to cart. Please try again.",
                        icon: "error",
                        button: "OK"
                    });
                }
            });
        });
    });
    </script>
</body>
</html>