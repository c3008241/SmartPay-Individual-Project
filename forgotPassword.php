<?php 
session_start();
include 'connect.php';
$conn = connectDB();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'];

    // Check if the email exists in the database
    $stmt = $conn->prepare("SELECT email FROM users WHERE email = ?");
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Email exists, display a message and redirect after 5 seconds
        $message = "Email address found. Redirecting to update password page in 5 seconds...";
        header("refresh:5;url=updatePassword.php?email=" . urlencode($email));
    } else {
        // Email does not exist, display an error message
        $error = "Email address not found.";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="styling/style.css">
  <title>Forgot Password | SmartPay</title>
</head>
<body>
  <div class="container">
    <h2>Reset Your Password</h2>
    <?php if (isset($message)): ?>
      <p style="color: green;"><?php echo $message; ?></p>
    <?php elseif (isset($error)): ?>
      <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>
    <form action="forgotPassword.php" method="POST">
      <label for="email">Enter your email address:</label>
      <input type="email" id="email" name="email" required>
      <input type="submit" class="logInSignUp" value="Send Reset Link">
    </form>
    <a href="index.php">Back to Login</a>
  </div>
</body>
</html>