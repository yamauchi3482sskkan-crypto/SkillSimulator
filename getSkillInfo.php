<?php
// 共通関数ファイルを読み込み
require_once 'functions.php';

header('Content-Type: application/json; charset=UTF-8');

$response = ['error' => true];

// GETパラメータからスキルIDを取得
$skillID = $_GET['skillID'] ?? '';

if (!empty($skillID)) {
    try {
        // データベースに接続
        $pdo = connectDB();

        // プリペアドステートメントでSQLインジェクションを防止
        $sql = "SELECT SkillName, Effect FROM skillmaster WHERE SkillID = :skillID";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':skillID', $skillID, PDO::PARAM_INT);
        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data) {
            $response = ['error' => false, 'SkillName' => $data['SkillName'], 'Effect' => $data['Effect']];
        } else {
            $response['message'] = 'スキルが見つかりませんでした。';
        }

    } catch (PDOException $e) {
        $response['message'] = 'データベースエラー: ' . $e->getMessage();
    }
} else {
    $response['message'] = 'スキルIDが指定されていません。';
}

echo json_encode($response);
?>
