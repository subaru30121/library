<?php
	if (!empty($_GET['id'])) {
		if ($_GET['id'] == "iwasakiLibrary") {
			session_start();
			$_SESSION['hide'] = "ok";
			header("LOCATION:../../html/usagi.php");
		}
	}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<?php

require_once(getcwd(). '/../view/book_detail_view.php');
require_once(getcwd(). '/../view/header_view.php');
require_once(getcwd(). '/../view/footer_view.php');
require_once(getcwd(). '/../view/result_view.php');
require_once(getcwd(). '/../config/master_books_db.php');
require_once(getcwd(). '/../config/book_status_db.php');
require_once(getcwd(). '/../config/category_db.php');
require_once(getcwd(). '/../config/common_function.php');

$bookDetailView = new bookDetailView();
$headerView = new headerView();
$footerView = new footerView();
$resultView = new resultView();
$masterBooksDb = new masterBooksDb();
$bookStatusDb = new bookStatusDb();
$categoryDb = new categoryDb();
$commonFunction = new commonFunction();

// タイトル設定
$title = "蔵書詳細 - 情報科学専門学校図書室サイト";

// エラーの初期化
$errorArray = array();
// うさぎ関連
$rabbitFlg = $commonFunction->rabbitBorn();

// ヘッダー出力
$headerView->display($title, $rabbitFlg);

// 蔵書ID取り出し
if (!empty($_GET['id'])) {
	// ページの指定がある場合
	if (preg_match('/^[1-9][0-9]*$/', $_GET['id'])) {
		// 数字だった場合
		$bookId = $_GET['id'];
	}
}

if (empty($bookId)) {
	// 蔵書IDがまだ未定義の場合
	$message = "正しい蔵書IDを設定してください";
	$resultView->display($message);
} else {
	// 蔵書IDが定義されてる場合
	// 蔵書情報の取り出し
	$result = $masterBooksDb->selectOne($bookId);
	if ($result['flg']) {
		// 見つかった場合
		// 状態の取り出し
		$result = $bookStatusDb->selectOne($result['id'], $result);
		$category = $categoryDb->selectOne($result['category']);
		$result['category'] = $category['categoryName'];
		$result['status'] = $commonFunction->statusToString($result['bookStatus']);
		// 詳細表示
		$bookDetailView->display($result);
	} else {
		// 見つからない場合
		$message = "その蔵書は破棄されたか存在しません";
		$resultView->display($message);
	}
}
// フッター出力
$footerView->display();
