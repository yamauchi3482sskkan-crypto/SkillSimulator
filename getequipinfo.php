<?php
require_once 'functions.php';

if (isset($_GET['equipID'])) {
    $equipID = $_GET['equipID'];

    try {
        $pdo = connectDB(); 

        // 装備の基本情報を取得
        $stmt_equip = $pdo->prepare("SELECT EquipName, EquipPartsID FROM equipmaster WHERE EquipID = ?");
        $stmt_equip->execute([$equipID]);
        $equip_data = $stmt_equip->fetch(PDO::FETCH_ASSOC);

        // 装備に紐づくスキル情報を取得
        $stmt_skills = $pdo->prepare("
            SELECT
                esm.SkillID,
                esm.SkillValue
            FROM
                equipskillmaster AS esm
            WHERE
                esm.EquipID = ?
        ");
        $stmt_skills->execute([$equipID]);
        $skills_data = $stmt_skills->fetchAll(PDO::FETCH_ASSOC);

        // すべての利用可能なスキルを取得
        $stmt_all_skills = $pdo->query("SELECT SkillID, SkillName FROM skillmaster ORDER BY SkillID");
        $all_skills_data = $stmt_all_skills->fetchAll(PDO::FETCH_ASSOC);

        // 結果を結合してJSONで返す
        $response = [
            'equip' => $equip_data,
            'skills' => $skills_data,
            'all_skills' => $all_skills_data
        ];

        echo json_encode($response);

    } catch (PDOException $e) {
        echo json_encode(['error' => 'DB接続エラー']);
    }
}
?>