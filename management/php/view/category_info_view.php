<?php

require_once(getcwd(). '/../config/common_function.php');
require_once(getcwd(). '/../config/constant.php');

class categoryInfoView {
	
	var $function;
	
	function display($errorArray) {
		
		$this->function = new commonFunction();
		
		print "<h1>分類変更・削除</h1>\n";
		print "<p>";
		print "<table id=\"input\"><tr><th>分類番号</th><td id=\"data\">";
		print $this->function->h($_SESSION['categoryInfo']['categoryId']);
		print "番</td><td id=\"indispensable\"></td><td></td>";
		
		print "<form action=\"?status=". SECOND_STAGE."\" method=\"POST\">\n";
		
		// 分類名 categoryName
		print "<tr><th>分類名</th><td><input type=\"text\" name=\"categoryName\"";
		// 分類名が入力させているか確認
		if (!empty($_POST['categoryName'])) {
			// すでに分類名を入力してる場合
			print " value=\"". $this->function->h($_POST['categoryName']). "\"";
		} else {
			// まだ入力していない場合
			// DBの情報を表示する
			print " value=\"". $this->function->h($_SESSION['categoryInfo']['categoryName']). "\"";
		}
		print "></td>\n";
		print "<td><b>[必須]</b></td><td>\n";
		// エラーメッセージがあるか確認
		if (!empty($errorArray['categoryName']['message'])) {
			// エラーメッセージがある場合
			print "<font color=\"red\">";
			print $errorArray['categoryName']['message'];
			print "</font>";
		} else {
			print "&nbsp;";
		}
		print "</td></tr></table><br>";
		
		print "<input type=\"submit\" id=\"button\" name=\"update\" value=\"変更\">\n";
		print "<input type=\"submit\" id=\"button\" name=\"delete\" value=\"削除\">\n";
		print "</form>\n";
		print "</p>";
	}
}
