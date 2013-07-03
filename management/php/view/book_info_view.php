<?php

require_once(getcwd(). '/../config/common_function.php');
require_once(getcwd(). '/../config/constant.php');

class bookInfoView {
	
	var $function;
	
	function display($errorArray, $category) {
		
		$this->function = new commonFunction;
		
		print "<h1>蔵書変更・削除</h1>\n";
		print "<p>";
		print "<table id=\"input\"><tr><th>蔵書番号</th><td id=\"data\">";
		print $this->function->h($_SESSION['bookInfo']['id']);
		print "番</td><td id=\"indispensable\"></td><td></td></tr>";
		
		print "<form action=\"?status=". SECOND_STAGE."\" method=\"POST\">\n";
		
		// 蔵書名 bookName
		print "<tr><th>蔵書名</th><td><input type=\"text\" name=\"bookName\"";
		// 蔵書名が入力させているか確認
		if (!empty($_POST['bookName'])) {
			// すでに蔵書名を入力してる場合
			print " value=\"". $this->function->h($_POST['bookName']). "\"";
		} else {
			// まだ入力していない場合
			// DBの情報を表示する
			print " value=\"". $this->function->h($_SESSION['bookInfo']['bookName']). "\"";
		}
		print "></td>\n";
		print "<td><b>[必須]</b></td>\n";
		print "<td>";
		// エラーメッセージがあるか確認
		if (!empty($errorArray['bookName']['message'])) {
			// エラーメッセージがある場合
			print "<font class=\"red\">";
			print $errorArray['bookName']['message'];
			print "</font>";
		} else {
			print "&nbsp;";
		}
		print "</td></tr>\n";
		
		// 著者名 acthorName
		print "<tr><th>著者名</th><td><input type=\"text\" name=\"acthorName\"";
		// 著者名が入力させているか確認
		if (!empty($_POST['acthorName'])) {
			// すでに著者名を入力してる場合
			print " value=\"". $this->function->h($_POST['acthorName']). "\"";
		} else {
			// まだ入力していない場合
			// DBの情報を表示する
			print " value=\"". $this->function->h($_SESSION['bookInfo']['acthorName']). "\"";
		}
		print "></td>\n";
		print "<td><b>[必須]</b></td><td>\n";
		// エラーメッセージがあるか確認
		if (!empty($errorArray['acthorName']['message'])) {
			// エラーメッセージがある場合
			print "<font class=\"red\">";
			print $errorArray['acthorName']['message'];
			print "</font>";
		}
		print "</td></tr>\n";
		
		// 出版社 pubisher
		print "<tr><th>出版社</th><td><input type=\"text\" name=\"pubisher\"";
		// 出版社が入力させているか確認
		if (!empty($_POST['pubisher'])) {
			// すでに出版社を入力してる場合
			print " value=\"". $this->function->h($_POST['pubisher']). "\"";
		} else {
			// まだ入力していない場合
			// DBの情報を表示する
			print " value=\"". $this->function->h($_SESSION['bookInfo']['pubisher']). "\"";
		}
		print "></td>\n";
		print "<td><b>[必須]</b></td><td>\n";
		// エラーメッセージがあるか確認
		if (!empty($errorArray['pubisher']['message'])) {
			// エラーメッセージがある場合
			print "<font class=\"red\">";
			print $errorArray['pubisher']['message'];
			print "</font>";
		}
		print "</td></tr>\n";
		
		// 出版年 publicationYear
		print "<tr><th>出版年</th><td><select name=\"publicationYear\">";
		print "<option value=\"\">------</option>";
        for ($i = date('Y'); $i >= START_YEAR; $i--) {
            print "<option value=\"". $i. "\"";
            // 出版年が入力させているか確認
            if (!empty($_POST['publicationYear'])) {
                // 選択されている場合
                if ($_POST['publicationYear'] == $i) {
                    // 同じ年が出力されるとき
                    print " selected";
                }
            } else {
            	// まだ選択していない場合
            	if ($_SESSION['bookInfo']['publicationYear'] == $i) {
                    // 同じ年が出力されるとき
                    print " selected";
                }
            }
            print ">". $i. "</option>";
        }
        print "</select>";
        print "年</td>\n";
		print "<td><b>[必須]</b></td><td>\n";
		// エラーメッセージがあるか確認
		if (!empty($errorArray['publicationYear']['message'])) {
			// エラーメッセージがある場合
			print "<font class=\"red\">";
			print $errorArray['publicationYear']['message'];
			print "</font>";
		}
		print "</td></tr>\n";
				
		// 分類 category
		print "<tr><th>分類</th><td><select name=\"category\">";
		print "<option value=\"\">--------</option>\n";
		foreach ($category as $content) {
			print "<option value=\"";
			print $content['categoryId'];
			print "\"";
			if (!empty($_POST['category'])) {
				// 入力されている場合
				if ($_POST['category'] == $content['categoryId']) {
					// 入力されている分類番号の場合
					print " selected";
				}
			}  else {
				// まだ選択されていない場合
				// 分類番号と一致した場合
				if ($_SESSION['bookInfo']['category'] == $content['categoryId']) {
					print " selected";
				}
			}
			print ">";
			print $content['categoryName'];
			print "</option>\n";
		}
		print "</select>";
		print "</td>\n";
		print "<td><b>[必須]</b></td><td> \n";
		// エラーメッセージがあるか確認
		if (!empty($errorArray['category']['message'])) {
			// エラーメッセージがある場合
			print "<font class=\"red\">";
			print $errorArray['category']['message'];
			print "</font>";
		}
		print "</td></tr>\n";
		
		// ISBNコード isbn
		print "<tr><th>ISBN</th><td><input type=\"text\" name=\"isbn\"";
		// 出版社が入力させているか確認
		if (!empty($_POST['isbn'])) {
			// すでに出版社を入力してる場合
			print " value=\"". $this->function->h($_POST['isbn']). "\"";
		} else {
			// まだ入力していない場合
			// DBの情報を表示する
			print " value=\"". $this->function->h($_SESSION['bookInfo']['isbn']). "\"";
		}
		print "></td>\n";
		print "<td></td><td>\n";
		// エラーメッセージがあるか確認
		if (!empty($errorArray['isbn']['message'])) {
			// エラーメッセージがある場合
			print "<br><font class=\"red\">";
			print $errorArray['isbn']['message'];
			print "</font>";
		}
		print "</td></tr>";
		
		// 現在の状態
		print "<tr><th>状態</th><td>";
        print $_SESSION['bookInfo']['bookStatus'];
        print "</td><td></td><td></td></tr>";

		// コメント comment
        print "<tr><th>コメント</th></tr></table>\n";
        print "<textarea name=\"comment\" rows=\"2\" cols=\"40\">";
        // コメントが入力されているか確認
        if (!empty($_POST['comment'])) {
        	// 入力されている場合
            print nl2br($this->function->h($_POST['comment']));
        }  else {
			// まだ入力していない場合
			// DBの情報を表示する
			print nl2br($this->function->h($_SESSION['bookInfo']['comment']));
		}
        print "</textarea>\n";
        // エラーメッセージがあるか確認
        if (!empty($errorArray['comment']['message'])) {
            // エラーメッセージがある場合
            print "<font class=\"red\">";
            print $errorArray['comment']['message'];
            print "</font>";
        }
        print "<br>1000文字以内でお願いします<br>\n";
        print "<br>\n";
        		
		print "※確認画面はないのでご注意ください<br>\n";
		print "<input type=\"submit\" id=\"button\" name=\"update\" value=\"変更\">\n";
		print "<input type=\"submit\" id=\"button\" name=\"delete\" value=\"削除\">\n";
		print "</form>\n";
		print "</p>";
	}
}
