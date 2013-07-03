<?

require_once(getcwd(). '/../config/common_function.php');
require_once(getcwd(). '/../config/constant.php');

class studySearchView {
	
	var $function;
	
	function display($errorArray, $category) {
		
		$this->function = new commonFunction();
		
		print "<h1>卒論検索</h1>\n";
		
		print "<form action=\"\" method=\"POST\">\n";
		
		print "<table>\n";
		// テーマ theme
		print "<tr>";
		print "<th>テーマ</th>";
		print "<td><input type=\"text\" name=\"theme\"";
		// テーマが入力させているか確認
		if (!empty($_POST['theme'])) {
			// すでにテーマを入力してる場合
			print " value=\"". $this->function->h($_POST['theme']). "\"";
		}
		print "></td></tr>\n";
		// エラーメッセージがあるか確認
		if (!empty($errorArray['theme']['message'])) {
			// エラーメッセージがある場合
			print "<th><td><font color=\"red\">";
			print $errorArray['theme']['message'];
			print "</font></td></tr>";
		}
		
		// 生徒名 acthorName
		print "<tr>";
		print "<th>生徒名</th>";
		print "<td><input type=\"text\" name=\"acthorName\"";
		// 生徒名が入力させているか確認
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
			print "</font></td></tr>";
		}
		
		// 年度 publicationYear
		print "<tr><th>作成年</th>";
		print "<td><select name=\"publicationYear\">";
		print "<option value=\"\">検索しない</option>";
        for ($i = START_YEAR; $i <= date('Y'); $i++) {
            print "<option value=\"". $i. "\"";
            // 年度が入力させているか確認
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
		// エラーメッセージがあるか確認
		if (!empty($errorArray['category']['message'])) {
			// エラーメッセージがある場合
			print "<tr><td><font color=\"red\">";
			print $errorArray['category']['message'];
			print "</font></th></td>";
		}
		print "</table>\n";
		print "<p>※指定した年以降のものを検索します</p>\n";
		print "<br>\n";
		print "<input type=\"submit\" value=\"検索\">\n";
		print "</form>\n";
	}
}
