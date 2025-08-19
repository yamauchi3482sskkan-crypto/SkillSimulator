<?php

require_once 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $originalEquipID = $_POST['equipID'] ?? '';
    $equipPartsID = $_POST['combo2'] ?? '';
    $equipName = $_POST['name'] ?? '';
    $skills = $_POST['skills'] ?? [];

    if ($originalEquipID && $equipPartsID && $equipName) {
        // 末尾1桁を除いた装備IDを取得
        $baseID = substr($originalEquipID, 0, -1);
        $newEquipID = intval($baseID . $equipPartsID);

        try {
            $pdo = connectDB(); // 共通関数からDB接続取得
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->beginTransaction();

            // equipmasterテーブルの更新/追加処理
            $checkStmt = $pdo->prepare("SELECT COUNT(*) FROM equipmaster WHERE EquipID = :id");
            $checkStmt->bindParam(':id', $originalEquipID, PDO::PARAM_INT);
            $checkStmt->execute();
            $exists = $checkStmt->fetchColumn();

            if ($newEquipID != $originalEquipID) {
                // equipmasterのIDが変更された場合、既存レコードを削除して新しいIDで再登録
                $deleteStmt = $pdo->prepare("DELETE FROM equipmaster WHERE EquipID = :id");
                $deleteStmt->bindParam(':id', $originalEquipID, PDO::PARAM_INT);
                $deleteStmt->execute();
                
                $insertStmt = $pdo->prepare("INSERT INTO equipmaster (EquipID, EquipPartsID, EquipName) VALUES (:id, :equipPartsID, :equipName)");
                $insertStmt->bindParam(':id', $newEquipID, PDO::PARAM_INT);
                $insertStmt->bindParam(':equipPartsID', $equipPartsID, PDO::PARAM_INT);
                $insertStmt->bindParam(':equipName', $equipName);
                $insertStmt->execute();
            } else {
                // IDが変更されない場合、既存レコードを更新
                $stmt = $pdo->prepare("UPDATE equipmaster SET EquipName = :equipName, EquipPartsID = :equipPartsID WHERE EquipID = :id");
                $stmt->bindParam(':id', $newEquipID, PDO::PARAM_INT);
                $stmt->bindParam(':equipPartsID', $equipPartsID, PDO::PARAM_INT);
                $stmt->bindParam(':equipName', $equipName);
                $stmt->execute();
            }
            
            // equipskillmasterの既存データを削除
            $deleteSkillsStmt = $pdo->prepare("DELETE FROM equipskillmaster WHERE EquipID = :equipID");
            $deleteSkillsStmt->bindParam(':equipID', $originalEquipID, PDO::PARAM_INT);
            $deleteSkillsStmt->execute();

            // 新しいスキルデータを挿入
            if (!empty($skills)) {
                $insertSkillsStmt = $pdo->prepare("INSERT INTO equipskillmaster (EquipID, EquipPartsID, SkillID, SkillValue) VALUES (:equipID, :equipPartsID, :skillID, :skillValue)");
                foreach ($skills as $skill) {
                    // スキルIDが空の場合はスキップ
                    if (empty($skill['skillID'])) {
                        continue;
                    }

                    $insertSkillsStmt->bindParam(':equipID', $newEquipID, PDO::PARAM_INT);
                    $insertSkillsStmt->bindParam(':equipPartsID', $equipPartsID, PDO::PARAM_INT);
                    $insertSkillsStmt->bindParam(':skillID', $skill['skillID'], PDO::PARAM_INT);
                    $insertSkillsStmt->bindParam(':skillValue', $skill['skillValue'], PDO::PARAM_INT);
                    $insertSkillsStmt->execute();
                }
            }

            $pdo->commit();
            header("Location: equipmasterUPD.php?success=1");
            exit;

        } catch (PDOException $e) {
            $pdo->rollBack();
            echo "データ処理エラー: " . htmlspecialchars($e->getMessage());
        }
    } else {
        echo "必要な情報が不足しています。";
    }
}
?>