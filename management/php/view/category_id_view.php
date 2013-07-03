<?php

require_once(getcwd(). '/../config/common_function.php');
require_once(getcwd(). '/../config/constant.php');

class categoryIdView {
	
	var $function;
	
	function display($errorArray) {
		
		$this->function = new commonFunction();
		
		print "<h1>分類変更・削除</h1>\n";
		print "<p>";
		print "\n";
		
		print "<form action=\"?status=". FIRST_STAGE."\" method=\"POST\" onSubmit=\"return check();\">\n";
		
		// 分類番号 categoryId
		print "<table id=\"input\"><tr><th>分類番号</th><td id=\"data\"><input type=\"text\" name=\"categoryId\"";
		// 蔵書番号が入力させているか確認
		if (!empty($_POST['categoryId'])) {
			// すでに蔵書番号を入力してる場合
			print " value=\"". $this->function->h($_POST['categoryId']). "\"";
		}
		print "></td>\n";
		print "<td id=\"indispensable\"><b>[必須]</b></td><td>\n";
		// エラーメッセージがあるか確認
		if (!empty($errorArray['categoryId']['message'])) {
			// エラーメッセージがある場合
			print "<font class=\"red\">";
			print $errorArray['categoryId']['message'];
			print "</font>";
		} else {
			print "&nbsp;";
		}
		print "</td></tr></table><br />";
		
		print "<input type=\"submit\" value=\"次へ\">\n";
		print "</form>\n";
		print "</p>";
	}
}
