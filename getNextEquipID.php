<?php
require_once 'functions.php';

try {

$pdo = connectDB(); // 共通関数からDB接続取得
// 装備部位IDを取得
    $equipPartsID = isset($_GET['equipPartsID']) ? (int)$_GET['equipPartsID'] : 0;

// SQL実行
$sql = "SELECT MAX(TRUNCATE(EquipID, -1)) + 10 + :equipPartsID AS nextID FROM equipmaster";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':equipPartsID', $equipPartsID, PDO::PARAM_INT);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

// JSONで返す
    echo json_encode(['nextID' => $result['nextID'] ?? null]);
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);

}
?>