
<?php
//extra stuff to fix but delete after if it doesn't work
include 'encryption.php';
include 'connect.php';
$conn = connectDB();
session_start();


//checking if it is connected to the database for debugging purposes
// $result = $conn->query("SELECT DATABASE() as db");
// if ($result && $row = $result->fetch_assoc()) {
//     echo "Connected to DB: " . $row['db'] . "<br>";
// }



if (isset($_POST["next"])){
 $prefix = $_POST['prefix'];
 $firstName = $_POST['firstName'];
 $lastName = $_POST['lastName'];
 $userType = $_POST['userType'];
 $email = $_POST['email'];
 $countryCode= $_POST['countryCode'];
 $mobileNumber = $_POST['mobileNumber'];
if($_POST['password'] == $_POST['confirmPassword']) {
    $password = encrypt($_POST['password'], "cat");
} else {
    echo "<script>
    alert('Passwords do not match.');
    window.location.href = 'signUp.php';
    </script>";
    exit();
}


///I realised that the alert was not working because I was using ' in "don't" which ended the alert early and gained no response from the page since it was ignored by the system.
// if ($_POST['password'] == $_POST['confirmPassword']) {
//      $password = encrypt($_POST['password'], "cat");
//  } else {
//     echo "<script>
//     alert('Passwords don't match.');
//     window.location.href = 'signUp.php';
//     </script>";
//      exit();
//  }

 $checkEmail = "SELECT * FROM users WHERE email='$email'";
 $result = $conn->query($checkEmail);

 
 if($result->num_rows > 0){
    echo "<script>
    alert('That email already exists!');
    window.location.href = 'signUp.php';
    </script>";
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




//-----------the OG one------------------------//
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

            $cardNumber = encrypt($_POST['cardNumber'], "cat");
            $accountNumber = encrypt($_POST['accountNumber'], "cat");
            
            $cardNumber = $_POST['cardNumber'];
            $accountNumber = $_POST['accountNumber'];
            $sortCode = $_POST['sortCode'];
            $expiraryDate = $_POST['expiraryDate'];
            $cvv = $_POST['cvv'];
            $currency_ID = 1;

            // $checkCardUnique = "SELECT * FROM cards WHERE cardNumber='$cardNumber' OR accountNumber='$accountNumber'";
            // $cardResult = $conn->query($checkCardUnique);
            // if ($cardResult->num_rows > 0) {  
            //     echo "<script>
            //     alert('That card already exists!');
            //     window.location.href = 'cardDetails.php';
            //     </script>";
            // } else {
            $checkCardUnique = "SELECT * FROM cards WHERE cardNumber = ? OR accountNumber = ?";
            $stmt = $conn->prepare($checkCardUnique);
            $stmt->bind_param("ss", $cardNumber, $accountNumber);
            $stmt->execute();
            $cardResult = $stmt->get_result();

            if ($cardResult->num_rows > 0) {
                echo "<script>
                alert('That card already exists!');
                window.location.href = 'cardDetails.php';
                </script>";
            } else {
   
                $cardQuery = "INSERT INTO cards (cardNumber, accountNumber, sortCode, expiraryDate, cvv, currency_ID)
                              VALUES('$cardNumber', '$accountNumber', '$sortCode', '$expiraryDate', '$cvv' , '$currency_ID')";
                if ($conn->query($cardQuery) === TRUE) {
                    $card_id = $conn->insert_id;
                    $initialBalance = 1000; // Store a default sample balance of 1000 in the account, normally banking websites like these wouldn't do this.
    
                    $accountQuery = "INSERT INTO accounts (user_ID, card_ID, balance) VALUES('$user_id', '$card_id' , '$initialBalance')";
                    if ($conn->query($accountQuery) === TRUE) {
                        echo "<script type='text/javascript'>
                    window.location.href = 'logIn.php';
                    alert('Account was succesffuly made!');
                    </script>";
                    
                    
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



//-----------updated one-------------------//
// if (isset($_POST["register"])) {

//     $user_ID = $_SESSION['user_ID'];

//     if(!isset($user_ID)){
//     $prefix = $_SESSION['prefix'];
//     $firstName = $_SESSION['firstName'];
//     $lastName = $_SESSION['lastName'];
//     $userType = $_SESSION['userType'];
//     $email = $_SESSION['email'];
//     $countryCode= $_SESSION['countryCode'];
//     $mobileNumber = $_SESSION['mobileNumber'];
//     $password = $_SESSION['password'];

//     $insertQuery = "INSERT INTO users (prefix, firstName, lastName, userType, email, countryCode, mobileNumber, password)
//     VALUES('$prefix', '$firstName', '$lastName', '$userType', '$email', '$countryCode', '$mobileNumber', '$password')";

//     }
    
// $insertQuery=0;
       
//         if ($conn->query($insertQuery) === TRUE || isset($user_ID)){
            
//             $user_id = $conn-> insert_id;
//             if(isset($user_ID)){
//                 $_SESSION['user_ID'] = $user_id;
//             } 

//             // $cardNumber = encrypt($_POST['cardNumber'], "cat");
//             // $accountNumber = encrypt($_POST['accountNumber'], "cat");
            
//             $cardNumber = $_POST['cardNumber'];
//             $accountNumber = $_POST['accountNumber'];
//             $sortCode = $_POST['sortCode'];
//             $expiraryDate = $_POST['expiraryDate'];
//             $cvv = $_POST['cvv'];
//             $currency_ID = 1;

//             $checkCardUnique = "SELECT * FROM cards WHERE cardNumber='$cardNumber' AND accountNumber='$accountNumber'";
//             $cardResult = $conn->query($checkCardUnique);
//             if ($cardResult->num_rows > 0) {  
//                 echo "<script>
//                 alert('That card already exists!');
//                 window.location.href = 'cardDetails.php';
//                 </script>";
//             } else {
//                 $cardQuery = "INSERT INTO cards (cardNumber, accountNumber, sortCode, expiraryDate, cvv, currency_ID)
//                               VALUES('$cardNumber', '$accountNumber', '$sortCode', '$expiraryDate', '$cvv' , '$currency_ID')";
//                 if ($conn->query($cardQuery) === TRUE) {
//                     $card_id = $conn->insert_id;
//                     $initialBalance = 1000; // Store a default sample balance of 1000 in the account, normally banking websites like these wouldn't do this.
    
//                     $accountQuery = "INSERT INTO accounts (user_ID, card_ID, balance) VALUES('$user_id', '$card_id' , '$initialBalance')";
//                     if ($conn->query($accountQuery) === TRUE) {
//                         echo "<script type='text/javascript'>
//                     window.location.href = 'logIn.php';
//                     alert('Account was succesffuly made!');
//                     </script>";
//                         session_unset();
//                         session_destroy();
//                         exit();
//                     } else {
//                         echo "Error: " . $conn->error;
//                     }
//                 } else {
//                     echo "Error: " . $conn->error;
//                 }
//             }
//         } else {
//             echo "Error: " . $conn->error;
//         }
//     }









//testing on this one 

// if (isset($_POST["register"])) {

//     if (!isset($_SESSION['user_ID'])) {
//         // New user registration
//         $prefix = $_SESSION['prefix'];
//         $firstName = $_SESSION['firstName'];
//         $lastName = $_SESSION['lastName'];
//         $userType = $_SESSION['userType'];
//         $email = $_SESSION['email'];
//         $countryCode= $_SESSION['countryCode'];
//         $mobileNumber = $_SESSION['mobileNumber'];
//         $password = $_SESSION['password'];

//         $insertQuery = "INSERT INTO users (prefix, firstName, lastName, userType, email, countryCode, mobileNumber, password)
//                         VALUES('$prefix', '$firstName', '$lastName', '$userType', '$email', '$countryCode', '$mobileNumber', '$password')";

//         if ($conn->query($insertQuery) === TRUE) {
//             $user_ID = $conn->insert_id;
//             $_SESSION['user_ID'] = $user_ID;
//         } else {
//             echo "Error inserting user: " . $conn->error;
//             exit();
//         }
//     } else {
//         // User already logged in
//         $user_ID = $_SESSION['user_ID'];
//     }

//     // Proceed to register card/account for this user
//     $cardNumber = $_POST['cardNumber'];
//     $accountNumber = $_POST['accountNumber'];
//     $sortCode = $_POST['sortCode'];
//     $expiraryDate = $_POST['expiraryDate'];
//     $cvv = $_POST['cvv'];
//     $currency_ID = 1;

//     $checkCardUnique = "SELECT * FROM cards WHERE cardNumber='$cardNumber' AND accountNumber='$accountNumber'";
//     $cardResult = $conn->query($checkCardUnique);
//     if ($cardResult->num_rows > 0) {  
//         echo "<script>
//         alert('That card already exists!');
//         window.location.href = 'cardDetails.php';
//         </script>";
//     } else {
//         $cardQuery = "INSERT INTO cards (cardNumber, accountNumber, sortCode, expiraryDate, cvv, currency_ID)
//                       VALUES('$cardNumber', '$accountNumber', '$sortCode', '$expiraryDate', '$cvv' , '$currency_ID')";
//         if ($conn->query($cardQuery) === TRUE) {
//             $card_id = $conn->insert_id;
//             $initialBalance = 1000;

//             $accountQuery = "INSERT INTO accounts (user_ID, card_ID, balance) VALUES('$user_ID', '$card_id' , '$initialBalance')";
//             if ($conn->query($accountQuery) === TRUE) {
//                 echo "<script type='text/javascript'>
//                 alert('Account was successfully made!');
//                 window.location.href = 'logIn.php';
//                 </script>";
//                 session_unset();
//                 session_destroy();
//                 exit();
//             } 
//             else if ($conn->query($accountQuery) === TRUE && isset($user_ID)) {
//                 echo "<script type='text/javascript'>
//                 alert(' New Account was successfully made!');
//                 window.location.href = 'moneyBalance.php';
//                 </script>";
//                 // session_unset();
//                 // session_destroy();
//                 exit();
//             } else {
//                 echo "Error: " . $conn->error;
//             }
//         } else {
//             echo "Error: " . $conn->error;
//         }
//     }
// }





// ///----ATTEMT AT MAKING A NEW ACCOUNT (AND CARD) INCLUDING WITH LOGGED IN USERS ID---/////////// 


// if (isset($_POST["register"])) {

//     $user_ID = $_SESSION['user_ID'];

//     if(!isset($user_ID)){
//     $prefix = $_SESSION['prefix'];
//     $firstName = $_SESSION['firstName'];
//     $lastName = $_SESSION['lastName'];
//     $userType = $_SESSION['userType'];
//     $email = $_SESSION['email'];
//     $countryCode= $_SESSION['countryCode'];
//     $mobileNumber = $_SESSION['mobileNumber'];
//     $password = $_SESSION['password'];

//     $insertQuery = "INSERT INTO users (prefix, firstName, lastName, userType, email, countryCode, mobileNumber, password)
//     VALUES('$prefix', '$firstName', '$lastName', '$userType', '$email', '$countryCode', '$mobileNumber', '$password')";

//     }
    
//     $insertQuery=TRUE;
       
//         if ($conn->query($insertQuery) === TRUE || isset($user_ID)){
            
//             $user_id = $conn-> insert_id;
//             if(isset($user_ID)){
//                 $_SESSION['user_ID'] = $user_id;
//             } 

//             // $cardNumber = encrypt($_POST['cardNumber'], "cat");
//             // $accountNumber = encrypt($_POST['accountNumber'], "cat");
            
//             $cardNumber = $_POST['cardNumber'];
//             $accountNumber = $_POST['accountNumber'];
//             $sortCode = $_POST['sortCode'];
//             $expiraryDate = $_POST['expiraryDate'];
//             $cvv = $_POST['cvv'];
//             $currency_ID = 1;

//             $checkCardUnique = "SELECT * FROM cards WHERE cardNumber='$cardNumber' AND accountNumber='$accountNumber'";
//             $cardResult = $conn->query($checkCardUnique);
//             if ($cardResult->num_rows > 0) {  
//                 echo "<script>
//                 alert('That card already exists!');
//                 window.location.href = 'cardDetails.php';
//                 </script>";
//             } else {
//                 $cardQuery = "INSERT INTO cards (cardNumber, accountNumber, sortCode, expiraryDate, cvv, currency_ID)
//                               VALUES('$cardNumber', '$accountNumber', '$sortCode', '$expiraryDate', '$cvv' , '$currency_ID')";
//                 if ($conn->query($cardQuery) === TRUE) {
//                     $card_id = $conn->insert_id;
//                     $initialBalance = 1000; // Store a default sample balance of 1000 in the account, normally banking websites like these wouldn't do this.
    
//                     $accountQuery = "INSERT INTO accounts (user_ID, card_ID, balance) VALUES('$user_id', '$card_id' , '$initialBalance')";
//                     if ($conn->query($accountQuery) === TRUE) {
//                         echo "<script type='text/javascript'>
//                     window.location.href = 'logIn.php';
//                     alert('Account was succesffuly made!');
//                     </script>";
//                         session_unset();
//                         session_destroy();
//                         exit();
//                     } else {
//                         echo "Error: " . $conn->error;
//                     }
//                 } else {
//                     echo "Error: " . $conn->error;
//                 }
//             }
//         } else {
//             echo "Error: " . $conn->error;
//         }
//     }









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
    echo "<script>
    alert('Invalid email or password.');
    window.location.href = 'logIn.php';
    </script>";
}

}
?>

