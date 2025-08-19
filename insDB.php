<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>ToDoリスト 入力ページ</title>
<link rel="stylesheet" href ="style.css">
</head>
<body>
	<?php
		try {
		  //DB名、ユーザー名、パスワードを変数に格納
		  $dsn = 'mysql:dbname=test;host=localhost;charset=utf8';
		  $user = 'root';
		  $password = '';
		 
		  $PDO = new PDO($dsn, $user, $password); //PDOでMySQLのデータベースに接続
		  $PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //PDOのエラーレポートを表示
		 
		  //input.phpの値を取得
		  $word = $_POST['word'];
		 
		  $sql = "INSERT INTO todolist (word) VALUES (:word)"; // テーブルに登録するINSERT INTO文を変数に格納　VALUESはプレースフォルダーで空の値を入れとく
		  $stmt = $PDO->prepare($sql); //値が空のままSQL文をセット
		  $params = array(':word' => $word );// 挿入する値を配列に格納
		  $stmt->execute($params); //挿入する値が入った変数をexecuteにセットしてSQLを実行
		 
		  // 登録内容確認・メッセージ

		  $message1= "<p>入力値: " . $word . "</p>";
		  $message2= '<p>上記の値をDBに登録しました</p>';
		} catch (PDOException $e) {
		  exit('データベースに接続できませんでした' . $e->getMessage());
		}
	?>
	<label><?php echo $message1; ?></label>
	<label><?php echo $message2; ?></label>
	<button onclick="history.back()">前のページに戻る</button>

</body>
