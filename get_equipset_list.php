<?php
require_once 'functions.php';

try {
    $pdo = connectDB(); // 共通関数からDB接続取得
	// EquipSetテーブルからデータ取得
	$sql = "SELECT EquipSetID, EquipSetName FROM EquipSet ORDER BY EquipSetID";
	$stmt = $pdo->query($sql);

	// コンボボックスの選択肢として表示
	echo '<option value="">選択してください</option>';
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
	    echo "<option value=\"{$row['EquipSetID']}\">{$row['EquipSetName']}</option>";
	}
} catch (PDOException $e) {
    echo "<option disabled>データベース接続エラー</option>";
}

?>
