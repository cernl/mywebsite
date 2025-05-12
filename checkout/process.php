
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include '../includes/db.php';

$user_id = $_SESSION['user_id'];
$email = $_SESSION['user_email'];
$cart = $_SESSION['cart'] ?? [];

if (empty($cart)) {
    header('Location: ../cart/view.php');
    exit;
}

// Gather shipping and payment fields
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$address = $_POST['address'];
$city = $_POST['city'];
$postal = $_POST['postal'];
$country = $_POST['country'];
$state = $_POST['state'];
$phone = $_POST['phone'];


// Calculate subtotal
$subtotal = 0;
foreach ($cart as $item) {
    $stmt = $conn->prepare("SELECT price FROM products WHERE id = ?");
    $stmt->bind_param("i", $item['product_id']);
    $stmt->execute();
    $price = $stmt->get_result()->fetch_assoc()['price'];
    $subtotal += $price * $item['quantity'];
}

$tax = round($subtotal * 0.08875, 2);
$total = $subtotal + $tax;

// Create order with shipping info
$orderStmt = $conn->prepare("INSERT INTO orders (
    user_id, email, first_name, last_name, address, city, postal, country, state, phone, subtotal, tax, total, created_at
  ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");
  
  $orderStmt->bind_param(
    "isssssssssddd",
    $user_id,
    $email,
    $first_name,
    $last_name,
    $address,
    $city,
    $postal,
    $country,
    $state,
    $phone,
    $subtotal,
    $tax,
    $total
  );
  
  $orderStmt->execute();
  $order_id = $conn->insert_id;
  

// Save order items
foreach ($cart as $item) {
    $stmt = $conn->prepare("SELECT price FROM products WHERE id = ?");
    $stmt->bind_param("i", $item['product_id']);
    $stmt->execute();
    $price = $stmt->get_result()->fetch_assoc()['price'];

    $itemStmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, size, quantity, price) VALUES (?, ?, ?, ?, ?)");
    $itemStmt->bind_param("iisid", $order_id, $item['product_id'], $item['size'], $item['quantity'], $price);
    $itemStmt->execute();

    $stockUpdate = $conn->prepare("UPDATE product_sizes SET stock = stock - ? WHERE product_id = ? AND size = ?");
    $stockUpdate->bind_param("iis", $item['quantity'], $item['product_id'], $item['size']);
    $stockUpdate->execute();
}

// Optionally store shipping info in a new table
// Clear cart
unset($_SESSION['cart']);

// Redirect
header("Location: confirm.php?order_id=" . $order_id);
exit;
?>
