<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include '../includes/db.php';

$order_id = $_GET['order_id'] ?? null;
if (!$order_id || !isset($_SESSION['user_id'])) {
    echo "Order not found or unauthorized access.";
    exit;
}

// Get order info
$orderStmt = $conn->prepare("SELECT * FROM orders WHERE id = ? AND user_id = ?");
$orderStmt->bind_param("ii", $order_id, $_SESSION['user_id']);
$orderStmt->execute();
$order = $orderStmt->get_result()->fetch_assoc();

// Get order items
$itemStmt = $conn->prepare("
    SELECT p.name, oi.size, oi.quantity, oi.price
    FROM order_items oi
    JOIN products p ON p.id = oi.product_id
    WHERE oi.order_id = ?
");
$itemStmt->bind_param("i", $order_id);
$itemStmt->execute();
$items = $itemStmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Order Confirmation</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f5f2ea;
      color: #333;
      margin: 0;
      padding: 0;
    }

    .container {
      max-width: 800px;
      margin: 2em auto;
      background: white;
      padding: 2em;
      border-radius: 8px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    h2, h3 {
      font-weight: 500;
    }

    .order-info {
      margin-top: 1em;
    }

    .item {
      border-bottom: 1px solid #ddd;
      padding: 1em 0;
      display: flex;
      justify-content: space-between;
    }

    .totals {
      margin-top: 2em;
      font-size: 1.1em;
    }

    .totals p {
      margin: 0.5em 0;
    }

    .btn {
      display: inline-block;
      margin-top: 2em;
      background-color: #6b4d37;
      color: white;
      padding: 0.75em 1.5em;
      border-radius: 4px;
      text-decoration: none;
      font-weight: bold;
    }

    .btn:hover {
      background-color: #5b3f2f;
    }
  </style>
</head>
<body>

<div class="container">
  <h2>Thank you for your order!</h2>
  <p>Your order #<?= $order_id ?> has been placed.</p>
  <p>A confirmation has been sent to <strong><?= htmlspecialchars($order['email']) ?></strong>.</p>

  <div class="order-info">
    <h3>Order Summary</h3>
    <?php while ($item = $items->fetch_assoc()): ?>
      <div class="item">
        <div>
          <strong><?= htmlspecialchars($item['name']) ?></strong><br>
          Size: <?= $item['size'] ?> × <?= $item['quantity'] ?>
        </div>
        <div>
          $<?= number_format($item['price'] * $item['quantity'], 2) ?>
        </div>
      </div>
    <?php endwhile; ?>
  </div>

  <div class="totals">
    <p>Subtotal: $<?= number_format($order['subtotal'], 2) ?></p>
    <p>Tax (8.875%): $<?= number_format($order['tax'], 2) ?></p>
    <p><strong>Total Paid: $<?= number_format($order['total'], 2) ?></strong></p>
  </div>

  <a href="../index.php" class="btn">Continue Shopping</a>
</div>

</body>
</html>
