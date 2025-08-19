<?php
require_once 'functions.php'; // データベース接続関数を共通化

header('Content-Type: application/json');

try {
    $pdo = connectDB();
    $sql = 'SELECT MAX(skillid) FROM skillmaster';
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $maxSkillId = $stmt->fetchColumn();

    $nextSkillId = $maxSkillId !== false ? (int)$maxSkillId + 1 : 1;
    echo json_encode(['nextID' => $nextSkillId]);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'DB接続エラー: ' . $e->getMessage()]);
}
?>