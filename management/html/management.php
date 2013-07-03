<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<!-- 全ページに記述 -->
		<meta charset="utf8">
		<link rel="stylesheet" href="../css/library.css" type="text/css">
		<!-- 個別 -->
		<title>情報科学専門学校図書室管理サイト</title>
	</head>
	
	<body>
		<div id="main"><!--メインコンテナ-->
			<!--サイドバーコンテナ-->
			<div id="nav">
				<img src="../img/logo.png" alt="情報科学専門学校図書室管理サイト" width="225" height="120"/>
				<ul>
		<li id="rental"><a href="../php/controller/rental.php">貸出</a></li>
		<li id="return"><a href="../php/controller/return.php">返却</a></li>
		<li id="renting"><a href="../php/controller/renting_status.php">貸出状況</a></li>
		<li><a href="./book_menu.html" id="book">蔵書管理</a>
		<ul>
		<li id="bookInput"><a href="../php/controller/management_input.php">蔵書追加</a></li>
		<li id="bookChange"><a href="../php/controller/management_change.php">蔵書変更・削除</a></li>
		<li id="bockDelete"><a href="../php/controller/book_delete.php">蔵書破棄</a></li>
		</ul></li>
		<li><a href="./without.html">卒論管理</a>
		<ul>
		<li><a href="./without.html">卒論追加</a></li>
		<li><a href="./without.html">卒論変更・削除</a></li>
		</ul></li>
		<li><a href="./category_menu.html" id="category">分類管理</a>
		<ul>
		<li id="categoryInput"><a href="../php/controller/category_input.php">分類追加</a></li>
		<li id="categoryChange"><a href="../php/controller/category_change.php">分類変更・削除</a></li>
		<li id="categoryList"><a href="../php/controller/category_list.php">分類一覧</a></li>
		</ul></li>
		<li id="textUpdate"><a href="../php/controller/text_update.php">トップページ変更</a></li>
		<li id="requestList"><a href="../php/controller/request_list.php">購入依頼一覧</a></li>
					<li><a href="./../../student/html/html/student.php">学生用サイト</a></li>
				</ul>
			</div>
			<!--メインコンテンツコンテナ-->
			<div id="article">
				<img src="../img/top_m.png" alt="トップ画像" width="575" height="350"/>
				<br />
				<!--共通項目（box）は必ずPHPで読む。-->
			</div>
			<!--フッター-->
			<div id="footer">
				Copyright (c) Iwasaki Gakuen All rights reserved. 
			</div>
		</div>
	</body>
</html>

