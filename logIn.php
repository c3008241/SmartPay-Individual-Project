<?php
include 'connect.php';

if(isset($_POST['logIn'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if(password_verify($password, $row['password'])) {
            session_start();
            $_SESSION['email'] = $row['email'];
            header("Location: homePage.php");
            exit();
        } else {
            echo "Incorrect email or password.";
        }
    } else {
        echo "User not found.";
    }
}
?>
