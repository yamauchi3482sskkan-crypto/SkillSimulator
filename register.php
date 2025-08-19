<?php
require_once 'functions.php'; // 共通関数ファイル

$equipParts = [
  1 => '頭装備',
  2 => '胸装備',
  3 => '腕装備',
  4 => '腰装備',
  5 => '足装備'
];

$equipOptions = [];
foreach ($equipParts as $id => $label) {
  $equipOptions[$id] = getEquipListByPart($id);
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>入力画面</title>
  <link rel="stylesheet" href="css/register.css">
</head>
<body>
  <form action="insEquipset.php" method="post">
    <div class="text-group">
      <label for="name">装備設定名:</label>
      <input type="text" id="name" name="name" placeholder="名前を入力" required>
    </div>

    <div class="combo-group">
      <?php foreach ($equipParts as $id => $label): ?>
        <div class="combo-item">
          <label for="combo<?= $id ?>"><?= $label ?>:</label>
          <select id="combo<?= $id ?>" name="combo<?= $id ?>" required>
            <option value="">選択してください</option>
            <?php foreach ($equipOptions[$id] as $equip): ?>
              <option value="<?= htmlspecialchars($equip['id']) ?>">
                <?= htmlspecialchars($equip['name']) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>
      <?php endforeach; ?>
    </div>

    <div class="button-group">
      <button type="submit">新規登録</button>
      <button type="button" onclick="location.href='menu.php'">メニューに戻る</button>
    </div>
  </form>

  <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
    <script>alert("登録が完了しました！");</script>
  <?php endif; ?>
</body>
</html>
