<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="styling\style.css">
  <title>Reset Password | SmartPay</title>
</head>
<body>
  <div class="container">
    <h2>Reset Your Password</h2>
    <form action="updatePassword.php" method="POST">
      <input type="hidden" name="token" value="<?php echo $_GET['token']; ?>">
      <label for="newPassword">New Password:</label>
      <input type="password" id="newPassword" name="newPassword" required>
      <input type="submit" value="Update Password">
    </form>
  </div>
</body>
</html>
