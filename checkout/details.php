<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_email'])) {
    header('Location: ../auth/login.php');
    exit;
}

include '../includes/header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Checkout - My Essence</title>
  <style>
    body {
      font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
      background-color: #f5f2ea;
      color: #222;
      margin: 0;
      padding: 0;
    }

    main {
      max-width: 800px;
      margin: 2em auto;
      background: #fff;
      padding: 2em;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
      border-radius: 8px;
    }

    h2, h3 {
      margin-top: 0;
      font-weight: 500;
    }

    form {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 1.5em;
    }

    form label {
      font-weight: bold;
      margin-bottom: 0.2em;
      display: block;
    }

    form input, form select {
      width: 100%;
      padding: 0.6em;
      border: 1px solid #ccc;
      border-radius: 4px;
      background: #fff;
      box-sizing: border-box;
    }

    .full-width {
      grid-column: 1 / -1;
    }

    button {
      background-color: #6b4d37;
      color: white;
      border: none;
      padding: 1em 2em;
      font-weight: bold;
      cursor: pointer;
      border-radius: 4px;
      grid-column: 1 / -1;
      text-align: center;
    }

    button:hover {
      background-color: #5b3f2f;
    }
  </style>
</head>
<body>

<main>
  <h2>Checkout</h2>

  <form method="POST" action="process.php">
    <div class="full-width"><h3>Shipping Address</h3></div>

    <div>
      <label>First Name</label>
      <input type="text" name="first_name" required>
    </div>
    <div>
      <label>Last Name</label>
      <input type="text" name="last_name" required>
    </div>
    <div class="full-width">
      <label>Street Address</label>
      <input type="text" name="address" required>
    </div>
    <div>
      <label>City</label>
      <input type="text" name="city" required>
    </div>
    <div>
      <label>ZIP Code</label>
      <input type="text" name="postal" required>
    </div>
    <div>
      <label>Country/Region</label>
      <select name="country" required>
        <option value="US">United States</option>
      </select>
    </div>
    <div>
      <label>State</label>
      <select name="state" required>
        <option value="NY">New York</option>
        <option value="CA">California</option>
        <option value="TX">Texas</option>
        <option value="FL">Florida</option>
        <option value="IL">Illinois</option>
        <option value="PA">Pennsylvania</option>
        <option value="OH">Ohio</option>
        <option value="GA">Georgia</option>
        <option value="NC">North Carolina</option>
        <option value="MI">Michigan</option>
        <option value="NJ">New Jersey</option>
        
      </select>
    </div>
    <div class="full-width">
      <label>Phone</label>
      <input type="text" name="phone" required>
    </div>

    <div class="full-width"><h3>Payment</h3></div>

    <div class="full-width">
      <label>Cardholder's Name</label>
      <input type="text" name="card_name" required>
    </div>
    <div class="full-width">
      <label>Card Number</label>
      <input type="text" name="card_number" required>
    </div>
    <div>
      <label>Expiration Date (MM/YY)</label>
      <input type="text" name="expiry" required>
    </div>
    <div>
      <label>CVV</label>
      <input type="text" name="cvv" required>
    </div>

    <button type="submit">PLACE ORDER</button>
  </form>
</main>

</body>
</html>

<?php include '../includes/footer.php'; ?>
