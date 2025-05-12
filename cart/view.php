<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
  }
  
include '../includes/header.php';
include '../includes/db.php';

$cart = $_SESSION['cart'] ?? [];
$total = 0;
?>

<main style="display: flex; justify-content: space-between; gap: 2em; padding: 2em;">
<link rel="stylesheet" href="../assets/css/style.css">  
<section style="flex: 2;">
    <h2 style="margin-bottom: 1em;">SHOPPING BAG</h2>
    <hr>

    <?php if (empty($cart)): ?>
      <p>Your cart is empty.</p>
    <?php else: ?>
      <?php foreach ($cart as $key => $item): ?>
        <?php
        $stmt = $conn->prepare("SELECT name, price, image FROM products WHERE id = ?");
        $stmt->bind_param("i", $item['product_id']);
        $stmt->execute();
        $product = $stmt->get_result()->fetch_assoc();
        $subtotal = $item['quantity'] * $product['price'];
        $total += $subtotal;
        ?>
        <div style="display: flex; align-items: center; margin-bottom: 2em; border-bottom: 1px solid #ddd; padding-bottom: 1em;">
        <a href="../products/view.php?id=<?= $item['product_id']; ?>">
            <img src="../assets/images/<?= htmlspecialchars($product['image']); ?>" alt="<?= $product['name']; ?>" width="100" style="border-radius: 4px; ">
            </a>

          <div style="flex: 1; padding: 1em;">
          <p style="font-weight: bold;  ">
            <a href="../products/view.php?id=<?= $item['product_id']; ?>" style="color: inherit; text-decoration: none;">
                <?= htmlspecialchars($product['name']); ?>
            </a>
            </p>

            <p>Size: <?= $item['size']; ?></p>
            <p>Qty: <?= $item['quantity']; ?></p>
            <a href="remove.php?key=<?= urlencode($key); ?>" style="color: #6b4d37;">Remove</a>
          </div>
          <div style="text-align: right; font-weight: bold;">
            $<?= number_format($subtotal, 2); ?>
          </div>
        </div>
      <?php endforeach; ?>

      <div style="text-align: right; margin-top: 1em;">
        <p><strong>Total:</strong> $<?= number_format($total, 2); ?></p>
        <p><strong>Shipping:</strong> Calculated at Checkout</p>
        <p style="font-size: 1.2em;"><strong>Order Total:</strong> $<?= number_format($total, 2); ?></p>
      </div>
    <?php endif; ?>
  </section>

  <section style="flex: 1; background: #f9f9f9; padding: 1.5em; border-radius: 8px; height: fit-content;">
    <h3>CHECKOUT</h3>
    <form action="/mywebsite/checkout/details.php" method="POST">
      <button type="submit" class="btn-brown" style="width: 100%; padding: 1em; font-weight: bold;">PROCEED TO CHECKOUT</button>
    </form>
  </section>
</main>

<?php include '../includes/footer.php'; ?>
