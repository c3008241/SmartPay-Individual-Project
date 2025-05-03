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


$sql = "SELECT t.amount, t.transaction_date
        FROM transactions t
        INNER JOIN users u ON t.sender_id = u.user_ID
        WHERE t.sender_id = ?";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Prepare failed: " . $conn->error); // Helpful error output
}

$stmt->bind_param("i", $user_ID);
$stmt->execute();
$result = $stmt->get_result();

$dates = [];
$amounts = [];

while ($row = $result->fetch_assoc()) {
    $dates[] = $row['transaction_date'];
    $amounts[] = $row['amount'];
}





?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="styling/headerAndFooter.css">
  <link rel="stylesheet" href="styling/style.css">
  <link rel="stylesheet" href="styling/mobile.css">
  <script src = "scripting/app.js"></script>
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
      <h1>Invest</h1>
    </div>
    <div style="width: 80%; margin: auto; padding-top: 20px;">
    <canvas id="investmentChart"></canvas>
    </div>
  </main>


<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
  const labels = <?php echo json_encode($dates); ?>;
  const data = {
    labels: labels,
    datasets: [{
      label: 'Investments',
      data: <?php echo json_encode($amounts); ?>,
      backgroundColor: 'rgba(75, 192, 192, 0.5)',
      borderColor: 'rgba(75, 192, 192, 1)',
      borderWidth: 1
    }]
  };

  const config = {
    type: 'bar',
    data: data,
    options: {
      scales: {
        y: {
          beginAtZero: true,
          title: {
            display: true,
            text: 'Amount Invested ($)'
          }
        },
        x: {
          title: {
            display: true,
            text: 'Date'
          }
        }
      }
    }
  };

  document.addEventListener('DOMContentLoaded', () => {
    const ctx = document.getElementById('investmentChart').getContext('2d');
    new Chart(ctx, config);
  });
</script>






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