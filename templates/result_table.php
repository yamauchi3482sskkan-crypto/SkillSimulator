<?php if ($equipSet): ?>
  <h2>装備設定</h2>
  <table border="1">
    <tr>
      <th>装備設定名</th>
      <th>頭装備</th>
      <th>胸装備</th>
      <th>腕装備</th>
      <th>腰装備</th>
      <th>足装備</th>
    </tr>
    <tr>
      <td><?= htmlspecialchars($equipSet['EquipSetName']) ?></td>
      <td><?= htmlspecialchars($equipSet['HeadEquipName']) ?></td>
      <td><?= htmlspecialchars($equipSet['ChestEquipName']) ?></td>
      <td><?= htmlspecialchars($equipSet['ArmEquipName']) ?></td>
      <td><?= htmlspecialchars($equipSet['BeltEquipName']) ?></td>
      <td><?= htmlspecialchars($equipSet['LegEquipName']) ?></td>
    </tr>
  </table>
<?php else: ?>
  <p>該当する装備設定が見つかりませんでした。</p>
<?php endif; ?>

<?php if (!empty($skills)): ?>
  <h2>スキル情報</h2>
  <table border="1">
    <tr>
      <th>スキル名</th>
      <th>効果</th>
      <th>スキル値</th>
      <th>装備部位</th>
    </tr>
    <?php foreach ($skills as $skill): ?>
      <tr>
        <td><?= htmlspecialchars($skill['SkillName']) ?></td>
        <td><?= htmlspecialchars($skill['Effect']) ?></td>
        <td><?= htmlspecialchars($skill['SkillValue']) ?></td>
        <td><?= htmlspecialchars($skill['EquipPartsName']) ?></td>
      </tr>
    <?php endforeach; ?>
  </table>
<?php else: ?>
  <p>スキル情報が見つかりませんでした。</p>
<?php endif; ?>


