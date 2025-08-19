<?php
require_once 'functions.php';

try {
    // プリペアドステートメントで安全にパラメータをバインド
    $pdo = connectDB(); // 共通関数からDB接続取得
    $stmt = $pdo->prepare("SELECT EquipID,EquipName  FROM equipmaster" );
    $stmt->execute();

    // オプションを出力
    echo '<option value="">選択してください</option>';
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $equipID = htmlspecialchars($row['EquipID']);
        $equipName = htmlspecialchars($row['EquipName']); // 装備名も表示する
        $selected = (isset($selected_id) && $selected_id == $equipID) ? ' selected' : '';
        echo "<option value=\"$equipID\"$selected>$equipID : $equipName</option>";
    }

} catch (PDOException $e) {
    echo '<option value="">データ取得エラー</option>';
}
?>