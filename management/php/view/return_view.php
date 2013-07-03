<?php

require_once(getcwd(). '/../config/common_function.php');
require_once(getcwd(). '/../config/constant.php');

class returnView {
	
	var $function;
	
	function display($errorArray) {
		
		$this->function = new commonFunction();
		
		print "<h1>蔵書返却</h1>\n";
		print "<p>";
		print "<form action=\"?status=". FIRST_STAGE. "\" method=\"POST\" onSubmit=\"return check();\">\n";
		
		// 蔵書番号 bookId
		print "<table id=\"input\"><tr><th>蔵書番号</th><td id=\"data\"><input type=\"text\" name=\"bookId\"";
		// 学籍番号が入力させているか確認
		if (!empty($_POST['bookId'])) {
			// すでに蔵書番号を入力してる場合
			print " value=\"". $this->function->h($_POST['bookId']). "\"";
		}
		print "></td>\n";
		print "<td id=\"indispensable\"><b>[必須]</b></td>\n";
		print "<td>";
		// エラーメッセージがあるか確認
		if (!empty($errorArray['bookId']['message'])) {
			// エラーメッセージがある場合
			print "<font id=\"red\">";
			print $errorArray['bookId']['message'];
			print "</font>";
		} else {
			print "&nbsp";
		}
		
		print "</td></tr></table><br />";
		print "<input id=\"button\" type=\"submit\" value=\"返却\">\n";
		print "</form>\n";
		print "</p>";
	}
}
