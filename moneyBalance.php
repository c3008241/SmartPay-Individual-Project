<?php

include 'connect.php';
include 'encryption.php';
include 'session.php';
$conn = connectDB();


 
$path = "logIn.php"; //this path is to pass to checkSession function from session.php 
    
session_start(); //must start a session in order to use session in this page.
if (!isset($_SESSION['user_ID'])){
  session_unset();
  session_destroy();
  header("Location:".$path);//return to the login page
}

$user_ID = $_SESSION['user_ID'];
$query = mysqli_query($conn, "SELECT * FROM users WHERE user_ID = $user_ID" );
$result = mysqli_fetch_assoc($query);


$userType = $result['userType'];
$firstName = $result['firstName'];
$lastName = $result['lastName'];
$email = $result['email']; //this value is obtained from the login page when the user is verified
 

checkSession ($path); //calling the function from session.php


// if (!isset($_SESSION['userType']) || $_SESSION['userType'] !== 'Business Owner') {
//  echo"you are not a business owner"; 
// }
// else{
//   echo" you are  a business owner";
// }

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="styling/headerAndFooter.css">
  <link rel="stylesheet" href="styling/style.css">
  <script src = "scripting/app.js"></script>
  <link rel ="icon" href="images/smartPayLogo.png" >
  <title> Balance | SmartPay</title>
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

    if($email){
      echo '<a href="logOut.php">Log Out</a>';
    }
    
    ?>


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
    

<div class="userBalance">


<?php 

if(isset($_SESSION['email'])){
$email = $_SESSION['email'];
$query = "SELECT u.userType, cu.currencyCode, cu.symbol , a.balance
                  FROM users AS u
                  INNER JOIN accounts AS a ON u.user_ID = a.user_id 
                  INNER JOIN cards AS ca ON a.card_ID = ca.card_ID
                  INNER JOIN currencies AS cu ON ca.currency_ID = cu.currency_ID 
                  WHERE u.user_ID = $user_ID";
  $result = $conn->query($query);
  if ($result->num_rows > 0){
    while($row = $result->fetch_assoc()){
      echo "<h3>".$row['userType']." &#126; ".$row['currencyCode']." </h3>";
      echo "<h1>".$row['symbol'].$row['balance']."</h1>";

    }
  }
  else{
    echo "You are Broke";
  }
}

  ?>


<?php
  if($userType == "Business Owner"){
    echo "you are a business owner";
    echo $firstName;
    echo $lastName;
    echo $email;
  } else {
    echo "You are not a business owner";
  }
?>


<div class= "balanceButtons">
<button id= "accountButton">Accounts</button>
<div class="moneyBalanceButtons">
<p>Add</p>
<p onclick= "showExchangeMoney()">Exchange</p>
<p onclick="showAccountDetails()">Details</p>
<p onclick="showSendMoney()" >Send</p>
</div>
</div>

    </div>

    <div class="accountDetails">

   <?php 

if(isset($_SESSION['email'])){
  $email = $_SESSION['email'];
  $query = "SELECT *
                    FROM users AS u
                    INNER JOIN accounts AS a ON u.user_ID = a.user_id 
                    INNER JOIN cards AS ca ON a.card_ID = ca.card_ID
                    INNER JOIN currencies AS cu ON ca.currency_ID = cu.currency_ID 
                    WHERE u.user_ID = $user_ID";
    $result = $conn->query($query);
    if ($result->num_rows > 0){
      while($row = $result->fetch_assoc()){
        $fullName = $row['firstName'] . " " . $row['lastName'];
        $mobileNumber = $row['countryCode'] . " " . $row['mobileNumber'];
        echo '
        <label>Full Name:</label>
        <h3>'.$fullName.' </h3>

        <label>Sort Code:</label>
        <h3>'.$row['sortCode'].' </h3>

         <label>Account Number:</label>
        <h3>'.$row['accountNumber'].' </h3>

         <label>Email Address:</label>
        <h3>'.$row['email'].' </h3>

          <label>Mobile Number:</label>
        <h3>'.$mobileNumber.' </h3>

        
        ';
  
      }
    }
  }

  
    ?>
        <button onclick="hide()">Back</button>    

    </div>













  <div class="sendMoney">

  <form action="sendMoney.php" method= "post" >


    <h2>Recipient Details: </h2><br><br>

    <label for="recipient">Recipient Name:</label>
    <input type="text"  name="recipientFullName" required><br><br>

    <label for="accountNumber">Account Number:</label>
    <input type="text"  name="recipientAccountNumber" oninput="convertToInt()" class="changeToInt"  maxlength="8" required><br><br>

    <label for="sortCode">Sort Code:</label>
    <input type="text" name="recipientSortCode" oninput="convertToInt()" class="changeToInt"  maxlength="6" required><br><br>


    <label for="amount">Amount:</label>
    <input type="number" name="amount" required><br><br>


    <input type="submit" class="logInSignUp" name = "sendMoney" value="Send Money">
  </form>

  <button onclick="hide()">Back</button>    

    </div>





  


    <div class="exchangeMoney">
  <form action="exchangeMoney.php" method="post">
    <h2>Exchange Money: </h2><br><br>

    <label for="currency">Select Currency:</label>
    <select name="currency" required>
      <?php
      // Fetch all available currencies from the database
      $query = "SELECT currencyCode, currencyName FROM currencies";
      $result = $conn->query($query);

      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          echo '<option value="' . $row['currencyCode'] . '">' . $row['currencyName'] . ' (' . $row['currencyCode'] . ')</option>';
        }
      } else {
        echo '<option value="">No currencies available</option>';
      }
      ?>
    </select><br><br>

    <input type="submit" class="logInSignUp" name="exchangeMoney" value="Exchange Money">
  </form>

  <button onclick="hide()">Back</button>
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

















