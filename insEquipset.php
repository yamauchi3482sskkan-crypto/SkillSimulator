<?php
require_once 'functions.php';



try {
    $pdo = connectDB(); // 共通関数からDB接続取得

    // POSTデータの取得
    $name = $_POST['name'] ?? '';
	$equipData = [
        'combo1' => $_POST['combo1'] ?? '',
        'combo2' => $_POST['combo2'] ?? '',
        'combo3' => $_POST['combo3'] ?? '',
        'combo4' => $_POST['combo4'] ?? '',
        'combo5' => $_POST['combo5'] ?? ''
    ];


    // バリデーション（必要に応じて追加）
    if (empty($name)) {
        throw new Exception("装備設定名が未入力です。");
    }

    // SQL作成
    $sql = "INSERT INTO EquipSet (EquipSetName, HeadEquip, ChestEquip, ArmEquip, BeltEquip, LegEquip)
            VALUES (:EquipSetName, :HeadEquip, :ChestEquip, :ArmEquip, :BeltEquip, :LegEquip)";

    // SQL実行
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':EquipSetName' => $name,
        ':HeadEquip'  => $equipData['combo1'],
        ':ChestEquip' => $equipData['combo2'],
        ':ArmEquip'  => $equipData['combo3'],
        ':BeltEquip' => $equipData['combo4'],
        ':LegEquip'  => $equipData['combo5']

    ]);

	// insEquipset.php の最後
	header("Location: register.php?success=1");
	exit;

} catch (Exception $e) {
    echo "エラー: " . $e->getMessage();
}
?>
