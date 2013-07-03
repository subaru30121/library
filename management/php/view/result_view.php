<?php

require_once(getcwd(). '/../config/common_function.php');

class resultView {
	
	var $function;
	
	function display($message) {
		
		$this->function = new commonFunction();
		
		print "<h1>処理結果</h1>\n";
		print "<p>";
		// 処理結果出力
		if (!empty($message)) {
			// メッセージがある場合
			print nl2br($this->function->h($message));
		}
		print "</p>";
	}
}
