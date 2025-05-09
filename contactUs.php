<?php 
include 'connect.php';
include 'session.php';
$conn = connectDB();
session_start();

// $isLoggedIn= false;

// if (isset($_SESSION['user_ID'])){
//   $isLoggedIn= true;
  
//   }
// $user_ID = $_SESSION['user_ID'];
// $query = "SELECT u.userType
//                     FROM users AS u
//                     WHERE u.user_ID = $user_ID";



//                     $result = $conn->query($query);

                    
//               if ($result->num_rows > 0) {
//                 while ($row = $result->fetch_assoc()) {
                      
//                 $userType = $row['userType'];
//               }
//           }


    $isLoggedIn= false;


    if (isset($_SESSION['user_ID'])) {
      $user_ID = $_SESSION['user_ID'];
      $isLoggedIn= true;

        
            // Sanitize for safety (basic example)
      $user_ID = intval($user_ID);
        
            // Your query
      $query = "SELECT u.userType FROM users AS u WHERE u.user_ID = $user_ID";
      $result = $conn->query($query); 
        
        if ($result && $result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
              $userType = $row['userType'];
          }
        } else {
                echo "No user found or query failed.";
        }
    } 
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="styling/headerAndFooter.css">
  <link rel="stylesheet" href="styling/style.css">
  <link rel="stylesheet" href="styling/mobile.css">
  <script src = "scripting/app.js"></script>
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
    
    <nav class = "userNav"> 
    <ul>
      <li>
    <img src="images/userIcon.png"  onclick="showLogOut()" id="userIcon"  height="43" width="50">
      </li>
      <li>
        <a href="moneyBalance.php"> ACCOUNT</a>
      </li>
      <li>
        <a id="logOut" href="logOut.php"> LOG OUT</a>
      </li>

    </ul>
  </nav>

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
      if ($userType == 'Business Owner'){
        echo'<li><a href="invest.php">INVEST |</a></li>';
      }
    echo'
    <li><a href="moneyBalance.php">BALANCE |</a></li>
    <li><a href="transactionHistory.php">TRANSACTION HISTORY |</a></li>
    ';
    }
   ?>


    <li><a href="contactUs.php">CONTACT US |</a></li>

  
  </ul>
</nav>

     
<div class="hero">
  <div id="contactUsTitle">
    <h1>Contact Us</h1>
    <p>Have questions, suggestions, or issues? We're here to help! Reach out to our support team anytime.</p>
    
    <div class="contactDetails">
      <p><strong>Email:</strong> <a href="mailto:support@smartpay.com">support@smartpay.com</a></p>
      <p><strong>Phone:</strong> <a href="tel:+1234567890">+1 (234) 567-890</a></p>
      <p><strong>Live Chat:</strong> Available Monday to Friday, 9am - 5pm (GMT)</p>
    </div>

    <div class="ctaMessage">
      <p>We usually respond within 24 hours. Your satisfaction is our priority!</p>
    </div>
  </div>

  <img id="smartPayImg" src="images/smartPayImg.jpg" alt="SmartPay Team">
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