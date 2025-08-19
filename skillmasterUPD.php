<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>スキルマスタメンテナンス</title>
	<link rel="stylesheet" href="css/register.css">
</head>	
<body>
	<!-- フォームの送信先をupdateSkill.phpに指定し、バリデーション関数を呼び出す -->
	<form method="POST" action="updateSkill.php" onsubmit="return validateForm();">

		<div class="combo-group">
			<div class="combo-item">
				<label for="skillID">スキルＩＤ:</label>
				<!-- スキルIDのドロップダウンメニュー -->
				<select id="skillID" name="skillID" required>
					<?php
						// getskillID.phpをインクルードして、スキルIDのオプションを生成
						include 'getskillID.php';
					?>
				</select>
			</div>
		</div>

		<div class="text-group">
			<label for="name">スキル名:</label>
			<input type="text" id="name" name="name" placeholder="スキル名を入力" required>
		</div>

		<div class="text-group">
			<label for="effect">効果:</label>
			<input type="text" id="effect" name="effect" placeholder="効果を入力" required>
		</div>

		<div class="button-group">
			<button type="submit">更新</button>
			<button type="button" onclick="location.href='mastermenue.php'">戻る</button>
		</div>
	</form>
</body>
</html>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const skillSelect = document.getElementById("skillID");
    const nameInput = document.getElementById("name");
    const effectInput = document.getElementById("effect");

    // ページロード時に、最初の選択項目が空でない場合にスキル情報を取得
    if (skillSelect && skillSelect.value) {
        fetchSkillInfo(skillSelect.value);
    }

    // スキルIDが変更されたときの処理
    if (skillSelect) {
        skillSelect.addEventListener("change", function () {
            const selectedID = this.value;
            if (!selectedID) {
                // 選択が空になった場合はフォームをクリア
                nameInput.value = "";
                effectInput.value = "";
                return;
            }
            fetchSkillInfo(selectedID);
        });
    }

    // 選択されたスキルの情報を取得してフォームに設定する関数
    function fetchSkillInfo(skillID) {
        fetch(`getskillinfo.php?skillID=${encodeURIComponent(skillID)}`)
            .then(response => response.json())
            .then(data => {
                if (data && !data.error) {
                    nameInput.value = data.SkillName || "";
                    effectInput.value = data.Effect || "";
                } else {
                    // データ取得エラーの場合、フォームをクリア
                    nameInput.value = "";
                    effectInput.value = "";
                }
            })
            .catch(error => {
                console.error("取得エラー:", error);
                // ネットワークエラーなどの場合もフォームをクリア
                nameInput.value = "";
                effectInput.value = "";
            });
    }
});

// フォームのバリデーション関数
function validateForm() {
    const skillID = document.getElementById("skillID").value;
    const name = document.getElementById("name").value.trim();
    const effect = document.getElementById("effect").value.trim();

    if (!skillID || !name || !effect) {
        // alert()は使わず、カスタムモーダルなどを実装する
        console.error("すべての項目を入力してください。");
        return false;
    }
    return true;
}
</script>

