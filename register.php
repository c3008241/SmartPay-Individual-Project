<?php
include 'connect.php';

ini_set('display_errors', 1);
error_reporting(E_ALL);


if (isset($_POST['signUpItems'])) {
    // Grab form values
    $prefix = $_POST['prefix'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $mobileNumber = $_POST['mobileNumber'];
    if($_POST['password'] == $_POST['confirmPassoword']){
        $password = $_POST['password'];
    }
    else
    { 
        echo "Passwords do not match!";
        exit();
    }

    // Check if email already exists
    $checkEmail = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($checkEmail);

    if ($result->num_rows > 0) {
        echo "Email Address Already Exists!";
    } else {
        // Hash password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Prepared Statement to insert user
        $stmt = $conn->prepare("INSERT INTO users (prefix, firstName, lastName, email, password) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $prefix, $firstName, $lastName, $email, $hashedPassword);

        // Execute and check if successful
        if ($stmt->execute()) {
            header("Location: logIn.html");
            exit();
        } else {
            echo "Error: " . $conn->error;
        }
    }
}
?>
