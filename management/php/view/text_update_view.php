<?php

require_once(getcwd(). '/../config/common_function.php');

class textUpdateView {
	
	var $function;
	
	function display($errorArray, $new, $suggest) {
		
		$this->function = new commonFunction;
		
		print	"<h1>トップページ変更</h1>\n";
		print	"<p>";
		print	"<form action=\"\" method=\"POST\" onSubmit=\"return check();\">\n";
		
		// お知らせ new
		print "お知らせ<br />\n";
		print "<textarea name=\"new\" rows=\"6\" cols=\"50\">";
		// お知らせが入力されているか確認
		if (!empty($_POST['new'])) {
			//	入力されている場合
			print $this->function->h($_POST['new']);
		} else {
			// 入力されていない場合
			print $this->function->h($new);
		}
		print "</textarea>\n";
		// エラーメッセージがあるか確認
		if (!empty($errorArray['new']['message'])) {
			// エラーメッセージがある場合
			print "<br />";
			print "<font class=\"red\">";
			print $errorArray['new']['message'];
			print "</font>";
		}
		print "<br />500文字以内でお願いします<br>\n";
		print "<br>\n";
		/*
		// お勧め suggest
		print "お勧めの本<br />\n";
		print "<textarea name=\"suggest\" rows=\"6\" cols=\"50\">";
		// お勧めが入力されているか確認
		if (!empty($_POST['suggest'])) {
			//	入力されている場合
			print $this->function->h($_POST['suggest']);
		} else {
			// 入力されていない場合
			print $this->function->h($suggest);
		}
		print "</textarea>\n";
		// エラーメッセージがあるか確認
		if (!empty($errorArray['suggest']['message'])) {
			// エラーメッセージがある場合
			print "<br />";
			print "<font class=\"red\">";
			print $errorArray['suggest']['message'];
			print "</font>";
		}
		print "<br />500文字以内でお願いします<br>\n";
		print "<br>\n";
		*/
		print	"※確認画面はないので、内容に間違いがないよう注意してください<br>\n";
		print	"<input	type=\"submit\"	id=\"button\" value=\"登録\">\n";
		print	"</form>\n";
		print	"</p>";
	}
}
