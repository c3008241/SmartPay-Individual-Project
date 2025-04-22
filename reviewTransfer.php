<?php 
include 'connect.php';
include 'session.php';
$conn = connectDB();
session_start();

// Define the formatCurrency function if not already included
function formatCurrency($amount, $currencyID, $conn) {
    $query = "SELECT symbol FROM currencies WHERE currency_ID = ?";
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        throw new Exception("Currency format prepare failed: " . $conn->error);
    }
    $stmt->bind_param("i", $currencyID);
    if (!$stmt->execute()) {
        throw new Exception("Currency format execute failed: " . $stmt->error);
    }
    $result = $stmt->get_result();
    $currency = $result->fetch_assoc();
    $stmt->close();
    return $currency['symbol'] . number_format($amount, 2);
}

$isLoggedIn = false;

if (isset($_SESSION['user_ID'])){
  $isLoggedIn = true;
}

// Check if receipt data exists
if (!isset($_SESSION['receipt_data'])) {
    header("Location: moneyBalance.php");
    exit();
}

// Get receipt data from session
$receiptData = $_SESSION['receipt_data'];
$formattedAmount = formatCurrency($receiptData['amount'], $receiptData['currency_id'], $conn);
$formattedBalance = formatCurrency($receiptData['new_balance'], $receiptData['currency_id'], $conn);

// Clear receipt data after displaying
unset($_SESSION['receipt_data']);








?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="styling/headerAndFooter.css">
  <link rel="stylesheet" href="styling/style.css">
  <link rel ="icon" href="images/smartPayLogo.png" >
  <title>Review Reciept | SmartPay</title>
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
    };
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
    <div id="title">
      <h1>Review Transfer</h1>
    </div>


    <div class="receipt-amount">
          <?php echo $formattedAmount; ?>
        </div>
        
        <div class="receipt-details">
          <div class="receipt-row">
            <span class="receipt-label">Recipient Name:</span>
            <span class="receipt-value"><?php echo htmlspecialchars($receiptData['recipient_name']); ?></span>
          </div>
          <div class="receipt-row">
            <span class="receipt-label">Account Number:</span>
            <span class="receipt-value"><?php echo htmlspecialchars($receiptData['recipient_account']); ?></span>
          </div>
          <div class="receipt-row">
            <span class="receipt-label">Sort Code:</span>
            <span class="receipt-value"><?php echo htmlspecialchars($receiptData['recipient_sortcode']); ?></span>
          </div>
          <div class="receipt-row">
            <span class="receipt-label">New Balance:</span>
            <span class="receipt-value"><?php echo $formattedBalance; ?></span>
          </div>
          <div class="receipt-row">
            <span class="receipt-label">Date:</span>
            <span class="receipt-value"><?php echo date('Y-m-d H:i:s'); ?></span>
          </div>
        </div>
        
        <div class="receipt-actions">
          <a href="moneyBalance.php" class="btn btn-primary">Make Another Transfer</a>
          <a href="transactionHistory.php" class="btn btn-secondary">View Transaction History</a>
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