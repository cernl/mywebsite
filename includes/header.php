<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
?>
<header>
  <link rel="stylesheet" href="../assets/css/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <style>
    header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 1em 2em;
      background: #fff;
      border-bottom: 1px solid #eee;
      font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
    }

    header h2 {
      font-weight: 500;
      margin: 0;
    }

    nav {
      display: flex;
      align-items: center;
      gap: 1.5em;
    }

    nav a {
      text-decoration: none;
      color: #111;
      font-size: 0.95em;
      transition: color 0.2s ease;
    }

    nav a:hover {
      color: #6b4d37;
    }

    .nav-right {
      margin-left: auto;
      display: flex;
      gap: 1em;
      align-items: center;
    }

    .nav-right span {
      font-size: 0.9em;
      color: #555;
    }
  </style>

  <h2>MODVUE</h2>

  <nav>
    <a href="/mywebsite/index.php">Home</a>
    <a href="/mywebsite/products/men.php">Men</a>
    <a href="/mywebsite/products/women.php">Women</a>
    <a href="/mywebsite/cart/view.php">Cart</a>
    <a href="/mywebsite/orders/history.php">Order History</a>

    <div class="nav-right">
      <?php if (isset($_SESSION['user_id'])): ?>
        <span>Welcome, <?= htmlspecialchars($_SESSION['user_name']) ?>!</span>
        <a href="/mywebsite/auth/logout.php">Logout</a>
      <?php else: ?>
        <a href="/mywebsite/auth/login.php">Login</a>
        <a href="/mywebsite/auth/register.php">Register</a>
      <?php endif; ?>
    </div>
  </nav>
</header>
