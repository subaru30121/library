<?php

require_once(getcwd(). '/../config/common_function.php');

class categoryView {
	
	var $function;
	
	function display($errorArray) {
		
		$this->function = new commonFunction();
		
		print "<h1>分類追加</h1>\n";
		print "<p>";
		print "<form action=\"\" method=\"POST\" onSubmit=\"return check();\">\n";
		
		// 分類番号 categoryId
		print "<table id=\"input\"><tr><th>分類番号</th><td id=\"data\"><input type=\"text\" name=\"categoryId\"";
		// 分類番号が入力させているか確認
		if (!empty($_POST['categoryId'])) {
			// すでに分類番号を入力してる場合
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
		}
		else {
			print "半角2桁";
		}
		print "</td></tr>";
		
		// 分類名 categoryName
		print "<tr><th>分類名</th><td><input type=\"text\" name=\"categoryName\"";
		// 分類名が入力させているか確認
		if (!empty($_POST['categoryName'])) {
			// すでに分類名を入力してる場合
			print " value=\"". $this->function->h($_POST['categoryName']). "\"";
		}
		print "></td>\n";
		print "<td><b>[必須]</b></td><td>\n";
		// エラーメッセージがあるか確認
		if (!empty($errorArray['categoryName']['message'])) {
			// エラーメッセージがある場合
			print "<font class=\"red\">";
			print $errorArray['categoryName']['message'];
			print "</font>";
		}
		print "</td></tr></table><br />";
		
		print "<input type=\"submit\" id=\"button\" value=\"登録\">\n";
		print "</form>\n";
		print "</p>";
	}
}
