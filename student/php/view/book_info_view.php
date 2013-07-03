<?php

require_once(getcwd(). '/../config/common_function.php');

class bookInfoView {
	
	var $function;
	
	function display() {
		
		$this->function = new commonFunction();
		
		print "<h1>蔵書購入依頼</h1>\n";
		print "<p>";
		print "<table id=\"input\">";
		
		// 蔵書名
		print "<tr><th>蔵書名</th><td>";
		print $this->function->h($_SESSION['bookData']['bookName']);
		print "</td></tr>\n";
		
		// 著者名
		print "<tr><th>著者名</th><td>";
		print $this->function->h($_SESSION['bookData']['acthorName']);
		print "</td></tr>\n";
		
		// 出版社
		print "<tr><th>出版社</th><td>";
		print $this->function->h($_SESSION['bookData']['publisher']);
		print "</td></tr>\n";
		
		// 出版年
		print "<tr><th>出版年</th><td>";
		print $this->function->h($_SESSION['bookData']['publicationYear']);
		print "年</td></tr>\n";
		
		// ISBN
		print "<tr><th>ISBN</th><td>";
		print $this->function->h($_SESSION['bookData']['isbn']);
		print "</td></tr></table>\n";
		
		print "<form action=\"\" method=\"POST\">\n";
		
		print "<input type=\"button\" value=\"戻る\" onClick=\"location.href='request_isbn.php'\">\n";
		print "<input type=\"submit\" name=\"request\" id=\"button\" value=\"送信\">\n";
		print "</form>\n";
		print "</p>";
	}
}

