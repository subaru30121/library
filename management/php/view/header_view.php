<?php

class headerView {
	
	function display($title, $class) {
		
		// ヘッダー出力
		print "<html>\n";
		print "<head>\n";
		print "<!-- 全ページに記述 -->\n";
		print "<meta charset=\"utf8\">\n";
		print "<link rel=\"stylesheet\" href=\"../../css/library.css\" type=\"text/css\">\n";
		print "<script type=\"text/javascript\" src=\"../../js/enter.js\"></script>\n";
		print "<title>". $title."</title>\n";
		print "</head>\n";
		print "<body class=\"". $class. "\" onKeyDown=\"return changeKeyCode();\" onload=\"document.forms[0].elements[0].focus();\">\n";
		print "<div id=\"main\">\n";
		print "<div id=\"nav\">\n";
		print "<a href=\"../../html/management.php\"><img src=\"../../img/logo.png\" alt=\"情報科学専門学校図書室管理サイト\" width=\"225\" height=\"120\"/></a>\n";
		print "<ul>\n";
		print "<li id=\"rental\"><a href=\"../controller/rental.php\">貸出</a></li>\n";
		print "<li id=\"return\"><a href=\"../controller/return.php\">返却</a></li>\n";
		print "<li id=\"renting\"><a href=\"../controller/renting_status.php\">貸出状況</a></li>\n";
		print "<li><a href=\"../../html/book_menu.html\" id=\"book\">蔵書管理</a>\n";
		print "<ul>\n";
		print "<li id=\"bookInput\"><a href=\"../controller/management_input.php\">蔵書追加</a></li>\n";
		print "<li id=\"bookChange\"><a href=\"../controller/management_change.php\">蔵書変更・削除</a></li>\n";
		print "<li id=\"bookDelete\"><a href=\"../controller/book_delete.php\">蔵書破棄</a></li>\n";
		print "</ul></li>\n";
		print "<li><a href=\"../../html/without.html\">卒論管理</a>";
		print "<ul>";
		print "<li><a href=\"../../html/without.html\">卒論追加</a></li>";
		print "<li><a href=\"../../html/without.html\">卒論変更・削除</a></li>";
		print "</ul></li>\n";
		print "<li><a href=\"../../html/category_menu.html\" id=\"category\">分類管理</a>\n";
		print "<ul>\n";
		print "<li id=\"categoryInput\"><a href=\"../controller/category_input.php\">分類追加</a></li>\n";
		print "<li id=\"categoryChange\"><a href=\"../controller/category_change.php\">分類変更・削除</a></li>\n";
		print "<li id=\"categoryList\"><a href=\"../controller/category_list.php\">分類一覧</a></li>\n";
		print "</ul></li>\n";
		print "<li id=\"textUpdate\"><a href=\"../controller/text_update.php\">トップページ変更</a></li>\n";
		print "<li id=\"requestList\"><a href=\"../controller/request_list.php\">購入依頼一覧</a></li>\n";
		print "<li><a href=\"../../../student/html/html/student.php\">学生用サイト</a></li>\n";
		print "</ul>\n";
		print "</div>\n";
		print "<div id=\"article\">\n";
		print "<div class=\"box\">\n";
	}
}
