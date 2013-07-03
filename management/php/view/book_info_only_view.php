<?php

require_once(getcwd(). '/../config/common_function.php');
require_once(getcwd(). '/../config/constant.php');

class bookInfoOnlyView {
	
	var $function;
	
	function display() {
		
		$this->function = new commonFunction();
		
		print "<h1>蔵書破棄</h1>\n";
		print "<p>";
		print "<table id=\"input\"><tr><th>蔵書番号</th><td>";
		print $_SESSION['bookInfo']['id'];
		print "番</td></tr>";
		
		// 蔵書名
		print "<tr><th>蔵書名</th><td>";
		print $this->function->h($_SESSION['bookInfo']['bookName']);
		print "</td></tr>\n";
		
		// 著者名
		print "<tr><th>著者名</th><td>";
		print $this->function->h($_SESSION['bookInfo']['acthorName']);
		print "</td></tr>\n";
		
		// 出版社
		print "<tr><th>出版社</th><td>";
		print $this->function->h($_SESSION['bookInfo']['pubisher']);
		print "</td></tr>\n";
		
		// 出版年
		print "<tr><th>出版年</th><td>";
		print $this->function->h($_SESSION['bookInfo']['publicationYear']);
		print "年</td></tr>\n";
		
		// 分類
		print "<tr><th>分類</th><td>";
		print $this->function->h($_SESSION['bookInfo']['category']);
		print "</td></tr>\n";
		
		// 現在の状態
        print "<tr><th>本の状態</th><td>";
        print $this->function->h($_SESSION['bookInfo']['bookStatus']);
        print "</td></tr>\n";
		// コメント
		print "<tr><th>コメント</th><td></td></tr></table>\n";
		print nl2br($this->function->h($_SESSION['bookInfo']['comment']));
		print "<br>\n";
		
		print "<form action=\"?status=". SECOND_STAGE."\" method=\"POST\">\n";
        
		print "<input type=\"submit\" id=\"button\" value=\"破棄\">\n";
		print "</form>\n";
		print "</p>";
	}
}

