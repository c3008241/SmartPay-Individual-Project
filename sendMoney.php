<?php 

session_start();

include 'connect.php';
$conn = connectDB();



function formatCurrency($amount, $currencyID, $conn) {
    $query = "SELECT symbol FROM currencies WHERE currency_ID = ?";
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        throw new Exception("Currency format prepare failed: " . $conn->error);
    }
    $stmt->bind_param("i", $currencyID);
    if (!$stmt->execute()) {
        throw new Exception("Currency format execute failed: " . $stmt->error);
    }
    $result = $stmt->get_result();
    $currency = $result->fetch_assoc();
    $stmt->close();
    return $currency['symbol'] . number_format($amount, 2);
}


if (isset($_POST["sendMoney"])) {
    $conn = connectDB();
    if ($conn->connect_error) {
        die("<div class='error-message'>Database connection failed: " . $conn->connect_error . "</div>");
    }

    $accountNumber = isset($_POST['recipientAccountNumber']) ? trim($_POST['recipientAccountNumber']) : '';
    $sortCode = isset($_POST['recipientSortCode']) ? trim($_POST['recipientSortCode']) : '';
    $amount = isset($_POST['amount']) ? floatval($_POST['amount']) : 0;
    $senderId = isset($_SESSION['user_ID']) ? $_SESSION['user_ID'] : null;

    if (empty($accountNumber) || empty($sortCode) || $amount <= 0 || empty($senderId)) {
        die("<div class='error-message'>Please fill all fields correctly.</div>");
    }

    $stmt = null; 

    try {
        $senderQuery = "SELECT a.account_ID, a.balance, cu.currency_ID 
                       FROM users u
                       INNER JOIN accounts a ON u.user_ID = a.user_ID
                       INNER JOIN cards c ON a.card_ID = c.card_ID
                       INNER JOIN currencies cu ON c.currency_ID = cu.currency_ID
                       WHERE u.user_id = ?";
        $stmt = $conn->prepare($senderQuery);
        if ($stmt === false) {
            throw new Exception("Prepare failed: " . $conn->error);
        }
        
        if (!$stmt->bind_param("i", $senderId)) {
            throw new Exception("Bind failed: " . $stmt->error);
        }
        
        if (!$stmt->execute()) {
            throw new Exception("Execute failed: " . $stmt->error);
        }

        $senderResult = $stmt->get_result();
        if ($senderResult->num_rows === 0) {
            throw new Exception("Sender account not found.");
        }

        $sender = $senderResult->fetch_assoc();
        $senderAccountId = $sender['account_ID'];
        $senderBalance = $sender['balance'];
        $senderCurrency = $sender['currency_ID'];
        $stmt->close(); 


        if ($senderBalance < $amount) {
            $formattedBalance = formatCurrency($senderBalance, $senderCurrency, $conn);
            throw new Exception("Insufficient funds. Your balance: $formattedBalance");
            echo "<script>
            alert('Insufficient funds. Your balance: $formattedBalance');
            window.location.href = 'moneyBalance.php';
            </script>";
exit();
        }


        $recipientQuery = "SELECT a.account_ID, u.user_ID, a.balance, cu.currency_ID
                          FROM users u
                          INNER JOIN accounts a ON u.user_ID = a.user_ID
                          INNER JOIN cards c ON a.card_ID = c.card_ID
                          INNER JOIN currencies cu ON c.currency_ID = cu.currency_ID
                          WHERE c.accountNumber = ?
                          AND c.sortCode = ?
                          AND cu.currency_ID = ?";
        
        $stmt = $conn->prepare($recipientQuery);
        if ($stmt === false) {
            throw new Exception("Recipient prepare failed: " . $conn->error);
        }
        
        if (!$stmt->bind_param("ssi", $accountNumber, $sortCode, $senderCurrency)) {
            throw new Exception("Recipient bind failed: " . $stmt->error);
        }
        
        if (!$stmt->execute()) {
            throw new Exception("Recipient execute failed: " . $stmt->error);
        }

        $recipientResult = $stmt->get_result();
        if ($recipientResult->num_rows === 0) {
            echo "<script>
            alert('Wrong card user details or currency mismatch!');
            window.location.href = 'moneyBalance.php';
          </script>";
    exit();
        }

        $recipient = $recipientResult->fetch_assoc();
        $recipientAccountId = $recipient['account_ID'];
        $recipientUserId = $recipient['user_ID'];
        $recipientBalance = $recipient['balance'];
        $stmt->close(); 


        $conn->begin_transaction();



        $updateSender = "UPDATE accounts SET balance = balance - ? WHERE account_ID = ?";
        $stmt = $conn->prepare($updateSender);
        if ($stmt === false) {
            throw new Exception("Sender update prepare failed: " . $conn->error);
        }
        if (!$stmt->bind_param("di", $amount, $senderAccountId)) {
            throw new Exception("Sender update bind failed: " . $stmt->error);
        }
        if (!$stmt->execute()) {
            throw new Exception("Sender update execute failed: " . $stmt->error);
        }
        $stmt->close();



        $updateRecipient = "UPDATE accounts SET balance = balance + ? WHERE account_ID = ?";
        $stmt = $conn->prepare($updateRecipient);
        if ($stmt === false) {
            throw new Exception("Recipient update prepare failed: " . $conn->error);
        }
        if (!$stmt->bind_param("di", $amount, $recipientAccountId)) {
            throw new Exception("Recipient update bind failed: " . $stmt->error);
        }
        if (!$stmt->execute()) {
            throw new Exception("Recipient update execute failed: " . $stmt->error);
        }
        $stmt->close();

$transactionQuery = "INSERT INTO transactions 
(sender_id, recipient_id, amount, currencyID, transaction_date, status)
VALUES (?, ?, ?, ?, NOW(), 'completed')";

$stmt = $conn->prepare($transactionQuery);
if ($stmt === false) {
    throw new Exception("Transaction prepare failed: " . $conn->error);
}

if (!$stmt->bind_param("iidd", $senderId, $recipientUserId, $amount, $senderCurrency)) {
    throw new Exception("Transaction bind failed: " . $stmt->error);
}

if (!$stmt->execute()) {
    throw new Exception("Transaction execute failed: " . $stmt->error);
}
$stmt->close();

$conn->commit();

$_SESSION['receipt_data'] = [
    'amount' => $amount,
    'currency_id' => $senderCurrency,
    'recipient_account' => $accountNumber,
    'recipient_sortcode' => $sortCode,
    'new_balance' => round($senderBalance - $amount, 2)

];

$recipientNameQuery = "SELECT firstName, lastName FROM users WHERE user_ID = ?";
$stmt = $conn->prepare($recipientNameQuery);
$stmt->bind_param("i", $recipientUserId);
$stmt->execute();
$recipientNameResult = $stmt->get_result();
$recipientName = $recipientNameResult->fetch_assoc();
$stmt->close();

$_SESSION['receipt_data']['recipient_name'] = $recipientName['firstName'] . ' ' . $recipientName['lastName'];

echo "<script>
        alert('Transaction successful!');
        window.location.href = 'reviewTransfer.php';
      </script>";
exit();


    } catch (Exception $e) {
        if ($conn && $conn->connect_errno === 0 && $conn->thread_id) {
            $conn->rollback();
        }
        die("<div class='error-message'>Transfer failed: " . htmlspecialchars($e->getMessage()) . "</div>");
    } finally {
        if (isset($stmt) && is_object($stmt) && get_class($stmt) === 'mysqli_stmt') {
        }
        if ($conn) {
            $conn->close();
        }
    }
}



?>