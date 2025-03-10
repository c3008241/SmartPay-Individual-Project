<?php 
session_start();
include("connect.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="styling\headerAndFooter.css">
  <link rel="stylesheet" href="styling\style.css">
  <link rel ="icon" href="images/smartPayLogo.png" >
  <title>Home Page | SmartPay</title>
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

    <div>
    <img src="images/userIcon.png" id="userIcon">
    <a href="logOut.php">Log Out</a>
    </div>
    </header>

    <nav class="navBar">
      <ul>
        <li><a href="homePage.php">HOME |</a></li>
        <li><a href="invest.php">INVEST |</a></li>
        <li><a href="moneyBalance.php">PAYMENTS |</a></li>
        <li><a href="transactionHistory.php">TRANSACTION HISTORY |</a></li>
        <li><a href="contactUs.php">CONTACT US</a></li>
      </ul>
    </nav>




  <main>

  <p>first commit test</p>
  
    <div class="title">
      <h1>Welcome Back <?php
      if(isset($_SESSION['email'])){
        $email = $_SESSION['email'];
        $query = mysqli_query($conn, "SELECT * FROM users WHERE users.email = '$email'");
        while($row = mysqli_fetch_array($query)){
          echo $row['firstName'].' '.$row['lastName'];
        }
      }
      ?>
      !! :)
      </h1>
    </div>

   


    <div class="mainContent">
<a href="logIn.html">
<p>Are you a Tourist?</p>
</a>

<a href="logIn.html">
<p>Are you a Business Owner?</p>
</a>


<a href="logIn.html">
<p>Personal</p>
</a>
</div>


<div class="dontHaveAnAccount">
<a>Dont have an account?</a>
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