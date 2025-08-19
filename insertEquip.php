<?php

require_once 'functions.php';

try {
    // PDOでDB接続
    $pdo = connectDB(); // 共通関数からDB接続取得
    // 入力値の取得とバリデーション
    $equipID = isset($_POST['No']) ? (int)$_POST['No'] : 0;
    $equipPartsID = isset($_POST['combo2']) ? (int)$_POST['combo2'] : 0;
    $equipName = isset($_POST['name']) ? trim($_POST['name']) : '';

    if (!$equipID || !$equipPartsID || $equipName === '') {
        throw new Exception("入力値が不正です。");
    }

    // INSERT実行
    $sql = "INSERT INTO equipmaster (EquipID, EquipPartsID, EquipName) VALUES (:id, :parts, :name)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':id', $equipID, PDO::PARAM_INT);
    $stmt->bindValue(':parts', $equipPartsID, PDO::PARAM_INT);
    $stmt->bindValue(':name', $equipName, PDO::PARAM_STR);
    $stmt->execute();

    // 登録完了後にリダイレクト
    header("Location: equipmasterINS.php?success=1");
    exit;


} catch (Exception $e) {
    echo "エラー: " . $e->getMessage();
}
?>
