<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header("Location: ../auth/login.php");
  exit;
}

include '../includes/db.php';
include '../includes/header.php';

$order_id = $_GET['id'] ?? null;
$user_id = $_SESSION['user_id'];

if (!$order_id) {
  echo "<p style='padding:2em;'>Order not found.</p>";
  exit;
}

$stmt = $conn->prepare("
  SELECT * FROM orders 
  WHERE id = ? AND user_id = ?
");
$stmt->bind_param("ii", $order_id, $user_id);
$stmt->execute();
$order = $stmt->get_result()->fetch_assoc();

if (!$order) {
  echo "<p style='padding:2em;'>Order not found.</p>";
  exit;
}

$itemStmt = $conn->prepare("
  SELECT p.name, p.image, oi.size, oi.quantity, oi.price 
  FROM order_items oi
  JOIN products p ON p.id = oi.product_id
  WHERE oi.order_id = ?
");
$itemStmt->bind_param("i", $order_id);
$itemStmt->execute();
$items = $itemStmt->get_result();
?>

<main style="max-width: 800px; margin: auto; padding: 2em;">
  <h2 style="margin-bottom: 1em;">Order #<?= $order_id ?> Details</h2>
  <?php while ($item = $items->fetch_assoc()): ?>
    <div style="display: flex; gap: 1.5em; margin-bottom: 2em; align-items: center;">
      <img src="../assets/images/<?= htmlspecialchars($item['image']) ?>" width="100" style="border-radius: 8px;">
      <div>
        <h4 style="margin: 0 0 0.3em;"><?= htmlspecialchars($item['name']) ?></h4>
        <p style="margin: 0;">Size: <?= $item['size'] ?> | Qty: <?= $item['quantity'] ?></p>
        <p style="margin: 0;">$<?= number_format($item['price'], 2) ?></p>
      </div>
    </div>
  <?php endwhile; ?>
  <a href="history.php" style="color:#6b4d37; text-decoration: underline;">← Back to Order History</a>
</main>

<?php include '../includes/footer.php'; ?>
