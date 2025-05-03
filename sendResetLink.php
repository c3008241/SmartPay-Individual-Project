<?php





// ----------------This Function may need a google API key to work or a google account with app passwords enabled--------------------- //





use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email address");
    }

    // Generate a unique token
    $token = bin2hex(random_bytes(50));
    $expiry = date("Y-m-d H:i:s", strtotime('+1 hour'));

    // Save token and expiry to the database
    $conn = new mysqli('localhost', 'root', '', 'smartpay');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("INSERT INTO password_resets (email, token, expiry) VALUES (?, ?, ?)");
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("sss", $email, $token, $expiry);
    if ($stmt->execute()) {
        // Send reset link to email using PHPMailer
        $resetLink = "http://yourwebsite.com/resetPassword.php?token=$token";
        $subject = "Password Reset Request";
        $message = "Click the following link to reset your password: $resetLink";

        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'your-email@gmail.com'; 
            $mail->Password = 'your-app-password'; 
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('no-reply@smartpay.com', 'SmartPay');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $message;

            $mail->send();
            echo "Password reset link sent!";
        } catch (Exception $e) {
            echo "Failed to send reset link. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        echo "Execute failed: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>