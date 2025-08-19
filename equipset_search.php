<?php
require_once 'functions.php'; // 共通関数ファイル
$equipsetOptions = getEquipsetOptions(); // 装備設定リストを取得
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>検索条件</title>
  <link rel="stylesheet" href="css/equipset_search.css">
</head>
<body>
  <div class="form-container">
    <form method="post">
      <div class="equipset-container">
        <label for="equipset">装備設定名:</label>
        <select id="equipset" name="equipset" required>
          <option value="">選択してください</option>
          <?php foreach ($equipsetOptions as $id => $name): ?>
            <option value="<?= htmlspecialchars($id) ?>"><?= htmlspecialchars($name) ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="button-group">
        <button type="submit" formaction="search_result.php">検索結果表示</button>
        <button type="submit" formaction="search_edit.php">検索結果修正</button>
        <button type="button" onclick="location.href='menu.php'">メニューに戻る</button>
      </div>
    </form>
  </div>
</body>
</html>
