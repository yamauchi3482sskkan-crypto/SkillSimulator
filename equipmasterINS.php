<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>装備マスタメンテナンス</title>
	<link rel="stylesheet" href="css/register.css">
</head>	
<body>
	<form action="insertEquip.php" method="POST" onsubmit="return validateForm();">
	  <div class="text-group">
	    <label for="equipNo">装備ＩＤ:</label>
	    <input type="text" id="No" name="No" readonly>
	  </div>

	  <div class="combo-group">
	    <div class="combo-item">
	      <label for="combo2">装備部位:</label>
	      <select id="combo2" name="combo2" onchange="fetchNextEquipID()">
	        <?php include 'getEquipPartsMaster.php'; ?>
	      </select>
	    </div>
	  </div>

	  <div class="text-group">
	    <label for="name">装備名:</label>
	    <input type="text" id="name" name="name" placeholder="装備名を入力">
	  </div>

	  <div class="button-group">
	    <button type="submit">登録</button>
	    <button type="button" onclick="location.href='mastermenue.php'">戻る</button>
	  </div>
	</form>

</body>
</html>

<script>
document.addEventListener("DOMContentLoaded", function () {
    // ページロード時に一度、次の装備IDを取得して表示する
    fetchNextEquipID();
});
// 装備部位が変更されたときに次の装備IDを取得する関数
function fetchNextEquipID() {
  const combo2 = document.getElementById("combo2");
  const selectedPartsID = combo2 ? combo2.value : 0;

  fetch(`getNextEquipID.php?equipPartsID=${encodeURIComponent(selectedPartsID)}`)
    .then(response => response.json())
    .then(data => {
      if (data && data.nextID) {
        document.getElementById("No").value = data.nextID;
      } else {
        document.getElementById("No").value = "";
      }
    })
    .catch(error => {
      console.error("装備ID取得エラー:", error);
    });
}

// フォームのバリデーション関数
function validateForm() {
  const id = document.getElementById("No").value.trim();
  const part = document.getElementById("combo2").value;
  const name = document.getElementById("name").value.trim();

  if (!id || !part || !name) {
    alert("すべての項目を入力してください。");
    return false;
  }
  return true;
}
</script>

<?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
  <script>
    alert("登録が完了しました！");
  </script>
<?php endif; ?>