<?php

require_once(getcwd(). '/../config/common_function.php');

class requestStudentView {
	
	var $function;
	
	function display($errorArray, $loginData) {
		
		$this->function = new commonFunction();
		
		print "<h1>購入依頼</h1>\n";
		print "<p>";
		print "アイナビで使用しているユーザ名とパスワードを入力してください<br />\n";
		if (!empty($loginData['errorMessage'])) {
			// ログインエラーの場合メッセージ出力
			print "<font class=\"red\">";
			print $loginData['errorMessage']. "<br />\n";
			print "</font>";
		}
		print "<form action=\"\" method=\"POST\">\n";
		
		// ユーザ名 userName
		print "<table id=\"input\"><tr><th>ユーザ名</th><td id=\"data\"><input type=\"text\" name=\"userName\"";
		// ユーザ名が入力させているか確認
		if (!empty($_POST['userName'])) {
			// すでにユーザ名を入力してる場合
			print " value=\"". $this->function->h($_POST['userName']). "\"";
		}
		print "></td>\n";
		print "<td id=\"indispensable\"><b>[必須]</b></td><td>\n";
		// エラーメッセージがあるか確認
		if (!empty($errorArray['userName']['message'])) {
			// エラーメッセージがある場合
			print "<font class=\"red\">";
			print $errorArray['userName']['message'];
			print "</font>";
		}
		
		// パスワード password
		print "</td></tr><tr><th>パスワード</th><td><input type=\"password\" name=\"password\"";
		// パスワードが入力させているか確認
		if (!empty($_POST['password'])) {
			// すでにパスワードを入力してる場合
			print " value=\"". $this->function->h($_POST['password']). "\"";
		}
		print "></td>\n";
		print "<td><b>[必須]</b></td><td>\n";
		// エラーメッセージがあるか確認
		if (!empty($errorArray['password']['message'])) {
			// エラーメッセージがある場合
			print "<font class=\"red\">";
			print $errorArray['password']['message'];
			print "</font>";
		}
		
		print "</td></tr></table><input id=\"button\" type=\"submit\" value=\"確認\">\n";
		print "</form>\n";
		print "</p>";
	}
}
