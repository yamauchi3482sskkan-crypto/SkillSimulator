<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>スキルマスタメンテナンス</title>
	<link rel="stylesheet" href="css/register.css">
</head>	
<body>
	<form action="insertSkill.php" method="POST" onsubmit="return validateForm();">
	  <div class="text-group">
	    <label for="skillID">スキルＩＤ:</label>
	    <input type="text" id="skillID" name="skillID" readonly>
	  </div>

	  <div class="text-group">
		<label for="name">スキル名:</label>
	    <input type="text" id="name" name="name" placeholder="スキル名を入力">
	  </div>

	  <div class="text-group">
	    <label for="effect">効果:</label>
	    <input type="text" id="effect" name="effect" placeholder="効果を入力">
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
    // ページロード時に一度、次のスキルIDを取得して表示する
    fetchNextSkillID();
});

function fetchNextSkillID() {
    fetch('getNextSkillID.php')
        .then(response => response.json())
        .then(data => {
            if (data && data.nextID) {
                document.getElementById('skillID').value = data.nextID;
            }
        })
        .catch(error => console.error('スキルIDの取得エラー:', error));
}

// フォームのバリデーション関数
function validateForm() {
  const name = document.getElementById("name").value.trim();
  const effect = document.getElementById("effect").value.trim();

  if (name === "" || effect === "") {
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