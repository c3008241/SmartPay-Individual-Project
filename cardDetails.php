<?php
include "connect.php"; 
include "encryption.php";
session_start(); 


$isLoggedIn = isset($_SESSION['email']);

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="styling\headerAndFooter.css">
  <link rel="stylesheet" href="styling\style.css">
  <script src = "scripting/app.js"></script>
  <link rel="icon" href="images/smartPayLogo.png">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
    integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <title>Register | SmartPay</title>
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
    </header>

    <nav class="navBar">
    <ul>
    <?php 
    
    
    
    
    if ($isLoggedIn) {
        
        echo '
        <li><a href="invest.php">INVEST |</a></li>
        <li><a href="moneyBalance.php">PAYMENTS |</a></li>
        <li><a href="transactionHistory.php">TRANSACTION HISTORY |</a></li>';
    } else {
      
        echo '
        <li><a href="index.php">HOME |</a></li>
        <li><a href="signUp.php">SIGN UP |</a></li>
        <li><a href="logIn.php">LOG IN |</a></li>';
    }
    ?>
    <li><a href="contactUs.php">CONTACT US</a></li>
    </ul>
</nav>


  <main>
   
      
      <div class="cardDetails">

          <div class="title">
            <h1>Add Card Details</h1>
          </div>

          <form  method="post" action="register.php" >


          <div class="inputGroup">
            <i class="fas fa-dollar"></i>
            <label for="cardNumber">Card Number:</label>
            <input type="text"  oninput="convertToInt()" class="changeToInt" name="cardNumber"  maxlength="16"     placeholder="0000 0000 0000 0000 (e.g 1234 5678 9101 1121)">
          </div>


          <div class="inputGroup">
            <i class="fas fa-bank"></i>
            <label for="accountNumber">Account Number :</label>
            <input type="text" oninput="convertToInt()" class="changeToInt"  name="accountNumber"  maxlength="8"  placeholder="00000000 (93127447)" >
          </div>
            

          <div class="inputGroup">
            <i class="fas fa-bank"></i>
            <label for="sortCode">Sort code:</label>
            <input type="text"  name="sortCode"  oninput="convertToInt()" class="changeToInt"  maxlength="6" placeholder="00-00-00 (93-12-74)" >
          </div>

         

          <div class="inputGroup">
            <i class="fas fa-user"></i>
            <label for="expirationDate">Expiration Date:</label>
            <input type="date"  name="expiraryDate" >
          </div> 


          <div class="inputGroup">
            <i class="fas fa-bank"></i>
            <label for="cvv">CVV:</label>
            <input type="text" oninput="convertToInt()" class="changeToInt" maxlength="3" name="cvv"  required placeholder="000 (e.g 173)">
          </div>
          
  


          <input type="submit" class="logInSignUp" id="signUp" name="register" value="Sign Up">


    </form>





      <div class="alreadyHaveAnAccount">
        <a>Already have an account?</a>
        <a href="logIn.php" class="createAccountText"> Log in</a>
      </div>

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