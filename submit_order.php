<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sugandhi_tea";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$message = "";
$is_success = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $customer_name = $_POST['customer_name'] ?? '';
    $tea_type = $_POST['tea_type'] ?? '';
    $quantity = intval($_POST['quantity'] ?? 0);

    if (!empty($customer_name) && !empty($tea_type) && $quantity > 0) {
        $customer_name = mysqli_real_escape_string($conn, $customer_name);
        $tea_type = mysqli_real_escape_string($conn, $tea_type);

        $sql = "INSERT INTO orders (customer_name, tea_type, quantity) 
                VALUES ('$customer_name', '$tea_type', $quantity)";

        if (mysqli_query($conn, $sql)) {
            $message = "Your order has been placed successfully!";
            $is_success = true;
        } else {
            $message = "Error while placing order: " . mysqli_error($conn);
        }
    } else {
        $message = "Please fill all the fields correctly.";
    }
}

mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sugandhi Tea - Order Status</title>
    <style>
        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            background: radial-gradient(circle at top, #1f2937 0, #020617 50%, #000 100%);
            color: #e5e7eb;
        }
        .card {
            background: rgba(15,23,42,0.96);
            border-radius: 1.2rem;
            padding: 1.8rem 1.9rem;
            border: 1px solid rgba(148,163,184,0.35);
            box-shadow: 0 22px 60px rgba(15,23,42,1);
            max-width: 380px;
            text-align: center;
        }
        .status-icon {
            font-size: 2.3rem;
            margin-bottom: 0.6rem;
        }
        .title {
            font-size: 1.2rem;
            margin-bottom: 0.6rem;
        }
        .msg {
            font-size: 0.92rem;
            margin-bottom: 1.4rem;
            color: #9ca3af;
        }
        .btn {
            display: inline-block;
            text-decoration: none;
            padding: 0.6rem 1.3rem;
            border-radius: 999px;
            border: none;
            cursor: pointer;
            font-size: 0.9rem;
            font-weight: 500;
            background: linear-gradient(to right, #f97316, #facc15);
            color: #020617;
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="status-icon">
            <?php if ($is_success): ?>
                ☕
            <?php else: ?>
                ⚠️
            <?php endif; ?>
        </div>
        <div class="title">
            <?php echo $is_success ? "Thank you for your order!" : "Order status"; ?>
        </div>
        <div class="msg">
            <?php echo htmlspecialchars($message); ?>
        </div>
        <a href="index.html" class="btn">Back to Order Page</a>
    </div>
</body>
</html>
