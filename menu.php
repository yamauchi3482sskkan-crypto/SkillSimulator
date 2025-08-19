<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>スキルサーチツール</title>
 	<link rel="stylesheet" href="css/equipset_search.css">

</head>
<body>
    <div class="button-container">
	    <h1>スキルサーチツール</h1>

        <div class="button-group">
	        <!-- 新規登録ボタン -->
	        <form action="register.php" method="get" style="display:inline;">
	            <button type="submit">新規登録</button>
	        </form>

	        <!-- 検索条件ボタン -->
	        <form action="equipset_search.php" method="get" style="display:inline;">
	            <button type="submit">検索条件</button>
	        </form>
	        
	         <!-- マスタメンテボタン -->
	        <form action="mastermenue.php" method="get" style="display:inline;">
	            <button type="submit">マスタメンテ</button>
	        </form>
		<div>
    </div>

</body>
</html>