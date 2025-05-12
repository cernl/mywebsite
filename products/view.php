<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header('Location: ../auth/login.php');
  exit;
}
include '../includes/header.php';
include '../includes/db.php';

$id = $_GET['id'] ?? null;
if (!$id) {
  echo "<p>Product not found.</p>";
  exit;
}

$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$product = $stmt->get_result()->fetch_assoc();

$sizeStmt = $conn->prepare("SELECT size, stock FROM product_sizes WHERE product_id = ? ORDER BY size ASC");
$sizeStmt->bind_param("i", $id);
$sizeStmt->execute();
$sizes = $sizeStmt->get_result()->fetch_all(MYSQLI_ASSOC);
?>

<main>
<link rel="stylesheet" href="../assets/css/style.css">
  <div class="product-detail" style="display: flex; gap: 2em; padding: 2em; max-width: 1000px; margin: auto;">
    <img src="../assets/images/<?= htmlspecialchars($product['image']); ?>" alt="<?= htmlspecialchars($product['name']); ?>" width="400" style="border-radius: 8px;">
    <div style="max-width: 500px;">
      <h2><?= htmlspecialchars($product['name']); ?></h2>
      <p class="brand-name"><?= htmlspecialchars($product['brand']); ?></p>
      <p style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-weight: bold; margin-bottom: 1em;">$<?= number_format($product['price'], 2); ?></p>
      <p><?= nl2br(htmlspecialchars($product['description'])); ?></p>
      <p><strong>Category:</strong> <?= htmlspecialchars($product['category']); ?></p>
      
      <form method="POST" action="../cart/add.php">
        <label for="size"><strong>Select a Size:</strong></label>
        <select name="size" id="size" required style="width: 100%; padding: 0.5em; margin: 0.5em 0;">
          <option value="">-- Select a Size --</option>
          <?php foreach ($sizes as $row): ?>
            <option value="<?= $row['size']; ?>" <?= $row['stock'] <= 0 ? 'disabled' : '' ?>>
              <?= "US " . $row['size'] . ($row['stock'] <= 0 ? " - Sold Out" : " - Only {$row['stock']} remaining") ?>
            </option>
          <?php endforeach; ?>
        </select>
        
        <input type="hidden" name="product_id" value="<?= $product['id']; ?>">
        <button type="submit" class="btn-brown" <?= empty($sizes) ? 'disabled' : '' ?>>Add to Cart</button>
      </form>
    </div>
  </div>
</main>

<?php include '../includes/footer.php'; ?>
