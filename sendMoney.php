<?php 

session_start();

include 'connect.php';
$conn = connectDB();

if (isset($_POST["sendMoney"])) {
    $user_ID = $_SESSION['user_ID']; // Sender's user ID
    $transactionAmount = $_POST['transactionAmount']; 
    $accountNumber= $_SESSION['accountNumber'];
    $sortCode= $_SESSION['sortCode'];


    $checkAccount = "SELECT * FROM accounts WHERE accountNumber='$accountNumber' AND sortCode='$sortCode'";
    $result = $conn->query($checkAccount);

$transactionAmount = $result['transactionAmount'];
$transactionAmount = $result['sortCode'];
$transactionAmount = $result['accountNumber'];


    // Check if the recipient exists in the database
    $query = mysqli_query($conn, "SELECT * FROM users WHERE email = '$recipientEmail'");
    $recipient = mysqli_fetch_assoc($query);

    if ($recipient) {
        $recipient_ID = $recipient['user_ID']; // Get recipient's user ID

        // Check sender's balance
        $query2 = mysqli_query($conn, "SELECT * FROM users WHERE user_ID = '$user_ID'");
        $sender = mysqli_fetch_assoc($query2);

        if ($sender['balance'] >= $transactionAmount) {
            // Deduct amount from sender's balance
            mysqli_query($conn, "UPDATE users SET balance = balance - $transactionAmount WHERE user_ID = '$user_ID'");

            // Add amount to recipient's balance
            mysqli_query($conn, "UPDATE users SET balance = balance + $transactionAmount WHERE user_ID = '$recipient_ID'");

            // Insert transaction into the transactions table
            $insertQuery = "INSERT INTO transactions (sender_ID, recipient_ID, amount) 
                            VALUES ('$user_ID', '$recipient_ID', '$transactionAmount')";
            if (mysqli_query($conn, $insertQuery)) {
                echo "Money sent successfully!";
            } else {
                echo "Error recording transaction: " . mysqli_error($conn);
            }
        } else {
            echo "Insufficient balance!";
        }
    } else {
        echo "Recipient not found!";
    }

}




?>