<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<?php

require_once(getcwd(). '/../view/header_view.php');
require_once(getcwd(). '/../view/footer_view.php');
require_once(getcwd(). '/../view/result_view.php');
require_once(getcwd(). '/../view/book_search_result_view.php');
require_once(getcwd(). '/../config/master_books_db.php');
require_once(getcwd(). '/../config/common_function.php');
require_once(getcwd(). '/../config/constant.php');

$headerView = new headerView();
$footerView = new footerView();
$resultView = new resultView();
$bookSearchResultView = new bookSearchResultView();
$masterBooksDb = new masterBooksDb();
$commonFunction = new commonFunction();

// タイトル設定
$title = "蔵書検索結果 - 情報科学専門学校図書室サイト";
$rabbitFlg = $commonFunction->rabbitBorn();

// セッション開始
session_start();
// セッションの確認
if (!empty($_SESSION['search'])) {
	// 検索条件がある場合
	// ヘッダー出力
	$headerView->display($title, $rabbitFlg);
	// 全件数を取得
	$data['total'] = $masterBooksDb->count($_SESSION['search']);
	if ($data['total'] != 0) {
		// 検索結果がある場合
		// ページ数計算
		$data['totalPage'] = ceil((int)$data['total'] / PAGING_NUMBER);
		
		// 現在のページ数取り出し
		if (!empty($_GET['page'])) {
			// ページの指定がある場合
			if (preg_match('/^[1-9][0-9]*$/', $_GET['page'])) {
				// 数字だった場合
				if ($_GET['page'] <= $data['totalPage']) {
					// 正常なページ数だった場合
					$page = $_GET['page'];
				}
			}
		}
		if (empty($page)) {
			// $pageがまだ未定義の場合
			$page = 1;
		}
		$data['page'] = $page;

		// 表示ページ計算
		$data['firstPage'] = $page - 5 < 1 ? 1 : $page - 5;

		// masterテーブルから現在の貸出状況を取り出す
		// 取り出す情報を制限する
		$offset = PAGING_NUMBER * ($page - 1);
		$content = $masterBooksDb->select($_SESSION['search'], $offset, PAGING_NUMBER);
		
		// 表示件数
		$data['from'] = $offset + 1;
		$data['to'] = ($offset + PAGING_NUMBER) < $data['total'] ? ($offset + PAGING_NUMBER) : $data['total'];
		
		// 結果を表示
		$bookSearchResultView->display($data, $content);
	} else {
		// １冊も借りられていない場合
		$message = "検索結果に一致する蔵書はありませんでした";
		// 結果表示
		$resultView->display($message);
	}
} else {
	// 検索条件がない場合
	// 入力ページに戻る
	header("Location:book_search.php");
}

// フッター出力
$footerView->display();
