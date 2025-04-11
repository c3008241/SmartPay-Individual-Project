<?php 
include 'connect.php';
include 'session.php';
$conn = connectDB();
session_start();

$isLoggedIn= false;

if (isset($_SESSION['user_ID'])){
  $isLoggedIn= true;
  $userType = $_SESSION['userType'];
  echo $userType;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="styling/headerAndFooter.css">
  <link rel="stylesheet" href="styling/style.css">
  <link rel ="icon" href="images/smartPayLogo.png" >
  <title>Contact Us | SmartPay</title>
</head>
<body>
  <div class="container">
    <header>
    <div class="logoWrapper">

      <a href="index.php" id="smartPayLogo">
       <img src="images/smartPayLogo.png"  height="50" width="50">
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
    <?php
    if ($isLoggedIn){
      echo '<a href="logOut.php" id="logOut">Log Out</a>';
    } else {
      echo '<a href="logIn.php" id="logIn">Log In</a>';
    }
    ?>

  
    
      
   
    </header>
    <nav class="navBar">
  <ul>
  <?php 
    if (!$isLoggedIn){
    echo '<li><a href="index.php">HOME |</a></li>
    <li><a href="signUp.php">SIGN UP |</a></li>
    <li><a href="logIn.php">LOG IN |</a></li>';
    }
    else{
    echo'<li><a href="invest.php">INVEST |</a></li>
    <li><a href="moneyBalance.php">PAYMENTS |</a></li>
    <li><a href="transactionHistory.php">TRANSACTION HISTORY |</a></li>';
    }
   ?>


    <li><a href="contactUs.php">CONTACT US</a></li>
  </ul>
</nav>
     
<div class="hero">

  <main>
    <div id="contactUsTitle">
      <h1>Contact Us</h1>
    </div>

 

  </main>
  <img id="smartPayImg" src="images/smartPayImg.jpg" alt="">

</div>

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