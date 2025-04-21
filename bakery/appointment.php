<?php  
    include 'components/connect.php';

    if(isset($_COOKIE['user_id'])){
        $user_id = $_COOKIE['user_id'];
    }else{
        $user_id = '';
    }

    if (isset($_POST['book_appointment'])) {
        if ($user_id != '') {
            $id = unique_id();

            $name = $_POST['first_name'].' '.$_POST['last_name'];
            $name = filter_var($name, FILTER_SANITIZE_STRING);

            $email = $_POST['email'];
            $email = filter_var($email, FILTER_SANITIZE_STRING);

            $number = $_POST['number'];
            $number = filter_var($number, FILTER_SANITIZE_STRING);

            $payment = $_POST['payment'];
            $payment = filter_var($payment, FILTER_SANITIZE_STRING);

            $employee = $_POST['employee'];
            $employee = filter_var($employee, FILTER_SANITIZE_STRING);

            $date = $_POST['date'];
            $date = filter_var($date, FILTER_SANITIZE_STRING);

            $time = $_POST['time'];
            $time = filter_var($time, FILTER_SANITIZE_STRING);

            $payment_details = '';

            if ($payment === 'Bkash' || $payment === 'Nagad' || $payment === 'Rocket') {
                $account_number = $_POST['Account_number'];
                $account_number = filter_var($account_number, FILTER_SANITIZE_STRING);
                $payment_details = "Account Number: $account_number";
            } elseif ($payment === 'Credit Card') {
                $card_number = $_POST['card_number'];
                $expiry_date = $_POST['expiry_date'];
                $cvv = $_POST['cvv'];
            
                $card_number = filter_var($card_number, FILTER_SANITIZE_STRING);
                $expiry_date = filter_var($expiry_date, FILTER_SANITIZE_STRING);
                $cvv = filter_var($cvv, FILTER_SANITIZE_STRING);
            
                $payment_details = "Card Number: $card_number, CVV: $cvv, Expiry Date: $expiry_date";
            }
            
            // set payment_status (you can also make this dynamic)
            $payment_status = 'pending';
            
            if(isset($_GET['get_id'])){
                $get_service = $conn->prepare("SELECT * FROM `services` WHERE id = ? LIMIT 1");
                $get_service->execute([$_GET['get_id']]);

                if ($get_service->rowCount() > 0) {
                    while($fetch_s = $get_service->fetch(PDO::FETCH_ASSOC)){

                        $check_customer_booking = $conn->prepare("SELECT * FROM `appointments` WHERE user_id = ? AND date = ? AND time = ?");
                        $check_customer_booking->execute([$user_id, $date, $time]);

                        if ($check_customer_booking->rowCount() > 0) {
                            $warning_msg[] = 'You already have a booking on this date and time. Please choose a different time or date.';
                        } else {

                            $check_duplicate = $conn->prepare("SELECT * FROM `appointments` WHERE employee_id = ? AND date = ? AND time = ?");
                            $check_duplicate->execute([$employee, $date, $time]);

                            if ($check_duplicate->rowCount() > 0) {
                                $warning_msg[] = 'Sorry, this employee is already booked for the same date and time. Please choose a different time or employee.';
                            } else {
                                $insert_service = $conn->prepare("INSERT INTO `appointments`(id, user_id, name, number, email, service_id, employee_id, date, time, price, payment_status) VALUES(?,?,?,?,?,?,?,?,?,?,?)");
                                $insert_service->execute([$id, $user_id, $name, $number, $email, $fetch_s['id'], $employee, $date, $time, $fetch_s['price'], $payment_status]);

                                $success_msg[] = 'Your appointment booked successfully!';
                                header('location:book_appointment.php');
                            }
                        }
                    }
                }
            }
        } else {
            $warning_msg[] = 'Please login first';
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
            <h1>book appointment</h1>
            <p>Bake Me Happy – where sweetness meets happiness in every bite. <br>
            Delight in our freshly baked treats made with love and joy!<</p>
            <span><a href="home.php">home</a><i class="bx bx-right-arrow-alt"></i>book appointment</span>
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
                        <p>Payment Method <span>*</span></p>
                        <select name="payment" id="payment-method" class="box select" required onchange="showPaymentFields()">
                            <option selected disabled>Select Payment Method</option>
                            <option value="Bkash">Bkash</option>
                            <option value="Nagad">Nagad</option>
                            <option value="Rocket">Rocket</option>
                            <option value="Credit Card">Credit Card</option>
                        </select>
                    </div>
                    <div id="payment-fields"></div>
                    <div class="input-field">
                        <p>Employee <span>*</span></p>
                        <select name="employee" class="box select" required>
                            <?php 
                                $select_employee = $conn->prepare("SELECT * FROM `employee` WHERE status = ?");
                                $select_employee->execute(['active']);

                                if ($select_employee->rowCount() > 0) {
                                    while($fetch_employee = $select_employee->fetch(PDO::FETCH_ASSOC)){
                            ?>
                            <option value="<?= $fetch_employee['id'] ?>"><?= $fetch_employee['name']; ?></option>
                            <?php 
                                    }
                                }
                            ?>
                        </select>
                    </div>
                    <div class="input-field">
                        <p>Select Date <span>*</span></p>
                        <input type="date" name="date" placeholder="Select Date" class="box" required>
                    </div>
                    <div class="input-field">
                        <p>Select Time <span>*</span></p>
                        <select name="time" class="box select" required>
                            <option selected disabled>Select Time</option>
                            <option value="9:00 AM - 10:00 AM">9:00 AM - 10:00 AM</option>
                            <option value="9:30 AM - 10:30 AM">9:30 AM - 10:30 AM</option>
                            <option value="11:30 AM - 12:30 PM">11:30 AM - 12:30 PM</option>
                            <option value="12:00 AM - 1:00 PM">12:00 AM - 1:00 PM</option>
                            <option value="1:30 PM - 2:30 PM">1:30 PM - 2:30 PM</option>
                            <option value="3:00 PM - 4:00 PM">3:00 PM - 4:00 PM</option>
                            <option value="3:30 PM - 4:30 PM">3:30 PM - 4:30 PM</option>
                            <option value="5:00 PM - 6:00 PM">5:00 PM - 6:00 PM</option>
                        </select>
                    </div>
                </div>
            </div>
            <button type="submit" name="book_appointment" class="btn">Book Appointment</button>
        </form>
    </div>

    <?php include 'components/user_footer.php'; ?>

    <script>
        function showPaymentFields() {
            const paymentMethod = document.getElementById('payment-method').value;
            const paymentFields = document.getElementById('payment-fields');

            let fields = '';

            if (paymentMethod === 'Bkash' || paymentMethod === 'Nagad' || paymentMethod === 'Rocket') {
                fields = `
                    <div class="input-field">
                        <p>Account Number <span>*</span></p>
                        <input type="text" name="Account_number" placeholder="Enter Account Number" class="box" required>
                    </div>
                `;
            } else if (paymentMethod === 'Credit Card') {
                fields = `
                    <div class="input-field">
                        <p>Card Number <span>*</span></p>
                        <input type="text" name="card_number" placeholder="Enter Card Number" class="box" required>
                    </div>
                    <div class="input-field">
                        <p>Expiry Date <span>*</span></p>
                        <input type="date" name="expiry_date" class="box" required>
                    </div>
					<div class="input-field">
                        <p>CVV <span>*</span></p>
                        <input type="text" name="cvv" placeholder="Enter CVV" class="box" required>
                    </div>
                `;
            }

            paymentFields.innerHTML = fields;
        }
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script type="text/javascript" src="js/user_script.js"></script>
    <?php include 'components/alert.php'; ?>
</body>
</html>
