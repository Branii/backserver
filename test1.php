<?php
ini_set("display_errors", 1);
header("Content-Type: application/json");

$dsn = 'mysql:host=192.168.1.51;dbname=bc_lottery';
$user = "enzerhub";
$pass = "enzerhub";

try {
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Select both lt_id and days_times
    $sql = "SELECT lt_id, days_times FROM lottery_name";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $keyValueResults = [];

    foreach ($results as $row) {
        $key = $row['lt_id'];
        $value = $row['days_times'];
        $keyValueResults[$key] = $value;
    }

    echo json_encode([
        "status" => "success",
        "data" => $keyValueResults
    ]);

} catch (PDOException $e) {
    echo json_encode([
        "status" => "error",
        "message" => $e->getMessage()
    ]);
}
