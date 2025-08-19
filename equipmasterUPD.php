<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>装備マスタメンテナンス</title>
	<link rel="stylesheet" href="css/register.css">
</head>	
<body>
	<form method="POST" action="updateEquip.php">

		<div class="combo-group">
			<div class="combo-item">
				<label for="equipID">装備ＩＤ:</label>
				<select id="equipID" name="equipID">
					<?php
						include 'getequipID.php';
					?>
				</select>
			</div>
		</div>

		<div class="combo-group">
			<div class="combo-item">
				<label for="combo2">装備部位:</label>
				<select id="combo2" name="combo2">
				<?php
				    include 'getEquipPartsMaster.php';
				?>
				</select>
			</div>
		</div>

		<div class="text-group">
			<label for="name">装備名:</label>
			<input type="text" id="name" name="name" placeholder="装備名を入力">
		</div>
        
        <div id="skillContainer" class="skill-group">
    		</div>
		<button type="button" id="addSkillBtn">スキル追加</button>

		<div class="button-group">
			<button type="submit">更新</button>
			<button type="button" onclick="location.href='mastermenue.php'">戻る</button>
		</div>
	</form>
</body>
</html>

    
<script>
document.addEventListener("DOMContentLoaded", function () {
  const equipSelect = document.getElementById("equipID");
  const addSkillBtn = document.getElementById("addSkillBtn");
  let allSkills = []; // すべてのスキルを格納する配列

   // ページ読み込み時に、最初の装備の情報を自動取得
  if (equipSelect && equipSelect.value) {
    fetchEquipInfo(equipSelect.value);
  }

  // 装備IDが変更されたときの処理
  if (equipSelect) {
    equipSelect.addEventListener("change", function () {
      const selectedID = this.value;
      if (!selectedID) {
        document.getElementById("name").value = "";
        document.getElementById("combo2").selectedIndex = 0;
        document.getElementById("skillContainer").innerHTML = "";
        return;
      }
      fetchEquipInfo(selectedID);
    });
  }
  
  // スキル追加ボタンのイベントリスナー
  if (addSkillBtn) {
    addSkillBtn.addEventListener("click", addSkillInput);
  }

  // スキル入力フィールドを動的に追加する関数
  function addSkillInput(skillID = '', skillValue = '') {
      const skillContainer = document.getElementById("skillContainer");
      const index = skillContainer.children.length; // 現在のスキル数をインデックスとして使用
      
      const skillDiv = document.createElement("div");
      skillDiv.className = "skill-item";
      
      const optionsHtml = allSkills.map(s => `
          <option value="${s.SkillID}" ${s.SkillID == skillID ? 'selected' : ''}>
              ${s.SkillID} : ${s.SkillName}
          </option>
      `).join('');

      skillDiv.innerHTML = `
        <label for="skillID_${index}">スキル名 ${index + 1}:</label>
        <select id="skillID_${index}" name="skills[${index}][skillID]">
          <option value="">未選択</option>
          ${optionsHtml}
        </select>
        <label for="skillValue_${index}">スキル値:</label>
        <input type="number" id="skillValue_${index}" name="skills[${index}][skillValue]" value="${skillValue}" min="1">
      `;
      skillContainer.appendChild(skillDiv);
  }
  
  // 装備情報を取得してフォームに設定する関数
  function fetchEquipInfo(equipID) {
    fetch(`getequipinfo.php?equipID=${encodeURIComponent(equipID)}`)
      .then(response => response.json())
      .then(data => {
        const nameInput = document.getElementById("name");
        const combo2 = document.getElementById("combo2");
        const skillContainer = document.getElementById("skillContainer");

        if (data.equip && !data.error) {
          nameInput.value = data.equip.EquipName || "";
          if (combo2) {
            for (let option of combo2.options) {
              option.selected = option.value == data.equip.EquipPartsID;
            }
          }
          
          if (data.all_skills) {
              allSkills = data.all_skills; // すべてのスキル情報をキャッシュ
          }
          
          // スキル情報を動的に表示
          if (skillContainer) {
            skillContainer.innerHTML = ''; // コンテンツをクリア
            if (data.skills && data.skills.length > 0) {
              data.skills.forEach((skill, index) => {
                addSkillInput(skill.SkillID, skill.SkillValue);
              });
            } else {
              // スキルが設定されていない場合、空の入力欄を1つ表示
              addSkillInput();
            }
          }
        } else {
          nameInput.value = "";
          if (combo2) combo2.selectedIndex = 0;
          if (skillContainer) skillContainer.innerHTML = '';
        }
      })
      .catch(error => {
        console.error("取得エラー:", error);
      });
  }
});

// フォームのバリデーション関数
function validateForm() {
  const equipID = document.getElementById("equipID").value;
  const part = document.getElementById("combo2").value;
  const name = document.getElementById("name").value.trim();

  if (!equipID || !part || !name) {
    alert("すべての項目を選択または入力してください。");
    return false;
  }
  return true;
}
</script>


<?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
  <script>
    alert("更新が完了しました！");
  </script>
<?php endif; ?>