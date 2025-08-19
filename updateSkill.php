<?php
// 共通関数ファイルを読み込み
require_once 'functions.php';

try {
    // POSTデータの取得
    $skillID = $_POST['skillID'] ?? '';
    $name = $_POST['name'] ?? '';
    $effect = $_POST['effect'] ?? '';

    // バリデーション
    if (empty($skillID) || empty($name) || empty($effect)) {
        throw new Exception("必須項目が入力されていません。");
    }

    // データベースに接続
    $pdo = connectDB();

    // SQL作成（UPDATE文）
    $sql = "UPDATE skillmaster SET SkillName = :SkillName, Effect = :Effect WHERE SkillID = :SkillID";

    // SQL実行
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':SkillName', $name, PDO::PARAM_STR);
    $stmt->bindValue(':Effect', $effect, PDO::PARAM_STR);
    $stmt->bindValue(':SkillID', $skillID, PDO::PARAM_INT);
    $stmt->execute();

    // 更新成功のメッセージを表示し、メニュー画面にリダイレクト
    echo "<script>alert('スキルマスタの更新が完了しました。'); window.location.href = 'skillmasterUPD.php';</script>";
    exit();

} catch (PDOException $e) {
    // データベースエラー
    echo "データベースエラー: " . htmlspecialchars($e->getMessage());
} catch (Exception $e) {
    // その他のエラー
    echo "エラー: " . htmlspecialchars($e->getMessage());
}
?>
