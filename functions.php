<?php
function connectDB(): PDO {
    // SQLiteファイルのパス
    $dbPath = __DIR__ . '/SkillSearchTool.db';
    return new PDO('sqlite:' . $dbPath);
    
}


function getEquipSet(PDO $pdo, string $equipSetID): ?array {
    $sql = <<<SQL
        SELECT 
            a.EquipSetName,
            a.HeadEquip AS HeadEquipID,
            a.ChestEquip AS ChestEquipID,
            a.ArmEquip AS ArmEquipID,
            a.BeltEquip AS BeltEquipID,
            a.LegEquip AS LegEquipID,
            b.EquipName AS HeadEquipName,
            c.EquipName AS ChestEquipName,
            d.EquipName AS ArmEquipName,
            e.EquipName AS BeltEquipName,
            f.EquipName AS LegEquipName
        FROM equipset a
        LEFT JOIN equipmaster b ON a.HeadEquip = b.EquipID
        LEFT JOIN equipmaster c ON a.ChestEquip = c.EquipID
        LEFT JOIN equipmaster d ON a.ArmEquip = d.EquipID
        LEFT JOIN equipmaster e ON a.BeltEquip = e.EquipID
        LEFT JOIN equipmaster f ON a.LegEquip = f.EquipID
        WHERE a.EquipSetID = :id
    SQL;

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $equipSetID, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
}

function getSkills(PDO $pdo, array $equipIDs): array {
    if (empty($equipIDs)) return [];

    $placeholders = implode(',', array_fill(0, count($equipIDs), '?'));
    $sql = <<<SQL
        SELECT 
            b.SkillName,
            b.Effect,
            a.SkillValue,
            c.EquipPartsName
        FROM equipskillmaster a
        LEFT JOIN skillmaster b ON a.SkillID = b.SkillID
        LEFT JOIN equippartsmaster c ON a.EquipPartsID = c.EquipPartsID
        WHERE a.EquipID IN ($placeholders)
        ORDER BY a.SkillID, a.EquipPartsID
    SQL;

    $stmt = $pdo->prepare($sql);
    $stmt->execute($equipIDs);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getEquipsetOptions(): array {
    
    try {
        $pdo = connectDB();
        $stmt = $pdo->query("SELECT EquipSetID, EquipSetName FROM equipset ORDER BY EquipSetName");
        $options = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $options[$row['EquipSetID']] = $row['EquipSetName'];
        }
        return $options;
    } catch (PDOException $e) {
        return [];
    }
}

function getEquipListByPart(int $partID): array {

    try {
        $pdo = connectDB();
        $stmt = $pdo->prepare("SELECT EquipID AS id, EquipName AS name FROM equipmaster WHERE EquipPartsID = :partID ORDER BY EquipName");
        $stmt->execute([':partID' => $partID]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return [];
    }
}