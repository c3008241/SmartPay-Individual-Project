

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="styling/headerAndFooter.css">
  <link rel="stylesheet" href="styling/style.css">
  <link rel="stylesheet" href="styling/mobile.css">
  <link rel ="icon" href="images/smartPayLogo.png" >
  <title>Log In | SmartPay</title>
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
  
  
   
    </header>
    <nav class="navBar">
  <ul>
    <li><a href="index.php">HOME |</a></li>
    <li><a href="signUp.php">SIGN UP |</a></li>
    <li><a href="logIn.php">LOG IN |</a></li>
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
  
  <a href="forgotPassword.php" id="forgotPassword" >Forgot Password?</a>

  <input type="submit" class="logInSignUp" id="logIn" name="logIn" value="Log in">

</div>

    </form>


    </div>
    
    <div class="dontHaveAnAccount">
      <a>Don't have an account?</a>
      <a href="signUp.php" class="createAccountText"> Create an account</a>
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