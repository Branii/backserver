<?php
header('Content-Type: application/json');

$dsn = 'mysql:host=192.168.1.51;dbname=lottery_test';
$user = 'enzerhub';
$pass = 'enzerhub';

try {
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $username = $_POST['username'] ?? '';
    if (empty($username)) {
        echo json_encode(['status' => false, 'message' => 'Username is required.']);
        exit;
    }

    // Get the user and their bank_ids
    $stmt = $pdo->prepare("
        SELECT u.uid, u.username, upm.bank_ids
        FROM users_test u
        JOIN user_payment_methods upm ON u.uid = upm.uid
        WHERE u.username LIKE ?
        LIMIT 1
    ");
    $stmt->execute(["%$username%"]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        echo json_encode(['status' => false, 'message' => 'No user found.']);
        exit;
    }

    $bank_ids = json_decode($user['bank_ids'], true);
    if (!is_array($bank_ids) || empty($bank_ids)) {
        echo json_encode(['status' => false, 'message' => 'No banks found for this user.']);
        exit;
    }

    $placeholders = implode(',', array_fill(0, count($bank_ids), '?'));
    $bankQuery = "SELECT bankid, name AS bank_name, bank_status, bank_type FROM banks WHERE bankid IN ($placeholders)";
    $bankStmt = $pdo->prepare($bankQuery);
    $bankStmt->execute($bank_ids);
    $banks = $bankStmt->fetchAll(PDO::FETCH_ASSOC);

    $response = [
        'uid' => $user['uid'],
        'username' => $user['username'],
        'bank_name_count' => count($banks),
        'bank_type_count' => count(array_unique(array_column($banks, 'bank_type'))),
        'banks' => $banks
    ];

    echo json_encode(['status' => true, 'data' => $response]);
} catch (PDOException $e) {
    echo json_encode(['status' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}
