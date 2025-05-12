<?php
session_start();
include '../includes/db.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $confirm = $_POST['confirm'];

  if ($password !== $confirm) {
    $message = "Passwords do not match.";
  } else {
    $hashed = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $hashed);

    if ($stmt->execute()) {
      $_SESSION['flash_message'] = "Account created successfully. Please log in.";
      header('Location: login.php');
      exit;
    } else {
      $message = "Error: " . $conn->error;
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Register - My Essence</title>
  <link rel="stylesheet" href="../assets/css/style.css">

</head>
<body>
  <div class="auth-form">
    <h2>Create Account</h2>
    <?php if (!empty($message)): ?>
      <p style="color: red;"><?= $message; ?></p>
    <?php endif; ?>
    <form method="POST" action="">
      <input type="text" name="name" placeholder="Full Name" required>
      <input type="email" name="email" placeholder="Email" required>
      <input type="password" name="password" placeholder="Password" required>
      <input type="password" name="confirm" placeholder="Confirm Password" required>
      <button class="btn-brown" type="submit">Register</button>
    </form>
    <p>Already have an account? <a href="login.php">Login here</a>.</p>
  </div>
</body>
</html>
