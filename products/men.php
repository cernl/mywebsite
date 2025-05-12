<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header('Location: ../auth/login.php');
  exit;
}
include '../includes/header.php';
include '../includes/db.php';

$sql = "SELECT * FROM products WHERE gender = 'men'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Men's Streetwear - My Essence</title>
  <link rel="stylesheet" href="../assets/css/main.css">
  <link rel="stylesheet" href="../assets/css/product.css">
  <link rel="stylesheet" href="../assets/css/style.css">

  <script src="../assets/js/filter.js" defer></script>
</head>
<body>

<main class="catalog-page">
  <!-- Sidebar Categories -->
  <aside class="catalog-sidebar">
    <h3>CATEGORIES</h3>
    <div id="categoryFilters">
      <button data-category="" class="category-btn">All</button>
      <button data-category="tops" class="category-btn">Tops</button>
      <button data-category="bottoms" class="category-btn">Bottoms</button>
      <button data-category="shoes" class="category-btn">Shoes</button>
      <button data-category="accessories" class="category-btn">Accessories</button>
    </div>
  </aside>

  <!-- Product Grid -->
  <section class="catalog-grid">
    <?php if ($result->num_rows > 0): ?>
      <?php while ($row = $result->fetch_assoc()): ?>
        <div class="product-card" data-category="<?= $row['category']; ?>">
          <a href="view.php?id=<?= $row['id']; ?>">
            <img src="../assets/images/<?= htmlspecialchars($row['image']); ?>" alt="<?= htmlspecialchars($row['name']); ?>">
            <p class="brand-name"><?= htmlspecialchars($row['brand']); ?></p>
            <p class="product-name"><?= htmlspecialchars($row['name']); ?></p>
            <p class="product-price">$<?= number_format($row['price'], 2); ?></p>
          </a>
        </div>
      <?php endwhile; ?>
    <?php else: ?>
      <p>No products found.</p>
    <?php endif; ?>
  </section>
</main>

<?php include '../includes/footer.php'; ?>
</body>
</html>
