<?php
	session_start();
	
	if (empty($_SESSION['hide'])) {
		header("LOCATION:student.php" );
	}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<!-- 全ページに記述 -->
		<meta charset="utf8">
		<link rel="stylesheet" href="../css/library.css" type="text/css">
		<!-- 個別 -->
		<title>シークレット - 情報科学専門学校図書室管理サイト</title>
	</head>
	
	<body>
	<div id="usagi_san">
	<center>
	<img src="../img/usagi-illsut-f04.gif" width="300" heigft="300">
	<div>おめでとうございます！<br />
	隠しページへようこそ<br />
	できればアンケートで発見したことを自慢してほしいです<br />
	その際、証拠として「library24人目」とその他の欄にご記入ください</div>
	</center>
	</div>
	</body>
</html>
