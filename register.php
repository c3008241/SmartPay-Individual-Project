
<?php
include 'connect.php';

if (isset($_POST["register"])) {
    // Grab form values
    $prefix = $_POST['prefix'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $userType = $_POST['userType'];
    $email = $_POST['email'];
    $countryCode= $_POST['countryCode'];
    $mobileNumber = $_POST['mobileNumber'];
    if($_POST['password'] == $_POST['confirmPassword']){
        $password = md5($_POST['password']);
    } 
    else 
    { 
        echo "Passwords do not match!";
        exit();
    }

    $checkEmail = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($checkEmail);
    if($result->num_rows > 0){
        echo "That Email Already Exists!";
    }
    else {
        $insertQuery = "INSERT INTO users (prefix, firstName, lastName, userType, email, countryCode, mobileNumber, password)
                        VALUES('$prefix', '$firstName', '$lastName', '$userType', '$email', '$countryCode', '$mobileNumber', '$password')";
        if ($conn->query($insertQuery) === TRUE) {
            header("Location: add_card.php?user_id=" . $user_id);
        }
        else {
            echo "Error: " . $conn->error;
        }
    }
}

if(isset($_POST['logIn'])){
    $email = $_POST['email'];
    $password = md5($_POST['password']);

    $sql = "SELECT * FROM users WHERE email = '$email' and password = '$password'";
    $result = $conn->query($sql);

    if($result->num_rows > 0){
        session_start();
        $row = $result->fetch_assoc();
        $_SESSION['email'] = $row['email'];
        header("location: homePage.php");
        exit();
    }
    else {
        echo "Not Found, Incorrect Email or Password.";
    }
}
?>