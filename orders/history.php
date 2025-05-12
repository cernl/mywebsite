<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

include '../includes/db.php';
include '../includes/header.php';

$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$orders = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Order History</title>
  <link rel="stylesheet" href="../assets/css/style.css">
  <style>
    .order-history-container {
      max-width: 800px;
      margin: 3em auto;
      background: #fff;
      padding: 2em;
      border-radius: 12px;
      box-shadow: 0 4px 14px rgba(0,0,0,0.05);
    }

    .order-item {
      border-bottom: 1px solid #e2e2e2;
      padding: 1.5em 0;
    }

    .order-item:last-child {
      border-bottom: none;
    }

    .order-title {
      font-size: 1em;
      font-weight: 600;
      color: #222;
    }

    .order-date {
      font-size: 0.9em;
      color: #888;
      margin-bottom: 0.5em;
    }

    .order-total {
      font-size: 0.95em;
      margin-bottom: 0.5em;
    }

    .shipping-info {
      font-size: 0.9em;
      color: #444;
      line-height: 1.4;
    }
  </style>
</head>
<body>

<div class="order-history-container">
  <h2 style="font-size: 1.4em; font-weight: 500; margin-bottom: 1.2em;">Your Order History</h2>
    
  <?php if ($orders->num_rows === 0): ?>
    <p>You have not placed any orders yet.</p>
  <?php else: ?>
    <?php while ($order = $orders->fetch_assoc()): ?>
        <div class="order-item">
        <div class="order-title">Order #<?= $order['id'] ?></div>
        <div class="order-date"><?= date("F j, Y", strtotime($order['created_at'])) ?></div>
        <div class="order-total"><strong>Total:</strong> $<?= number_format($order['total'], 2) ?></div>
        <div class="shipping-info">
            <?= htmlspecialchars($order['first_name'] . ' ' . $order['last_name']) ?><br>
            <?= htmlspecialchars($order['address']) ?><br>
            <?= htmlspecialchars($order['city']) ?>, <?= htmlspecialchars($order['state']) ?> <?= htmlspecialchars($order['postal']) ?>
        </div>
        <div style="margin-top: 0.7em;">
            <a href="order_details.php?id=<?= $order['id'] ?>" class="btn-brown" style="font-size: 0.85em;">View Details</a>
        </div>
        </div>

    <?php endwhile; ?>
  <?php endif; ?>
</div>

<?php include '../includes/footer.php'; ?>
</body>
</html>
