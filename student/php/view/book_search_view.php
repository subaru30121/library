<?php

require_once(getcwd(). '/../config/common_function.php');
require_once(getcwd(). '/../config/constant.php');

class bookSearchView {
	
	var $function;
	
	function display($errorArray, $category) {
		
		$this->function = new commonFunction();
		
		print "<h1>検索項目</h1>\n";
		print "\n";
		
		print "<form action=\"\" method=\"POST\">\n";
		print "<table>\n";
		
		// 蔵書名 bookName
		print "<tr>";
		print "<th>蔵書名</th>";
		print "<td><input type=\"text\" name=\"bookName\"";
		// 蔵書名が入力させているか確認
		if (!empty($_POST['bookName'])) {
			// すでに蔵書名を入力してる場合
			print " value=\"". $this->function->h($_POST['bookName']). "\"";
		}
		print "></td></tr>\n";
		// エラーメッセージがあるか確認
		if (!empty($errorArray['bookName']['message'])) {
			// エラーメッセージがある場合
			print "<th><td><font color=\"red\">";
			print $errorArray['bookName']['message'];
			print "</font></td></th>";
		}
		
		// 著者名 acthorName
		print "<tr>";
		print "<th>著者名</th>";
		print "<td><input type=\"text\" name=\"acthorName\"";
		// 著者名が入力させているか確認
		if (!empty($_POST['acthorName'])) {
			// すでに著者名を入力してる場合
			print " value=\"". $this->function->h($_POST['acthorName']). "\"";
		}
		print "></td></tr>\n";
		// print "<br>\n";
		// エラーメッセージがあるか確認
		if (!empty($errorArray['acthorName']['message'])) {
			// エラーメッセージがある場合
			print "<tr><td><font color=\"red\">";
			print $errorArray['acthorName']['message'];
			print "</font></td></tr>>";
		}
		
		// 出版年 publicationYear
		print "<tr><th>出版年</th><td><select name=\"publicationYear\">";
		print "<option value=\"\">検索しない</option>";
        for ($i = date('Y'); $i >= START_YEAR; $i--) {
            print "<option value=\"". $i. "\"";
            // 出版年が入力させているか確認
            if (!empty($_POST['publicationYear'])) {
                // 選択されている場合
                if ($_POST['publicationYear'] == $i) {
                    // 同じ年が出力されるとき
                    print " selected";
                }
            }
            print ">". $i. "</option>";
        }
        print "</select>";
        print "年</td></tr>\n";
		// エラーメッセージがあるか確認
		if (!empty($errorArray['publicationYear']['message'])) {
			// エラーメッセージがある場合
			print "<tr><td><font color=\"red\">";
			print $errorArray['publicationYear']['message'];
			print "</font></td></tr>";
		}
		print "<br>\n";
		
		// 分類 category
		print "<tr><th>分類</th><td><select name=\"category\">";
		print "<option value=\"\">検索しない</option>\n";
		foreach ($category as $content) {
			print "<option value=\"";
			print $content['categoryId'];
			print "\"";
			if (!empty($_POST['category'])) {
				// 入力されている場合
				if ($_POST['category'] == $content['categoryId']) {
					print " selected";
				}
			}
			print ">";
			print $content['categoryName'];
			print "</option>\n";
		}
		print "</select></td></tr>";
		// エラーメッセージがあるか確認
	if (!empty($errorArray['category']['message'])) {
			// エラーメッセージがある場合
			print "<tr><td><font color=\"red\">";
			print $errorArray['category']['message'];
			print "</font></td></tr>";
		}
		print "</table>";
		print "<br>\n";
		print "<input type=\"submit\" value=\"検索\">\n";
		print "</form>\n";
	}
}
