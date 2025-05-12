<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$message = '';

if (isset($_SESSION['flash_message'])) {
    $message = $_SESSION['flash_message'];
    unset($_SESSION['flash_message']);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include '../includes/db.php';

    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, name, email, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];

            header('Location: ../index.php');
            exit;
        } else {
            $message = "Incorrect password.";
        }
    } else {
        $message = "No user found with that email.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login - My Essence</title>
  <link rel="stylesheet" href="../assets/css/style.css">

</head>
<body>
  <div class="auth-form">
    <h2>Login</h2>
    <?php if (!empty($message)): ?>
      <p style="color: <?= isset($_SESSION['user_id']) ? 'green' : 'red'; ?>"><?= $message; ?></p>
    <?php endif; ?>
    <form method="POST" action="">
      <input type="email" name="email" placeholder="Email" required>
      <input type="password" name="password" placeholder="Password" required>
      <button class="btn-brown" type="submit">Login</button>
    </form>
    <p>Don't have an account? <a href="register.php">Register here</a>.</p>
  </div>
</body>
</html>
