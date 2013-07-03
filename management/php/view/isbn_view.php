<?php

require_once(getcwd(). '/../config/common_function.php');
require_once(getcwd(). '/../config/constant.php');

class isbnView {
	
	var $function;
	
	function display($errorArray) {
		
		$this->function = new commonFunction();
		
		print "<h1>蔵書追加</h1>\n";
		print "<p>";
		print "\n";
		
		print "<form action=\"?status=". FIRST_STAGE."\" method=\"POST\" onSubmit=\"return check();\">\n";
		
		// ISBN isbn
		print "<table id=\"input\"><tr><th>ISBN</th><td id=\"data\"><input type=\"text\" name=\"isbn\"";
		// ISBNが入力させているか確認
		if (!empty($_POST['isbn'])) {
			// すでにISBNを入力してる場合
			print " value=\"". $this->function->h($_POST['isbn']). "\"";
		}
		print "></td><td>\n";
		// エラーメッセージがあるか確認
		if (!empty($errorArray['isbn']['message'])) {
			// エラーメッセージがある場合
			print "<font class=\"red\">";
			print $errorArray['isbn']['message'];
			print "</font><br />";
		} else {
			print "&nbsp;";
		}
		print "</td></tr></table>";
		print "※<b>半角数字10桁または13桁です</b><br />ISBNコードがない場合、次のページで各項目を入力します<br /><br />\n";
		
		print "<input id=\"button\" type=\"submit\" value=\"次へ\">\n";
		print "</form>\n";
		print "</p>";
	}
}
