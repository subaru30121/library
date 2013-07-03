<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<!-- 全ページに記述 -->
		<meta charset="utf8">
		<link rel="stylesheet" href="../../css/library.css" type="text/css">
		<!-- 個別 -->
		<title>情報科学専門学校図書室管理サイト</title>
	</head>

	<body>
		<div id="main"><!--メインコンテナ-->
			<!--サイドバーコンテナ-->
			<div id="nav">
				<img src="../../img/logo.png" alt="情報科学専門学校図書室管理サイト" width="225" height="120"/>
				<ul>
				<li><a href="./../../php/controller/book_search.php">蔵書検索</a></li>
				<li><a href="./without.html">卒論検索</a></li>
				<li><a href="../../php/controller/book_ranking.php">蔵書ランキング</a></li>
				<li><a href="./../../php/controller/request_student.php">書籍購入依頼</a></li>
				<li><a href="./donation.html">蔵書寄贈のお願い</a></li>
				<li><a href="./introduction.html">図書室紹介</a></li>
				</ul>
			</div>
			<!--メインコンテンツコンテナ-->
			<!-- 隠しページはちゃんとあるからね!! -->
			<div id="article">
				<img src="../../img/top_s.png" alt="トップ画像" width="575" height="200"/>
				<br />
				<!--共通項目（box）は必ずPHPで読む。-->
				<div class="box">
					<h1>最新情報</h1>
					<p>
					<?php
					//モード[r]の読み込み専用
					if (!($fp = fopen("../../text/new.txt", "r" ))) {
						print "ファイルが開けません。";
					}
					//ファイルの読み込みと表示
					//１行ずつファイルを読み込んで、表示する。
					while (!feof($fp)) {
						$load = fgets($fp, 4096);
						print nl2br(htmlspecialchars($load));
					}
					//ファイルを閉じる
					fclose ($fp);
					?>
					</p>
				</div>
				<div class="box">
					<h1>蔵書紹介</h1>
					<p>
					<?php
					include('../../php/controller/random_book.php');
					/*
					//モード[r]の読み込み専用
					if (!($fp = fopen("../text/suggest.txt", "r" ))) {
						print "ファイルが開けません。";
					}
					//ファイルの読み込みと表示
					//１行ずつファイルを読み込んで、表示する。
					while (!feof($fp)) {
						$load = fgets($fp, 4096);
						print nl2br(htmlspecialchars($load));
					}
					//ファイルを閉じる
					fclose ($fp);
					*/
					?>
					</p>
				</div>
			</div>
			<!--フッター-->
			<div id="footer">
				Copyright (c) Iwasaki Gakuen All rights reserved. 
			</div>
		</div>
	</body>
</html>
