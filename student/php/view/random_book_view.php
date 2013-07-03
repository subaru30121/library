<?php

class randomBookView {
	
	function display($data) {
		
		print "<table id=\"input\"><tr><th>蔵書番号</th><td>";
		print htmlspecialchars($data['id'], ENT_QUOTES, "UTF-8");
		print "番</td></tr>";
		// 蔵書名
		print "<tr><th>蔵書名</th><td>";
		print "<a href = \"../../php/controller/book_detail.php?id=". $data['id']. "\">";
		print htmlspecialchars($data['bookName'], ENT_QUOTES, "UTF-8");
		print "</a></td></tr>\n";
		
		// 分類
		print "<tr><th>分類</th><td>";
		print htmlspecialchars($data['category'], ENT_QUOTES, "UTF-8");
		print "</td></tr>\n";
		
		print "</table>\n";
		
	}
}

