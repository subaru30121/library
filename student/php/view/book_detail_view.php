<?php

require_once(getcwd(). '/../config/common_function.php');

class bookDetailView {
	
	var $function;
	
	function display($data) {
		
		$this->function = new commonFunction();
		
		print "<h1>蔵書情報</h1>\n";
		print "<p>";
		print "<table id=\"input\"><tr><th>蔵書番号</th><td>";
		print $this->function->h($data['id']);
		print "番</td></tr>";
		// 蔵書名
		print "<tr><th>蔵書名</th><td>";
		print $this->function->h($data['bookName']);
		print "</td></tr>\n";
		
		// 著者名
		print "<tr><th>著者名</th><td>";
		print $this->function->h($data['acthorName']);
		print "</td></tr>\n";
		
		// 出版社
		print "<tr><th>出版社</th><td>";
		print $this->function->h($data['pubisher']);
		print "</td></tr>\n";
		
		// 出版年
		print "<tr><th>出版年</th><td>";
		print $this->function->h($data['publicationYear']);
		print "年</td></tr>\n";
		
		/*
		// ISBN
		print "<tr><th>ISBN</th><td>";
		print $this->function->h($data['isbn']);
		print "</td></tr>\n";
		*/		

		// 分類
		print "<tr><th>分類</th><td>";
		print $this->function->h($data['category']);
		print "</td></tr>\n";
		
		// 現在の状態
        print "<tr><th>状態</th><td>";
        print $this->function->h($data['status']);
        print "</td></tr>\n";
        
		// コメント
		print "<tr><th>コメント</th><td>\n";
		print nl2br($this->function->h($data['comment']));
		print "</td></tr></table>\n";
		
		
		print "</p>";
	}
}

