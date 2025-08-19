<?php
require_once 'functions.php';

try {
    $pdo = connectDB(); // 共通関数からDB接続取得
    $stmt = $pdo->query("SELECT EquipPartsID, EquipPartsName FROM equippartsmaster");

    echo '<option value="">選択してください</option>';
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $id = htmlspecialchars($row['EquipPartsID']);
        $name = htmlspecialchars($row['EquipPartsName']);
        echo "<option value=\"$id\">$name</option>";
    }

} catch (PDOException $e) {
    echo '<option value="">部位取得エラー</option>';
}
?>
