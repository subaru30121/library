<?php

require_once(getcwd(). '/../config/common_function.php');

class requestDetailView {
	
	var $function;
	
	function display($data) {
		
		$this->function = new commonFunction();
		
		print "<h1>購入依頼情報</h1>\n";
		print "<p>";
		// 蔵書名
		print "<table><tr><th>蔵書名</th><td>";
		print $this->function->h($data['bookName']);
		print "</td></tr>\n";
		
		// 著者名
		print "<tr><th>著者名</th><td>";
		print $this->function->h($data['acthorName']);
		print "</td></tr>\n";
		
		// 出版社
		print "<tr><th>出版社</th><td>";
		print $this->function->h($data['publisher']);
		print "</td></tr>\n";
		
		// 出版年
		print "<tr><th>出版年</th><td>";
		print $this->function->h($data['publicationYear']);
		print "年</td></tr>\n";
		
		// ISBN
		print "<tr><th>ISBN</th><td>";
		print $this->function->h($data['isbn']);
		print "</td></tr>\n";
		
		// 依頼日
		print "<tr><th>依頼日</th><td>";
		print $this->function->h(date('n月d日', strtotime($data['requestDay'])));
		print "</td></tr>\n";
		
		// 学籍番号
		print "<tr><th>学籍番号</th><td>";
		print $this->function->h($data['studentId']);
		print "</td></tr>\n";
		
		// クラス
		print "<tr><th>クラス</th><td>";
		print $this->function->h($data['class']);
		print "</td></tr>\n";
		
		// 学生名
		print "<tr><th>学生名</th><td>";
		print $this->function->h($data['studentName']);
		print "</td></tr>\n";
		
		// 同じ蔵書の依頼数
		print "<tr><th>依頼数</th><td>";
		print $this->function->h($data['equal']). "回";
		print "</td></tr>\n";
		
		// 外部サイト
		print "<tr><th>外部サイト</th><td>";
		print "<a href=\"". $data['url']. "\" target=\"_blank\">Amazon</a>";
		print "</td></tr></table>\n";
		
		print "<form action=\"\" method=\"POST\" onSubmit=\"return check();\">\n";
		print "<input type=\"submit\" id=\"button\" name=\"one\" value=\"一つ削除\">\n";
		print "<input type=\"submit\" id=\"button\" name=\"multiple\" value=\"まとめて削除\">\n";
		print "</form>\n";
		
		print "</p>";
	}
}

