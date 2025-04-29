<?php
include 'connect.php';
$conn = connectDB();
session_start();

$user_ID = $_SESSION['user_ID'];
if (!isset($user_ID)) {
    session_unset();
    session_destroy();
    header("Location: logIn.php");
    exit();
}

$query = "SELECT 
    a.*, 
    u.*, 
    t.*, 
    ca.*, 
    cu.*,
    ru.firstName AS recipientFirstName,
    ru.lastName AS recipientLastName,
    ru.email AS recipientEmail
FROM accounts AS a
INNER JOIN users AS u ON u.user_ID = a.user_ID
INNER JOIN transactions AS t ON t.sender_id = u.user_ID
INNER JOIN cards AS ca ON ca.card_ID = a.card_ID
INNER JOIN currencies AS cu ON cu.currency_ID = ca.currency_ID
INNER JOIN users AS ru ON ru.user_ID = t.recipient_id
WHERE u.user_ID = $user_ID";

$result = $conn->query($query);

$transactions = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $transaction = [
            'firstName' => $row['firstName'],
            'lastName' => $row['lastName'],
            'fullName' => $row['firstName'] . ' ' . $row['lastName'],
            'recipientFullName' => $row['recipientFirstName'] . ' ' . $row['recipientLastName'],
            'recipientEmail' => $row['recipientEmail'],
            'amount' => $row['amount'],
            'status' => $row['status'],
            'transaction_date' => $row['transaction_date']
            
        ];
        $transactions[] = $transaction;
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
  <link rel="icon" href="images/smartPayLogo.png">
  <title>Transaction History | SmartPay</title>
  <style>
    /* You can move this to style.css later */
    table.transactionTable {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }
    table.transactionTable th, table.transactionTable td {
      border: 1px solid #ddd;
      padding: 8px;
      text-align: left;
    }
    table.transactionTable th {
      background-color: #f2f2f2;
      font-weight: bold;
    }
    .transactionGroup {
      overflow-x: auto; /* To make table scroll on mobile */
    }
  </style>
</head>
<body>
  <div class="container">
    <header>
      <div class="logoWrapper">
        <a href="homePage.html">
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
        <li><a href="invest.php">INVEST |</a></li>
        <li><a href="moneyBalance.php">PAYMENTS |</a></li>
        <li><a href="transactionHistory.php">TRANSACTION HISTORY |</a></li>
        <li><a href="contactUs.php">CONTACT US</a></li>
      </ul>
    </nav>

    <main>
      <div class="title">
        <h1>Transaction History</h1>
      </div>

      <div class="transactionGroup">
        <?php 
        if (!empty($transactions)) {
          echo "<table class='transactionTable'>";
          echo "<thead>";
          echo "<tr>";
         
          echo "<th>Recipient Name</th>";
          echo "<th>Recipient Email</th>";
          echo "<th>Amount</th>";
          echo "<th>Status</th>";
          echo "<th>Transaction Date</th>";
          echo "</tr>";
          echo "</thead>";
          echo "<tbody>";
          foreach ($transactions as $transaction) {
            echo "<tr>";
           
            echo "<td>" . htmlspecialchars($transaction['recipientFullName']) . "</td>";
            echo "<td>" . htmlspecialchars($transaction['recipientEmail']) . "</td>";
            echo "<td>$" . htmlspecialchars($transaction['amount']) . "</td>";
            echo "<td>$" . htmlspecialchars($transaction['status']) . "</td>";
            echo "<td>" . htmlspecialchars($transaction['transaction_date']) . "</td>";
            echo "</tr>";
          }
          echo "</tbody>";
          echo "</table>";
        } else {
          echo "<p>No transactions found.</p>";
        }
        ?>
      </div>
    </main>

    <footer>
      <div class="footerItems">
        <div id="copyRight">
          Copyright &#169;
        </div>
        <div class="smartPayEmails">
          <a href="#">info@smartpay.com</a>
          <a href="#">contact@smartpay.com</a>
        </div>
      </div>
    </footer>
  </div>
</body>
</html>
