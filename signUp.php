<?php 
include 'connect.php';
session_start();
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
  <link rel ="icon" href="images/smartPayLogo.png" >
  <title>Sign Up | SmartPay</title>
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
    <div class="signUpItems">

      <div class="title">
          <h1>Register</h1>
        </div>


        <form  method="post" action="register.php">


          <div class="inputGroup">
            <i class="fas fa-user"></i>

            <label for="prefix">Prefix:</label>

            <select name="prefix" id="prefixSelect">

              <option value="Mrs">Mrs</option>

              <option value="Miss">Miss</option>

              <option value="Mr">Mr</option>

              <option value="Dr">Dr</option>

            </select>
          </div>


          <div class="inputGroup">
            <i class="fas fa-user"></i>
            <label for="firstName">First Name:</label>
            <input type="text" id="firstName" name="firstName" required placeholder="Sarah">
          </div>

          <div class="inputGroup">
            <i class="fas fa-user"></i>
            <label for="lastName">Last Name:</label>
            <input type="text" id="lastName" name="lastName" required placeholder="Whitaker">
          </div>

          
          <div class="inputGroup">
            <i class="fas fa-suitcase"></i>

            <label for="userType">Account Type:</label>

            <select name="userType" id="userType">

              <option value="Personal">Personal</option>

              <option value="Tourist">Tourist</option>

              <option value="Business Owner">Business Owner</option>

            </select>
          </div>

          <div class="inputGroup">
            <i class="fas fa-envelope"></i>
            <label for="email">Email Address:</label>
            <input type="email" id="email" name="email" required placeholder="sarahwhitaker@gmail.com">
          </div>


          <div class="inputGroup">
            <i class="fas fa-user"></i>
            <label for="numberSelect">Mobile Number:</label>

          <div id="inputMobileNumber">

          <div class="countryCode">
            <select name="countryCode" id="countryCode">
              <option value="+44">UK +44</option>

              <option value="+34">SPAIN +34</option>

              <option value="+1">USA +1</option>

              <option value="+39">ITALY +39</option>

              <option value="+967">YEMEN +967</option>
            </select>
          </div>

            <input type="mobileNumber" id="mobileNumber" name="mobileNumber" required placeholder="[GB] +44 7325922756">
          </div>
          </div>


          <div class="inputGroup">
            <i class="fas fa-lock"></i>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" maxlength="12" required placeholder="sarahwhit43">
          </div>

          <div class="inputGroup">
            <i class="fas fa-lock"></i>
            <label for="confirmPassword">Confirm Password:</label>
            <input type="password" id="confirmPassword" name="confirmPassword" maxlength="12" required
              placeholder="sarahwhit43">
          </div>
            <div>


          <input type="submit" class="logInSignUp" id="next" name="next" value="Next">


              
            
            </form>

      <div class="alreadyHaveAnAccount">
        <a>Already have an account? <span> <a href="logIn.php" class="createAccountText"> Log in</a></span> </a>
       
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