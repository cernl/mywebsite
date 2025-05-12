<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $product_id = $_POST['product_id'];
  $size = $_POST['size'];

  if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
  }

  $key = $product_id . '-' . $size;

  if (isset($_SESSION['cart'][$key])) {
    $_SESSION['cart'][$key]['quantity'] += 1;
  } else {
    $_SESSION['cart'][$key] = [
      'product_id' => $product_id,
      'size' => $size,
      'quantity' => 1
    ];
  }

  header('Location: view.php');
  exit;
}
?>
