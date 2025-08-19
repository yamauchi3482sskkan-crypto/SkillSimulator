<?php
require_once 'functions.php';

$equipSetID = $_POST['equipset'] ?? '';
if ($equipSetID === '') {
    exit('装備設定名が選択されていません。');
}

$pdo = connectDB();
$equipSet = getEquipSet($pdo, $equipSetID);
$skills = $equipSet ? getSkills($pdo, [
    $equipSet['HeadEquipID'],
    $equipSet['ChestEquipID'],
    $equipSet['ArmEquipID'],
    $equipSet['BeltEquipID'],
    $equipSet['LegEquipID']
]) : [];

?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>検索結果</title>
  <link rel="stylesheet" href="css/search_result.css">
</head>
<body>
  <h1>検索結果</h1>
  <?php include 'templates/result_table.php'; ?>
    <div class="button-group">
    <button onclick="history.back()">戻る</button>
  </div>
</body>
</html>
