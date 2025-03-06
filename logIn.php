

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="styling\headerAndFooter.css">
  <link rel="stylesheet" href="styling\style.css">
  <link rel ="icon" href="images/smartPayLogo.png" >
  <title>Log in | SmartPay</title>
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
        <li><a href="index.php">HOME |</a></li>
        <li><a href="invest.php">INVEST |</a></li>
        <li><a href="moneyBalance.php">PAYMENTS |</a></li>
        <li><a href="transactionHistory.php">TRANSACTION HISTORY |</a></li>
        <li><a href="contactUs.php">CONTACT US</a></li>
      </ul>
    </nav>




  <main>
    <div class="title">
      <h1>Log in</h1>
    </div>


    <div id="logIn">
    <form action="register.php" method="post">

      <div class="inputGroup">
        <i class="fas fa-envelope"></i>
      <label for="email">Email Address:</label>
      <input type="email" id="email" name="email" required placeholder="sarahwhitaker@gmail.com">
      </div>

      <div class="inputGroup">
        <i class="fas fa-lock"></i>
      <label for="password">Password:</label>
      <input type="password" id="password" name="password" maxlength="12" required placeholder="sarahwhit43">
      </div>

<div>
  <input type="submit" class="logInSignUp" id="logIn" name="logIn" value="Log in">

</div>

    </form>
    </div>
    
    <div class="dontHaveAnAccount">
      <a>Don't have an account?</a>
      <a href="signUp.html" class="createAccountText"> Create an account</a>
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