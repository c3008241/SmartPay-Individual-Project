<?php

include 'connect.php';
include 'encryption.php';
include 'session.php';
include 'keepAlive.php';
$conn = connectDB();


 
$path = "logIn.php"; //this path is to pass to checkSession function from session.php 
    
session_start(); //must start a session in order to use session in this page.
if (!isset($_SESSION['user_ID'])){
  session_unset();
  session_destroy();
  header("Location:".$path);//return to the login page
}

$user_ID = $_SESSION['user_ID'];

$query = mysqli_query($conn, "SELECT *
                    FROM users AS u
                    INNER JOIN accounts AS a ON u.user_ID = a.user_id 
                    INNER JOIN cards AS ca ON a.card_ID = ca.card_ID
                    INNER JOIN currencies AS cu ON ca.currency_ID = cu.currency_ID 
                    WHERE u.user_ID = $user_ID" );




$result = mysqli_fetch_assoc($query);


$userType = $result['userType'];
$firstName = $result['firstName'];
$lastName = $result['lastName'];
$email = $result['email']; 
$userType = $result['userType']; 
 

checkSession ($path); 



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
        if($userType == "Business Owner"){
          echo '        <li><a href="invest.php">INVEST |</a></li>';
        } 
        ?>
        <li><a href="moneyBalance.php">PAYMENTS |</a></li>
        <li><a href="transactionHistory.php">TRANSACTION HISTORY |</a></li>
        <li><a href="contactUs.php">CONTACT US</a></li>
      </ul>
    </nav>



<main>


    

<div class="userBalance">


<?php 

// if(isset($_SESSION['email'])){
// $email = $_SESSION['email'];
// $query = "SELECT u.userType, cu.currencyCode, cu.symbol , a.balance
//                   FROM users AS u
//                   INNER JOIN accounts AS a ON u.user_ID = a.user_id 
//                   INNER JOIN cards AS ca ON a.card_ID = ca.card_ID
//                   INNER JOIN currencies AS cu ON ca.currency_ID = cu.currency_ID 
//                   WHERE u.user_ID = $user_ID";
//   $result = $conn->query($query);
//   if ($result->num_rows > 0){
//     while($row = $result->fetch_assoc()){
//       echo "<h3>".$row['userType']." &#126; ".$row['currencyCode']." </h3>";
//       echo "<h1>".$row['symbol'].$row['balance']."</h1>";

//     }
//   }
//   else{
//     echo "You are Broke";
//   }
// }


if($email){
  $email = $_SESSION['email'];

  
  $fullName = $result['firstName'] . " " . $result['lastName'];

        echo $fullName;
    
        echo "<h3>".$result['userType']." &#126; ".$result['currencyCode']." </h3>";
        echo "<h1>".$result['symbol'].$result['balance']."</h1>";
  
    
  }
  



  // if($userType == "Business Owner"){
  //   echo "you are a business owner";
  //   echo $firstName;
  //   echo $lastName;
  //   echo $email;
  // } else {
  //   echo "You are not a business owner";
  // }
?>



<div class= "balanceButtons">
<button id= "accountButton">Accounts</button>
<div class="moneyBalanceButtons">
  <a href="cardDetails.php">
<p >Add</p>
</a>
<p onclick= "showExchangeMoney()">Exchange</p>
<p onclick="showAccountDetails()">Details</p>
<p onclick="showSendMoney()" >Send</p>
</div>

</div>

    </div>

    <div class="accountDetails">

    <h1>Account Details</h1>

   <?php 

if($email){
  
        $fullName = $result['firstName'] . " " . $result['lastName'];
        $mobileNumber = $result['countryCode'] . " " . $result['mobileNumber'];
        echo '
<div class = "accountDetailsContainer">
        <label>Full Name:</label>
        <h3>'.$fullName.' </h3>

        <label>Sort Code:</label>
        <h3>'.$result['sortCode'].' </h3>


         <label>Account Number:</label>
        <h3>'.$result['accountNumber'].' </h3>

         <label>Email Address:</label>
        <h3>'.$result['email'].' </h3>

          <label>Mobile Number:</label>
        <h3>'.$mobileNumber.' </h3>

          <label>Account Type:</label>
        <h3>'.$result['userType'].' </h3>
</div>

        
        ';
  
    
  }

  
    ?>
        <button onclick="hide()" class="back">Back</button>    

    </div>









 <div class="sendMoney">
  <form action="sendMoney.php" method="POST">
    <h2>Recipient Details:</h2><br><br>

    <label for="recipient">Recipient Name:</label>
    <input type="text" name="recipientName" ><br><br>

    <label for="accountNumber">Account Number:</label>
    <input type="text" name="recipientAccountNumber" oninput="convertToInt()" class="changeToInt" maxlength="8" required><br><br>

    <label for="sortCode">Sort Code:</label>
    <input type="text" name="recipientSortCode" oninput="convertToInt()" class="changeToInt" maxlength="6" required><br><br>

    <label for="amount">Amount:</label>
    <input type="number" name="amount" min="0.01" step="0.01" required><br><br>

    <input type="submit" class="logInSignUp" name="sendMoney" value="Send Money">
  </form>
  <button onclick="hide()" class="back">Back</button>
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

  <button onclick="hide()" class="back">Back</button>    

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


<div id="sessionWarning" style="display: none; position: fixed; top: 0; left: 0; 
    width: 100%; height: 100%; background: rgba(0,0,0,0.5); 
    justify-content: center; align-items: center; z-index: 9999;">
  <div style="background: white; padding: 20px; border-radius: 10px; text-align: center;">
    <p>Your session is about to expire. Do you want to stay logged in?</p>
    <button onclick="keepSessionAlive()">Yes, keep me logged in</button>
  </div>
</div>

<script>
    const warningTime = 60 * 29; // show warning at 29 minutes
    const logoutTime = 60 * 30; // logout at 30 minutes

    let warningTimer = setTimeout(showWarningModal, warningTime * 1000);
    let logoutTimer = setTimeout(autoLogout, logoutTime * 1000);

    function showWarningModal() {
        document.getElementById('sessionWarning').style.display = 'flex';
    }

    function keepSessionAlive() {
        fetch('keepAlive.php') // this resets the session server-side
            .then(response => {
                if (response.ok) {
                    resetSessionTimers();
                    document.getElementById('sessionWarning').style.display = 'none';
                }
            });
    }

    function autoLogout() {
        window.location.href = 'logOut.php';
    }

    function resetSessionTimers() {
        clearTimeout(warningTimer);
        clearTimeout(logoutTimer);
        warningTimer = setTimeout(showWarningModal, warningTime * 1000);
        logoutTimer = setTimeout(autoLogout, logoutTime * 1000);
    }
</script>



</html>

















