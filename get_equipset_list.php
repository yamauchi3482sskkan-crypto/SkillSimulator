<?php
// DB接続（例）
$host = 'localhost';
$dbname = 'test';
$user = 'root';
$pass = '';

try {
	$pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
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
