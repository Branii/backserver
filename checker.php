<?php

$dsn = 'mysql:host=192.168.1.51;dbname=lottery_test';
$user = "enzerhub";
$pass = "enzerhub";

try {
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $query = "
        SELECT 
            u.uid,
            u.username,
            upm.bank_ids
        FROM users_test u
        JOIN user_payment_methods upm ON u.uid = upm.uid
    ";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $result = [];

    foreach ($users as $user) {
        $bank_ids = json_decode($user['bank_ids'], true);
        if (!is_array($bank_ids) || empty($bank_ids)) continue;

        $placeholders = implode(',', array_fill(0, count($bank_ids), '?'));
        $bankQuery = "
            SELECT bankid, name AS bank_name, bank_status, bank_type
            FROM banks
            WHERE bankid IN ($placeholders)
        ";
        $bankStmt = $pdo->prepare($bankQuery);
        $bankStmt->execute($bank_ids);
        $banks = $bankStmt->fetchAll(PDO::FETCH_ASSOC);

        $result[] = [
            'uid' => $user['uid'],
            'username' => $user['username'],
            'bank_name_count' => count($banks),
            'bank_type_count' => count($banks), // You can add logic to count unique types if needed
            'banks' => $banks
        ];
    }
} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Bank Summary</title>
    <style>
        body {
            font-family: Arial;
            margin: 20px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 40px;
        }

        th, td {
            border: 1px solid #aaa;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f9f9f9;
        }

        h2 {
            color: #444;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            background-color: #fff;
            margin: 10% auto;
            padding: 20px;
            border-radius: 10px;
            width: 50%;
        }

        .modal-content input {
            width: 100%;
            padding: 8px;
            margin: 5px 0 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .close {
            float: right;
            font-size: 20px;
            cursor: pointer;
        }

        button.view-btn {
            padding: 6px 10px;
            background-color: #007BFF;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }
    </style>
</head>
<body>

    <h2>User Bank Summary Table</h2>

    <table>
        <thead>
            <tr>
                <th>UID</th>
                <th>Username</th>
                <th>Total Bank Names</th>
                <th>Total Bank Types</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($result as $user): ?>
                <tr>
                    <td><?= htmlspecialchars($user['uid']) ?></td>
                    <td><?= htmlspecialchars($user['username']) ?></td>
                    <td><?= $user['bank_name_count'] ?></td>
                    <td><?= $user['bank_type_count'] ?></td>
                    <td>
                        <button class="view-btn" onclick='openModal(<?= json_encode($user['banks'], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>)'>View</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Modal -->
    <div id="bankModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h3>Bank Details</h3>
            <div id="bankDetails"></div>
        </div>
    </div>

    <script>
        function openModal(banks) {
            const detailsContainer = document.getElementById("bankDetails");
            detailsContainer.innerHTML = ""; // Clear previous content

            banks.forEach(bank => {
                detailsContainer.innerHTML += `
                    <label>Bank Name</label>
                    <input type="text" readonly value="${bank.bank_name}">
                    <label>Bank Type</label>
                    <input type="text" readonly value="${bank.bank_type}">
                `;
            });

            document.getElementById("bankModal").style.display = "block";
        }

        function closeModal() {
            document.getElementById("bankModal").style.display = "none";
        }
    </script>

</body>
</html>
