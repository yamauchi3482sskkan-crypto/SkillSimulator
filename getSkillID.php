<?php
// 共通関数ファイルを読み込み
require_once 'functions.php';

try {
    // データベースに接続
    $pdo = connectDB(); 

    // スキルマスタから全データを取得
    $stmt = $pdo->query("SELECT SkillID, SkillName FROM skillmaster ORDER BY SkillID");
    $skills = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // デフォルトのオプションを出力
    echo '<option value="">選択してください</option>';

    // 取得したデータをループしてオプションタグを生成
    foreach ($skills as $skill) {
        $skillID = htmlspecialchars($skill['SkillID']);
        $skillName = htmlspecialchars($skill['SkillName']);
        echo "<option value=\"$skillID\">$skillID : $skillName</option>";
    }

} catch (PDOException $e) {
    // エラー発生時はエラーメッセージを出力
    echo '<option value="">データ取得エラー</option>';
}
?>
