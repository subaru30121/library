<?php

class headerView {
	
	function display($title, $flg) {
		
		// ヘッダー出力
		print "<html>\n";
		print "<head>\n";
		print "<!-- 全ページに記述 -->\n";
		print "<meta charset=\"utf8\">\n";
		print "<link rel=\"stylesheet\" href=\"../../css/library.css\" type=\"text/css\">\n";
		print "<!-- 個別 -->\n";
		// タイトル
		print "<title>". $title."</title>\n";
		print "</head>\n";
		print "<body>\n";
		print "<!-- URLに注目してね!! -->\n";
		print "<div id=\"main\">\n";
		print "<div id=\"nav\">\n";
		print "<a href=\"../../html/html/student.php\"><img src=\"../../img/logo.png\" alt=\"情報科学専門学校図書室管理サイト\" width=\"225\" height=\"120\"/></a>\n";
		print "<ul>\n";
		print "<li><a href=\"./../controller/book_search.php\">蔵書検索</a></li>";
		print "<li><a href=\"../../html/html/without.html\">卒論検索</a></li>";
		print "<li><a href=\"./../controller/book_ranking.php\">蔵書ランキング</a></li>";
		print "<li><a href=\"./../controller/request_student.php\">書籍購入依頼</a></li>";
		print "<li><a href=\"../../html/html/donation.html\">蔵書寄贈のお願い</a></li>";
		print "<li><a href=\"../../html/html/introduction.html\">図書室紹介</a></li>";
		print "</ul>\n";
		if ($flg) {
			// 1/20で出現
			print "<img src=\"../../img/usagi-illsut-f04.gif\" width=\"90\" height=\"90\" id=\"usagi\" />";
		}
		print "</div>\n";
		print "<div id=\"article\">\n";
		print "<div class=\"box\">\n";
	}
}
