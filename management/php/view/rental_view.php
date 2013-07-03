<?php

require_once(getcwd(). '/../config/common_function.php');
require_once(getcwd(). '/../config/constant.php');

class rentalView {
	
	var $function;
	
	function display($errorArray) {
		
		$this->function = new commonFunction();
		
		print "<h1>蔵書貸出</h1>\n";
		print "<p>";
		print "<form action=\"?status=". FIRST_STAGE. "\" method=\"POST\" onSubmit=\"return check();\">\n";
		
		// 学籍番号 studentId
		print "<table id=\"input\"><tr><th>学籍番号</th><td id=\"data\"><input type=\"text\" name=\"studentId\"";
		// 学籍番号が入力させているか確認
		if (!empty($_POST['studentId'])) {
			// すでに蔵書番号を入力してる場合
			print " value=\"". $this->function->h($_POST['studentId']). "\"";
		}
		print "></td>\n";
		print "<td id=\"indispensable\"><b>[必須]</b></td><td>\n";
		// エラーメッセージがあるか確認
		if (!empty($errorArray['studentId']['message'])) {
			// エラーメッセージがある場合
			print "<font class=\"red\">";
			print $errorArray['studentId']['message'];
			print "</font>";
		} else {
			print "&nbsp;";
		}
		
		print "</td></tr>";
		// 蔵書番号 bookId
		print "<tr><th>蔵書番号</th><td><input type=\"text\" name=\"bookId\"";
		// 学籍番号が入力させているか確認
		if (!empty($_POST['bookId'])) {
			// すでに蔵書番号を入力してる場合
			print " value=\"". $this->function->h($_POST['bookId']). "\"";
		}
		print "></td>\n";
		print "<td><b>[必須]</b></td><td>\n";
		// エラーメッセージがあるか確認
		if (!empty($errorArray['bookId']['message'])) {
			// エラーメッセージがある場合
			print "<font class=\"red\">";
			print $errorArray['bookId']['message'];
			print "</font>";
		}
		
		print "</td></tr></table><br />";
		print "<input type=\"submit\" id=\"button\" value=\"貸出\">\n";
		print "</form>\n";
		print "</p>";
	}	
}
