<?php
require_once 'functions.php';

try {
    // PDOでDB接続
    $pdo = connectDB(); // 共通関数からDB接続取得
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // POSTデータの取得
    $equipset_id = $_POST['equipset_id'] ?? '';
    $name = $_POST['name'] ?? '';
    $combo1 = $_POST['combo1'] ?? '';
    $combo2 = $_POST['combo2'] ?? '';
    $combo3 = $_POST['combo3'] ?? '';
    $combo4 = $_POST['combo4'] ?? '';
    $combo5 = $_POST['combo5'] ?? '';

    // バリデーション（必要に応じて追加）
    if (empty($equipset_id)) {
        throw new Exception("EquipSetIDが指定されていません。");
    }
    if (empty($name)) {
        throw new Exception("装備設定名が未入力です。");
    }

    // SQL作成
    $sql = "UPDATE EquipSet
            SET EquipSetName = :EquipSetName,
                HeadEquip = :HeadEquip,
                ChestEquip = :ChestEquip,
                ArmEquip = :ArmEquip,
                BeltEquip = :BeltEquip,
                LegEquip = :LegEquip
            WHERE EquipSetID = :EquipSetID";

    // SQL実行
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':EquipSetName' => $name,
        ':HeadEquip' => $combo1,
        ':ChestEquip' => $combo2,
        ':ArmEquip' => $combo3,
        ':BeltEquip' => $combo4,
        ':LegEquip' => $combo5,
        ':EquipSetID' => $equipset_id
    ]);

	// updEquipset.php の最後
	header("Location: search_edit.php?success=1&equipset_id=" . urlencode($equipset_id));
	exit;

} catch (Exception $e) {
    echo "エラー: " . $e->getMessage();
}
?>
