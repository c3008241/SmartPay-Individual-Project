<?php 
include 'connect.php';
include 'session.php';
$conn = connectDB();


 
$path = "logIn.php"; //this path is to pass to checkSession function from session.php 
    
session_start(); //must start a session in order to use session in this page.
if (!isset($_SESSION['user_ID'])){
  session_unset();
  session_destroy();
  header("Location:".$path);//return to the login page
}
$email = $_SESSION['email']; //this value is obtained from the login page when the user is verified
$user_ID = $_SESSION['user_ID']; //this value is obtained from the login page when the user is verified
checkSession ($path); //calling the function from session.php

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="styling/headerAndFooter.css">
  <link rel="stylesheet" href="styling/style.css">
  <link rel ="icon" href="images/smartPayLogo.png" >
  <title>Invest | SmartPay</title>
</head>
<body>
  <div class="container">
    <header>
    <div class="logoWrapper">

      <a href="homePage.html" id="smartPayLogo">
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

   

     <a href="logOut.php" > Log out</a>
    
    </header>

    

    <nav class="navBar">
      <ul>
        <li><a href="invest.php">INVEST |</a></li>
        <li><a href="moneyBalance.php">PAYMENTS |</a></li>
        <li><a href="transactionHistory.php">TRANSACTION HISTORY |</a></li>
        <li><a href="contactUs.php">CONTACT US</a></li>
      </ul>
      
    </nav>




  <main>
    <div class="title">
      <h1>Invest</h1>
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