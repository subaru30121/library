
<?php

require_once(getcwd(). '/../config/common_function.php');

class bookSearchResultView {
	
	var $function;
	
	function display($data, $content) {
		
		$this->function = new commonFunction();
		
		print "<h1>検索結果</h1>\n";
		
		print "全". $data['total']. "件中、". $data['from']. "件～". $data['to']. "件表示<br>\n";
		
		// テーブル生成
		print "<table id=\"search\">\n";
		print "<tr>\n";
		print "<th id=\"no\">No.</th>";
		print "<th id=\"title\">蔵書名</th>\n";
		print "<th>出版年</th>\n";
		print "</tr>\n";
		foreach($content as $record) {
			print "<tr align=center>\n";
			print "<td>". $this->function->h($record['id']). "</td>";
			print "<td>". "<a href=\"./book_detail.php?id=". $record['id']. "\">". $this->function->strLength($this->function->h($record['bookName'])). "</a></td>\n";
			print "<td>". $this->function->h($record['publicationYear']). "年</td>\n";
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
		for ($i = $data['firstPage']; $i <= $data['totalPage']; $i++) {
			if ($data['page'] == $i) {
				// 現在表示されているページだった場合
				print "<font size=\"5\"><a href=\"?page=". $i. "\">". $i. "</a></font>\n";
			} else {
				// 現在表示されていないページだった場合
				print "<a href=\"?page=". $i. "\">". $i. "</a>\n";
			}
			if ($data['firstPage'] + 10 < $i) {
				break;
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
