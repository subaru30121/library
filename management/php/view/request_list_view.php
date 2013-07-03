<?php

require_once(getcwd(). '/../config/common_function.php');

class requestListView {
	
	var $function;
	
	function display($data, $content) {
		
		$this->function = new commonFunction();
		
		print "<h1>購入依頼一覧</h1>\n";
		
		print "全". $data['total']. "件中、". $data['from']. "件～". $data['to']. "件表示<br>\n";
		
		// テーブル生成
		print "<table id=\"search\">\n";
		print "<tr>\n";
		print "<th id=\"title\">蔵書名</th>\n";
		print "<th>学生名</th>\n";
		print "<th>登録日</th>\n";
		print "</tr>\n";
		foreach($content as $record) {
			print "<tr align=center>\n";
			print "<td><a href=\"./request_detail.php?id=". $record['requestId']. "\">". $this->function->h($record['bookName']). "</a></td>\n";
			print "<td>". $this->function->h($record['studentName']). "</td>\n";
			print "<td>". date('n月d日', strtotime($record['requestDay'])). "</td>\n";
			print "</tr>\n";
		}
		print "</table>\n";
		print "<br>\n";
		// リンク生成
		if ($data['page'] > 1) {
			// 1ページ以降は表示
			print "<a href=\"?page=";
			print $data['page'] - 1;
			print "\">前</a>\n";
		}
		for ($i = 1; $i <= $data['totalPage']; $i++) {
			if ($data['page'] == $i) {
				// 現在表示されているページだった場合
				print "<font size=\"5\"><a href=\"?page=". $i. "\">". $i. "</a></font>\n";
			} else {
				// 現在表示されていないページだった場合
				print "<a href=\"?page=". $i. "\">". $i. "</a>\n";
			}
		}
		if ($data['page'] < $data['totalPage']) {
			// 最終ページ以外は表示
			print "<a href=\"?page=";
			print $data['page'] + 1;
			print "\">次</a>";
		}
	}
}
