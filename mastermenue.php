<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>マスタメンテナンス</title>
 	<link rel="stylesheet" href="css/mastermenue.css">
</head>
<body>
    <div class="form-container">
        <!-- 装備マスタメンテナンス -->
        <div class="text-group">
            <span class="button-label">装備マスタメンテナンス</span>
            <div class="button-group">
                <form action="equipmasterINS.php" method="get" style="display:inline;">
                    <button type="submit">新規</button>
                </form>
                <form action="equipmasterUPD.php" method="get" style="display:inline;">
                    <button type="submit">修正</button>
                </form>
            </div>
        </div>
        
        <!-- スキルマスタメンテナンス -->
        <div class="text-group">
            <span class="button-label">スキルマスタメンテナンス</span>
            <div class="button-group">
                <form action="skillmasterINS.php" method="get" style="display:inline;">
                    <button type="submit">新規</button>
                </form>
                <form action="skillmasterUPD.php" method="get" style="display:inline;">
                    <button type="submit">修正</button>
                </form>
            </div>
        </div>
        
        <div class="return-button-group">
            <button type="button" onclick="location.href='menu.php'">メニューに戻る</button>
        </div>
    </div>
</body>
</html>
