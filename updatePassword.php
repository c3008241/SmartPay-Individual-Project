<?php



if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $token = $_POST['token'];
    $newPassword = password_hash($_POST['newPassword'], PASSWORD_DEFAULT);

    $conn = new mysqli('localhost', 'root', '', 'smartpay');
    
    $stmt = $conn->prepare("SELECT email FROM password_resets WHERE token = ? AND expiry > NOW()");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($email);
        $stmt->fetch();

        $stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
        $stmt->bind_param("ss", $newPassword, $email);
        $stmt->execute();

        echo "Password updated successfully!";
    } else {
        echo "Invalid or expired token.  THIS IS BECAUSE THE SYSTEM ONLY TAKES TOKEN INPUTS TO UPDATE INTO THE DATABASE, THIS INPUT WAS A STRING NOT A TOKEN";
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
  <title>Update Password | SmartPay</title>
</head>
<body>
  <div class="container">
    <h2>Update Your Password</h2>
    <form action="updatePassword.php" method="POST">
      <input type="hidden" name="token" value="<?php echo htmlspecialchars($_GET['token']); ?>">
      <input type="hidden" name="token" value="<?php echo htmlspecialchars($_GET['token']); ?>">
      <label for="newPassword">Enter your new password:</label>
      <input type="password" id="newPassword" name="newPassword" required>
      <input type="submit" class="logInSignUp" value="Update Password">
    </form>
  </div>
</body>
</html>