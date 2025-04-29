<?php
session_start();
include 'connect.php';
$conn = connectDB();

if (isset($_POST['exchangeMoney'])) {
    $user_ID = $_SESSION['user_ID'];
    $targetCurrency = $_POST['currency']; // get the currency u want to convert to [e.g., "USD" american dollars]

    // 1. GET the USER'S current balance, card_ID, and current currency
    $query = "SELECT a.balance, a.card_ID, cu.currencyCode, cu.exchangeRate 
              FROM accounts AS a
              INNER JOIN cards AS ca ON a.card_ID = ca.card_ID
              INNER JOIN currencies AS cu ON ca.currency_ID = cu.currency_ID
              WHERE a.user_ID = $user_ID";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $currentBalance = $row['balance'];
        $card_ID = $row['card_ID'];
        $currentCurrency = $row['currencyCode']; // FOR E.G , "USD"
        $currentExchangeRate = $row['exchangeRate']; // FOR e.g., 1.25 (USD TO GBP)

        // 2,  CONVERT  the current balance to GBP (Pounds)
        $balanceInGBP = $currentBalance / $currentExchangeRate;

        // 3. GET EXCHANGE RATE FRO TARGET CURRENCY!! (e.g., "EUR" → GBP)
        $targetRateQuery = "SELECT currency_ID, exchangeRate FROM currencies WHERE currencyCode = '$targetCurrency'";
        $targetRateResult = $conn->query($targetRateQuery);

        if ($targetRateResult->num_rows > 0) {
            $targetRow = $targetRateResult->fetch_assoc();
            $targetExchangeRate = $targetRow['exchangeRate']; // e.g., 0.85 (EUR → GBP)
            $targetCurrency_ID = $targetRow['currency_ID'];

            // 4. convert GBP to the target currency //// ---- THIS will convert it to british pounds first before making the exchange)!!
            $convertedAmount = round($balanceInGBP * $targetExchangeRate, 2);

            // 5. update BALANCE and CURRENCY in a transaction
            $conn->begin_transaction();
            
            try {
                // update the balance in ACCOUNTS table
                $updateBalanceQuery = "UPDATE accounts SET balance = $convertedAmount WHERE user_ID = $user_ID";
                if (!$conn->query($updateBalanceQuery)) {
                    throw new Exception("Error updating balance: " . $conn->error);
                }

                // update currency in cards table
                $updateCurrencyQuery = "UPDATE cards SET currency_ID = $targetCurrency_ID WHERE card_ID = $card_ID";
                if (!$conn->query($updateCurrencyQuery)) {
                    throw new Exception("Error updating currency: " . $conn->error);
                }

                $conn->commit();

                echo "<script>
                alert('Exchange complete');
                window.location.href = 'moneyBalance.php';
                </script>";

            } catch (Exception $e) {
                $conn->rollback();
                echo "Error during exchange: " . $e->getMessage();
            }
        } else {
            echo "Error: Target currency exchange rate not found.";
        }
    } else {
        echo "Error: User account details not found.";
    }
}
?>