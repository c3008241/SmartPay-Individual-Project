
<?php
//extra stuff to fix but delete after if it doesn't work
session_start();


include 'connect.php';
$conn = connectDB();
include 'encryption.php';


if (isset($_POST["next"])){
 $prefix = $_POST['prefix'];
 $firstName = $_POST['firstName'];
 $lastName = $_POST['lastName'];
 $userType = $_POST['userType'];
 $email = $_POST['email'];
 $countryCode= $_POST['countryCode'];
 $mobileNumber = $_POST['mobileNumber'];
if ($_POST['password'] == $_POST['confirmPassword']) {
     $password = encrypt($_POST['password'], "cat");
 } else {
     echo "Passwords do not match!";
     exit();
 }

 $checkEmail = "SELECT * FROM users WHERE email='$email'";
 $result = $conn->query($checkEmail);

 if($result->num_rows > 0){
     echo "That Email Already Exists!";
 } else{

    $_SESSION['prefix'] = $prefix;
    $_SESSION['firstName'] = $firstName;
    $_SESSION['lastName'] = $lastName;
    $_SESSION['userType'] = $userType;
    $_SESSION['email'] = $email;
    $_SESSION['countryCode'] = $countryCode;
    $_SESSION['mobileNumber'] = $mobileNumber;
    $_SESSION['password'] = $password;

    header("Location: cardDetails.php");
    exit();
    }
    
}





if (isset($_POST["register"])) {

    $prefix = $_SESSION['prefix'];
    $firstName = $_SESSION['firstName'];
    $lastName = $_SESSION['lastName'];
    $userType = $_SESSION['userType'];
    $email = $_SESSION['email'];
    $countryCode= $_SESSION['countryCode'];
    $mobileNumber = $_SESSION['mobileNumber'];
    $password = $_SESSION['password'];
    

        $insertQuery = "INSERT INTO users (prefix, firstName, lastName, userType, email, countryCode, mobileNumber, password)
                        VALUES('$prefix', '$firstName', '$lastName', '$userType', '$email', '$countryCode', '$mobileNumber', '$password')";
        if ($conn->query($insertQuery) === TRUE) {
            
            $user_id = $conn-> insert_id;

            // $cardNumber = encrypt($_POST['cardNumber'], "cat");
            // $accountNumber = encrypt($_POST['accountNumber'], "cat");
            
            $cardNumber = $_POST['cardNumber'];
            $accountNumber = $_POST['accountNumber'];
            $sortCode = $_POST['sortCode'];
            $expiraryDate = $_POST['expiraryDate'];
            $cvv = $_POST['cvv'];
            $currency_ID = 1;

            $checkCardUnique = "SELECT * FROM cards WHERE cardNumber='$cardNumber' AND accountNumber='$accountNumber'";
            $cardResult = $conn->query($checkCardUnique);
            if ($cardResult->num_rows > 0) {  
                echo "That Card Already Exists!";
            } else {
                $cardQuery = "INSERT INTO cards (cardNumber, accountNumber, sortCode, expiraryDate, cvv, currency_ID)
                              VALUES('$cardNumber', '$accountNumber', '$sortCode', '$expiraryDate', '$cvv' , '$currency_ID')";
                if ($conn->query($cardQuery) === TRUE) {
                    $card_id = $conn->insert_id;
                    $initialBalance = 1000; // Store a default sample balance of 1000 in the account, normally banking websites like these wouldn't do this.
    
                    $accountQuery = "INSERT INTO accounts (user_ID, card_ID, balance) VALUES('$user_id', '$card_id' , '$initialBalance')";
                    if ($conn->query($accountQuery) === TRUE) {
                        echo "Account created successfully!";
                        session_unset();
                        session_destroy();
                        exit();
                    } else {
                        echo "Error: " . $conn->error;
                    }
                } else {
                    echo "Error: " . $conn->error;
                }
            }
        } else {
            echo "Error: " . $conn->error;
        }
    }

 if(isset($_POST['logIn'])) {
    
    $email = $_POST['email'];
    // $password = $_POST['password'];


// Encrypt the entered password using the same key as used during registration
$password = encrypt($_POST['password'], "cat");

// Validate user credentials using the encrypted password
$query = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email' AND password = '$password'");

if (mysqli_num_rows($query) == 1) {
    
    $row = mysqli_fetch_assoc($query);
    session_start();
    $_SESSION['user_ID'] = $row['user_ID'];
    $_SESSION['email'] = $row['email'];

    // Redirect to the home page or dashboard
    header("Location: moneyBalance.php");
    exit();
} else {
    echo "Invalid email or password.";
}

}
?>

