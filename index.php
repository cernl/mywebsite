<?php
include 'includes/header.php';
include 'includes/db.php';
?>

<link rel="stylesheet" href="assets/css/style.css">
<main style="padding: 2em;">
  <!-- Hero Banner -->
  <section class="hero" style="text-align: center; margin-bottom: 3em;">
    <h1 style="font-size: 2.5em; font-weight: 600;">Luxury Streetwear</h1>
    <p style="font-size: 1.1em; color: #555;">Explore exclusive high-end fashion for Men & Women.</p>
  </section>

  <!-- Featured Products -->
  <section class="featured-products">
    <h2 style="font-size: 1.4em; font-weight: 500; margin-bottom: 1.2em;">New Arrivals</h2>

    <div class="catalog-grid">
      <?php
      $sql = "SELECT * FROM products ORDER BY created_at DESC LIMIT 6";
      $result = $conn->query($sql);

      if ($result->num_rows > 0):
        while ($row = $result->fetch_assoc()):
      ?>
        <div class="product-card">
          <a href="products/view.php?id=<?= $row['id']; ?>">
            <img src="assets/images/<?= htmlspecialchars($row['image']); ?>" alt="<?= htmlspecialchars($row['name']); ?>">
            <p class="brand-name">   </p>
            <p class="product-name"><?= htmlspecialchars($row['name']); ?></p>
            <p class="product-price">$<?= number_format($row['price'], 2); ?></p>
          </a>
        </div>
      <?php
        endwhile;
      else:
        echo "<p>No products found.</p>";
      endif;
      ?>
    </div>
  </section>
</main>

<?php include 'includes/footer.php'; ?>
