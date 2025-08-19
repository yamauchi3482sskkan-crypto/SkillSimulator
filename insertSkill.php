<?php

require_once 'functions.php';

try {
    // PDOでDB接続
    $pdo = connectDB(); // 共通関数からDB接続取得
    // 入力値の取得とバリデーション
    $skillID = isset($_POST['skillID']) ? (int)$_POST['skillID'] : 0;
    $effect = isset($_POST['effect']) ? trim($_POST['effect']) : '';
    $skillName = isset($_POST['name']) ? trim($_POST['name']) : '';

    if (!$skillID || !$effect === '' || $skillName === '') {
        throw new Exception("入力値が不正です。");
    }

    // INSERT実行
    $sql = "INSERT INTO skillmaster (SkillID, Effect, SkillName) VALUES (:skillID, :effect, :skillName)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':skillID', $skillID, PDO::PARAM_INT);
    $stmt->bindValue(':effect', $effect, PDO::PARAM_STR);
    $stmt->bindValue(':skillName', $skillName, PDO::PARAM_STR);
    $stmt->execute();

    // 登録完了後にリダイレクト
    header("Location: skillmasterINS.php?success=1");
    exit;


} catch (Exception $e) {
    echo "エラー: " . $e->getMessage();
}
?>
