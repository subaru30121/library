<?php

require_once(getcwd(). '/../config/common_function.php');
require_once(getcwd(). '/../config/constant.php');

class inputView {
	
	var $functino;
	
	function display($errorArray, $category) {
		
		$this->function = new commonFunction();
		
		print "<h1>蔵書追加</h1>\n";
		print "<p>";
		print "<table id=\"input\"><form action=\"?status=". SECOND_STAGE. "\" method=\"POST\" onSubmit=\"return check();\">\n";
		
		// 蔵書名 bookName
		print "<tr><th>蔵書名</th><td id=\"data\"><input type=\"text\" name=\"bookName\"";
		// 蔵書名が入力させているか確認
		if (!empty($_POST['bookName'])) {
			// すでに蔵書名を入力してる場合
			print " value=\"". $this->function->h($_POST['bookName']). "\"";
		} else if (!empty($errorArray['isbn']['info']['bookName'])) {
			// 入力されていなくてISBNで情報を得ている場合
			print " value=\"". $this->function->h($errorArray['isbn']['info']['bookName']). "\"";
		}
		print "></td>\n";
		print "<td id=\"indispensable\"><b>[必須]</b></td>\n";
		// エラーメッセージがあるか確認
			print "<td>";
		if (!empty($errorArray['bookName']['message'])) {
			// エラーメッセージがある場合
			print "<font class=\"red\">";
			print $errorArray['bookName']['message'];
			print "</font>";
		} else {
			print "&nbsp;";
		}

		print "</td></tr>";
		
		// 著者名 acthorName
		print "<tr><th>著者名</th><td><input type=\"text\" name=\"acthorName\"";
		// 著者名が入力させているか確認
		if (!empty($_POST['acthorName'])) {
			// すでに著者名を入力してる場合
			print " value=\"". $this->function->h($_POST['acthorName']). "\"";
		} else if (!empty($errorArray['isbn']['info']['acthorName'])) {
			// 入力されていなくてISBNで情報を得ている場合
			print " value=\"". $this->function->h($errorArray['isbn']['info']['acthorName']). "\"";
		}
		print "></td>\n";
		print "<td><b>[必須]</b></td>\n";
			print "<td>";
		// エラーメッセージがあるか確認
		if (!empty($errorArray['acthorName']['message'])) {
			// エラーメッセージがある場合
			print "<font class=\"red\">";
			print $errorArray['acthorName']['message'];
			print "</font>";
		}
		print "</td></tr>";
		
		// 出版社 pubisher
		print "<tr><th>出版社</th><td><input type=\"text\" name=\"pubisher\"";
		// 出版社が入力させているか確認
		if (!empty($_POST['pubisher'])) {
			// すでに出版社を入力してる場合
			print " value=\"". $this->function->h($_POST['pubisher']). "\"";
		} else if (!empty($errorArray['isbn']['info']['publisher'])) {
			// 入力されていなくてISBNで情報を得ている場合
			print " value=\"". $this->function->h($errorArray['isbn']['info']['publisher']). "\"";
		}
		print "></td>\n";
		print "<td><b>[必須]</b></td>\n";
		print "<td>";
		// エラーメッセージがあるか確認
		if (!empty($errorArray['pubisher']['message'])) {
			// エラーメッセージがある場合
			print "<font class=\"red\">";
			print $errorArray['pubisher']['message'];
			print "</font>";
		}
			print "</td></tr>";
		
		// 出版年 publicationYear
		print "<tr><th>出版年</th><td><select name=\"publicationYear\">";
		print "<option value=\"\">選択してください</option>";
        for ($i = date('Y'); $i >= START_YEAR; $i--) {
            print "<option value=\"". $i. "\"";
            // 出版年が入力させているか確認
            if (!empty($_POST['publicationYear'])) {
                // 選択されている場合
                if ($_POST['publicationYear'] == $i) {
                    // 同じ年が出力されるとき
                    print " selected";
                }
            } else if (!empty($errorArray['isbn']['info']['publicationYear'])) {
				// 入力されていなくてISBNで情報を得ている場合
				if ($errorArray['isbn']['info']['publicationYear'] == $i) {
                    // 同じ年が出力されるとき
                    print " selected";
                }
			}
            print ">". $i. "</option>";
        }
        print "</select>";
        print "年</td>\n";
		print "<td><b>[必須]</b></td>\n";
		print "<td>";
		// エラーメッセージがあるか確認
		if (!empty($errorArray['publicationYear']['message'])) {
			// エラーメッセージがある場合
			print "<font class=\"red\">";
			print $errorArray['publicationYear']['message'];
			print "</font>";
		}
			print "</td></tr>";
		
		// 分類 category
		print "<tr><th>分類</th><td><select name=\"category\">";
		print "<option value=\"\">選択してください</option>\n";
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
		print "</select>";
		print "</td>\n";
		print "<td><b>[必須]</b></td>\n";
		print "<td>";
		// エラーメッセージがあるか確認
		if (!empty($errorArray['category']['message'])) {
			// エラーメッセージがある場合
			print "<font class=\"red\">";
			print $errorArray['category']['message'];
			print "</font>";
		}
		print "</td></tr>";
		
		// コメント comment
        print "<tr><th>コメント</th></tr></table>\n";
        print "<textarea name=\"comment\" rows=\"2\" cols=\"40\">";
        // コメントが入力されているか確認
        if (!empty($_POST['comment'])) {
        	// 入力されている場合
            print $this->function->h($_POST['comment']);
        }
        print "</textarea>\n";
        // エラーメッセージがあるか確認
        if (!empty($errorArray['comment']['message'])) {
            // エラーメッセージがある場合
            print "<font class=\"red\">";
            print $errorArray['comment']['message'];
            print "</font>";
        }
        print "<br />1000文字以内でお願いします<br>\n";
        print "<br>\n";
		
		print "※確認画面はないので、内容に間違いがないよう注意してください<br>\n";
		print "<input type=\"submit\" id=\"button\" value=\"登録\">\n";
		print "</form>\n";
		print "</p>";
	}
}
