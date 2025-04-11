<?php
session_start();
include 'connect.php';
// $isloggedin = false;
// if (isset($_SESSION["user_id"])) {
//     $isloggedin = true;
//     $email = $_SESSION['email'];
//     $firstName = $_SESSION['firstName'];
//     $lastName = $_SESSION['lastName'];
// }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="styling/headerAndFooter.css">
  <link rel="stylesheet" href="styling/style.css">
  <link rel="icon" href="images/smartPayLogo.png">
  <title>Home Page | SmartPay</title>
</head>
<body>
  <div class="container">
    <header>
      <div class="logoWrapper">
        <a href="index.php" id="smartPayLogo">
          <img src="images/smartPayLogo.png" height="50" width="50">
        </a>
        <div class="logoText">
          <p>SmartPay</p>
          <p>Banking Made Simple</p>
        </div>
      </div>
      <div class="searchBar">
        <input class="searchBar" placeholder="Search &#x1F50E;">
      </div>
      <img src="images/userIcon.png" id="userIcon">
      <!-- <?php if ($isloggedin): ?>
        <a href="logout.php">Log out</a>
      <?php else: ?>
        <a href="logIn.php">Log in</a>
      <?php endif; ?>
    </header>
    <nav class="navBar">
      <ul>
        <li><a href="homePage.php">HOME |</a></li>
        <?php if ($isloggedin): ?>
          <li><a href="invest.php">INVEST |</a></li>
          <li><a href="moneyBalance.php">PAYMENTS |</a></li>
          <li><a href="transactionHistory.php">TRANSACTION HISTORY |</a></li>
          <li><a href="contactUs.php">CONTACT US</a></li>

        <?php else: ?>
          <li><a href="signUp.php">SIGN UP |</a></li>
          <li><a href="logIn.php">LOG IN |</a></li>
        <?php endif; ?>
        <li><a href="contactUs.php">CONTACT US</a></li>
      </ul> -->
    </nav>

    <?php if ($isloggedin): ?>
      <p>Welcome back, <?php echo htmlspecialchars($firstName . ' ' . $lastName); ?>!</p>
    <?php endif; ?>

    <main>
      <div class="title">
        <h1>Welcome To SmartPay</h1>
      </div>
      <div class="mainContent">
        <a href="logIn.php">
          <p>Are you a Tourist?</p>
        </a>
        <a href="logIn.php">
          <p>Are you a Business Owner?</p>
        </a>
        <a href="logIn.php">
          <p>Personal</p>
        </a>
      </div>
      <div class="dontHaveAnAccount">
        <a>Don't have an account?</a>
        <a href="signUp.php" class="createAccountText"> Create an account</a>
      </div>
    </main>
    <footer>
      <div class="footerItems">
        <div id="copyRight">
          Copyright &#169;
        </div>
        <div class="smartPayEmails">
          <a href="">info@smartpay.com</a>
          <a href="">contact@smartpay.com</a>
        </div>
      </div>
    </footer>
  </div>
</body>
</html>