<?php

require_once(getcwd(). '/../config/common_function.php');

class requestIsbnView {
	
	var $function;
	
	function display($errorArray) {
		
		$this->function = new commonFunction();
		
		print "<h1>購入依頼</h1>\n";
		print "<p>";
		print "購入してほしい蔵書のISBNコードを入力してください<br />\n";
		print "<form action=\"\" method=\"POST\">\n";
		
		// ISBN isbn
		print "<table id=\"input\"><tr><th>ISBN</th><td id=\"data\"><input type=\"text\" name=\"isbn\"";
		// ISBNが入力させているか確認
		if (!empty($_POST['isbn'])) {
			// すでにISBNを入力してる場合
			print " value=\"". $this->function->h($_POST['isbn']). "\"";
		}
		print "></td>\n";
		print "<td id=\"indispensable\">13桁</td><td>\n";
		// エラーメッセージがあるか確認
		if (!empty($errorArray['isbn']['message'])) {
			// エラーメッセージがある場合
			print "<font class=\"red\">";
			print $errorArray['isbn']['message'];
			print "</font>";
		}
		
		print "</td></tr></table>\n";
		print "<input type=\"submit\" value=\"確認\">\n";
		print "</form>\n";
		print "</p>";
	}
}
