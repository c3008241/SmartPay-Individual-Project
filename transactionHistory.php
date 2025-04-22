<?php
include 'connect.php';
$conn = connectDB();

session_start();
if (!isset($_SESSION["user_ID"])) {
    header("Location: logIn.php");
    exit();
}





// $sender_ID = $_SESSION['user_ID'];

// // $query = mysqli_query($conn, "SELECT * FROM users WHERE user_ID = $user_ID" );

// $query = mysqli_query($conn, "SELECT *
// FROM users AS u
// INNER JOIN transactions AS t ON t.sender_id = u.user_ID
// INNER JOIN accounts AS a ON a.user_ID = u.user_ID
// INNER JOIN cards AS ca ON ca.card_ID = a.card_ID
// INNER JOIN currencies AS cu ON t.currencyID = cu.currency_ID
// WHERE t.sender_id = $sender_ID " );

// $result = mysqli_fetch_assoc($query);



// $recipientUserId = $result['recipient_id'];
// $firstName = $result['firstName'];




// Query to get transactions between these users AND recipient details
$query = "
    SELECT 
        t.*,
        sender.firstName as sender_firstName,
        sender.lastName as sender_lastName,
        recipient.firstName as recipient_firstName,
        recipient.lastName as recipient_lastName,
        cu.symbol
    FROM 
        transactions t
    JOIN 
        users sender ON t.sender_id = sender.user_ID
    JOIN 
        users recipient ON t.recipient_id = recipient.user_ID
    JOIN 
        currencies cu ON t.currencyID = cu.currency_ID
    WHERE 
        t.sender_id = ? AND t.recipient_id = ?
    ORDER BY 
        t.transaction_date DESC
";

// Prepare statement for security
$stmt = mysqli_prepare($conn, $query);
if (!$stmt) {
    die("Query preparation failed: " . mysqli_error($conn));
}

// Bind parameters
mysqli_stmt_bind_param($stmt, "ii", $sender_ID, $recipient_ID);

// Execute
if (!mysqli_stmt_execute($stmt)) {
    die("Query execution failed: " . mysqli_stmt_error($stmt));
}

$result = mysqli_stmt_get_result($stmt);

// Now you can access recipient details
if ($row = mysqli_fetch_assoc($result)) {
    $recipient_firstName = $row['recipient_firstName'];
    $recipient_lastName = $row['recipient_lastName'];
    $amount = $row['amount'];
    $currency_symbol = $row['symbol'];
    
    echo "Transaction with: $recipient_firstName $recipient_lastName";
    echo "Amount: $currency_symbol" . number_format($amount, 2);
} else {
    echo "No transactions found between these users";
}

// Close statement
mysqli_stmt_close($stmt);





?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="styling/headerAndFooter.css">
  <link rel="stylesheet" href="styling/style.css">
  <link rel ="icon" href="images/smartPayLogo.png" >
  <title>Transaction History | SmartPay</title>
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

    </header>

    <nav class="navBar">
      <ul>
        <!-- <li><a href="homePage.html">HOME |</a></li> -->
        <li><a href="invest.php">INVEST |</a></li>
        <li><a href="moneyBalance.php">PAYMENTS |</a></li>
        <li><a href="transactionHistory.php">TRANSACTION HISTORY |</a></li>
        <li><a href="contactUs.php">CONTACT US</a></li>
      </ul>
    </nav>




  <main>
    <div class="title">
      <h1>Transaction Reciept</h1>
    </div>


    <div class="transactionGroup">
      <?php 
    echo $firstName;
    echo $recipientUserId;
      ?>
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