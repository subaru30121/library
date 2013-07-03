
<?php

require_once(getcwd(). '/../config/common_function.php');

class bookRankingView {
	
	var $function;
	
	function display($content) {
		
		$this->function = new commonFunction();
		
		print "<h1>蔵書ランキング</h1>\n";
		
		print "<p>\n";
		// テーブル生成
		print "<table id=\"search\">\n";
		print "<tr>\n";
		print "<th id=\"no\">順位</th>";
		print "<th id=\"no\">No.</th>\n";
		print "<th id=\"title\">蔵書名</th>\n";
		print "</tr>\n";
		$rank = 1;
		foreach($content as $record) {
			if (empty($record)) {
				break;
			}
			print "<tr align=center>\n";
			print "<td>". $rank. "位</td>";
			print "<td>". $this->function->h($record['id']). "</td>";
			print "<td>". "<a href=\"./book_detail.php?id=". $record['id']. "\">". $this->function->h($record['bookName']). "</a></td>\n";
			print "</tr>\n";
			$rank++;
		}
		print "</table>\n";
		print "※貸出状況を参考にしたランキングです<br />";
		print "</p>";
	}
}
