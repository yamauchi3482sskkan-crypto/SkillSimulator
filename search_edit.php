<?php
require_once 'functions.php'; // 共通関数ファイル

$equipParts = [
  1 => '頭装備',
  2 => '胸装備',
  3 => '腕装備',
  4 => '腰装備',
  5 => '足装備'
];
// 装備IDごとのオプションリストを取得
$equipOptions = [];
foreach ($equipParts as $id => $label) {
  $equipOptions[$id] = getEquipListByPart($id);
}
// リクエストからEquipSetIDを取得
$equipset_id = $_POST['equipset'] ?? $_GET['equipset_id'] ?? null;
if ($equipset_id === '') {
  echo '装備設定名が選択されていません。';
  exit;
}

// データベース接続
$pdo = connectDB();

// 装備設定情報取得
$sql = 'SELECT EquipSetName, HeadEquip, ChestEquip, ArmEquip, BeltEquip, LegEquip FROM equipset WHERE EquipSetID = :id';
$stmt = $pdo->prepare($sql);
$stmt->execute([':id' => $equipset_id]);
$equipset_data = $stmt->fetch(PDO::FETCH_ASSOC);

// 各部位の初期値を取得
$selectedEquips = [
    1 => $equipset_data['HeadEquip'] ?? null,
    2 => $equipset_data['ChestEquip'] ?? null,
    3 => $equipset_data['ArmEquip'] ?? null,
    4 => $equipset_data['BeltEquip'] ?? null,
    5 => $equipset_data['LegEquip'] ?? null,
];
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>更新画面</title>
	<link rel="stylesheet" href="css/register.css">
</head>
<body>

  <form action="updEquipset.php" method="post">
    <!-- ラベル＋入力欄（横並び） -->
    <div class="text-group">
      <label for="name">装備設定名:</label>
      <input type="text" id="name" name="name" placeholder="名前を入力"
       value="<?= htmlspecialchars($equipset_data['EquipSetName'] ?? '') ?>">
    </div>

    <!-- コンボボックス（縦並び、各項目は横並び） -->
	<div class="combo-group">
      <?php foreach ($equipParts as $id => $label): ?>
        <div class="combo-item">
          <label for="combo<?= $id ?>"><?= $label ?>:</label>
          <select id="combo<?= $id ?>" name="combo<?= $id ?>" required>
            <option value="">選択してください</option>
            <?php foreach ($equipOptions[$id] as $equip): ?>
              <option value="<?= htmlspecialchars($equip['id']) ?>"
                <?= ($selectedEquips[$id] == $equip['id']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($equip['name']) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>
      <?php endforeach; ?>

	</div>

	<div class="button-group">
	    <button type="submit">更新</button>
	    <button type="button" onclick="location.href='equipset_search.php'">戻る</button>
	</div>
	
	<input type="hidden" name="equipset_id" value="<?= htmlspecialchars($equipset_id) ?>">

  </form>
</body>
</html>
<?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
  <script>
    alert("更新が完了しました！");
  </script>
<?php endif; ?>
