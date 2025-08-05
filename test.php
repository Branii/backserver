<?php


$dsn = 'mysql:host=192.168.1.51;dbname=lottery_test'; // Fixed variable name and removed extra space
$pass = "enzerhub";
$user = "enzerhub";

try {
    $pdo = new PDO($dsn, $user, $pass);
 //    echo "Connected";
} catch (\Throwable $th) {
    echo $th->getMessage();
    
}
    //  function updateUserCryptoWalletBalanceByAddressWithUserId($pdo,$blockChainNetwork, $newBalance) {
       
    //     $allowedNetworks = ['bitcoin', 'ethereum', 'tron', 'btc', 'trx'];
    //     if (!in_array($blockChainNetwork, $allowedNetworks)) {
    //         throw new InvalidArgumentException("Invalid blockchain network: $blockChainNetwork");
    //     }

    //     // First, get the user_id
    //     $getUserSql = sprintf(
    //         "SELECT uid, email, username, contact, JSON_EXTRACT(crypto_wallets, '$.%s.user_id') AS user_id,
    //         JSON_EXTRACT(crypto_wallets, '$.%s.balance') AS balance
    //      FROM users_test
    //      WHERE crypto_wallets IS NOT NULL
    //        AND JSON_VALID(crypto_wallets) = 1
    //        AND JSON_EXTRACT(crypto_wallets, '$.%s') IS NOT NULL
    //        AND JSON_EXTRACT(crypto_wallets, '$.%s.wallet_address') = ?",
    //         $blockChainNetwork,
    //         $blockChainNetwork,
    //         $blockChainNetwork,
    //         $blockChainNetwork
    //     );
    //      $stmt = $pdo->prepare($getUserSql);
    //      $stmt->execute([$cryptoAddress]);
    //      $userResult = $stmt->fetch(PDO::FETCH_ASSOC);
    //     if (!$userResult) {
    //         return null; // No matching record found
    //     }

    //     $userId = $userResult['uid'];
    //     $userBalance = $userResult['balance'];
    //     $uid = $userResult['uid'];
    //     // // Now update the balance
    //     $updateSql = sprintf(
    //         "UPDATE users_test
    //      SET crypto_wallets = JSON_SET(
    //          crypto_wallets,
    //          '$.%s.balance',
    //          CAST((COALESCE(JSON_EXTRACT(crypto_wallets, '$.%s.balance'), 0) + ?) AS DECIMAL(20,10))
    //      )
    //      WHERE uid = ?",
    //         $blockChainNetwork,
    //         $blockChainNetwork
    //     );

    //         $updateStmt = $pdo->prepare($updateSql);
    //         $updateStmt->execute([$newBalance, $uid]);
    //     return $updateStmt ? [
    //         "user_id" => $userId,
    //         "balance_before" => $userBalance,
    //         "username" => $userResult['username'],
    //         "user_email" => $userResult['email'],
    //         "contact" => $userResult['contact']
    //     ] : null;
    // }

    // echo json_encode(
    //     updateUserCryptoWalletBalanceByAddressWithUserId($pdo,'ethereum', 10)
    // );


 function updateUserCryptoWalletBalanceByAddressWithUserId($pdo, $blockChainNetwork, $newBalance, $uid)
{
    $allowedNetworks = ['bitcoin', 'ethereum', 'tron', 'btc', 'trx'];
    if (!in_array($blockChainNetwork, $allowedNetworks)) {
        throw new InvalidArgumentException("Invalid blockchain network: $blockChainNetwork");
    }

    // Step 1: Update the balance directly by adding to the existing one
    $updateSql = sprintf(
        "UPDATE users_test
         SET crypto_wallets = JSON_SET(
             crypto_wallets,
             '$.%s.balance',
             CAST((COALESCE(JSON_EXTRACT(crypto_wallets, '$.%s.balance'), 0) + ?) AS DECIMAL(20,10))
         )
         WHERE uid = ?",
        $blockChainNetwork,
        $blockChainNetwork
    );

    $stmt = $pdo->prepare($updateSql);
    $success = $stmt->execute([$newBalance, $uid]);

    if ($success) {
        return [
            "status" => "success",
            "uid" => $uid,
            "blockchain" => $blockChainNetwork,
            "deposit" => $newBalance
        ];
    } else {
        return [
            "status" => "error",
            "message" => "Failed to update balance"
        ];
    }
}

echo json_encode(updateUserCryptoWalletBalanceByAddressWithUserId($pdo,'ethereum',3,3));