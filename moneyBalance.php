<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="styling\headerAndFooter.css">
  <link rel="stylesheet" href="styling\style.css">
  <script src = "scripting/app.js"></script>
  <link rel ="icon" href="images/smartPayLogo.png" >
  <title> Balance | SmartPay</title>
</head>
<body>
  <div class="container">
    <header>
    <div class="logoWrapper">

      <a href="index.html" id="smartPayLogo">
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
        <li><a href="homePage.php">HOME |</a></li>
        <li><a href="invest.php">INVEST |</a></li>
        <li><a href="moneyBalance.php">PAYMENTS |</a></li>
        <li><a href="transactionHistory.php">TRANSACTION HISTORY |</a></li>
        <li><a href="contactUs.php">CONTACT US</a></li>
      </ul>
    </nav>




  <main>
    <div class="title">
      <h1>Your Balance</h1>
    </div>

    <div class="balancePageContent">

      <div>
        <div class="inline">
          £
        <h2 class="balanceBefore">20</h2>
      </div>

      <div class="inline">
        £
        <div class="balanceAfter">20</div> 
      </div>

      <input type="number" class="inputAmount"> 

      <button onclick="calculateTotal()">Calculate</button> 
    

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