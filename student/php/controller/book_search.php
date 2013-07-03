<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">

<?php

require_once(getcwd(). '/../view/book_search_view.php');
require_once(getcwd(). '/../view/header_view.php');
require_once(getcwd(). '/../view/footer_view.php');
require_once(getcwd(). '/../model/book_search_model.php');
require_once(getcwd(). '/../config/category_db.php');
require_once(getcwd(). '/../config/common_function.php');

$bookSearchView = new bookSearchView();
$headerView = new headerView();
$footerView = new footerView();
$bookSearchModel = new bookSearchModel();
$categoryDb = new categoryDb();
$commonFunction = new commonfunction();

// タイトル設定
$title = "蔵書検索 - 情報科学専門学校図書室サイト";

// エラーの初期化
$errorArray = array();
// 分類の取り出し
$category = $categoryDb->select();
// うさぎ関連
$rabbitFlg = $commonFunction->rabbitBorn();;

if (!empty($_POST)) {
	// データが送られてきた場合
	// 入力チェック
	// 蔵書名のバリデート
	$errorArray['bookName'] = $bookSearchModel->bookNameCheck($_POST['bookName'], $errorArray);
	// 著者名のバリデート
	$errorArray['acthorName'] = $bookSearchModel->acthorNameCheck($_POST['acthorName'], $errorArray);
	// 出版年のバリデート
	$errorArray['publicationYear'] = $bookSearchModel->publicationYearCheck($_POST['publicationYear'], $errorArray);
	// 分類のバリデート
	$errorArray['category'] = $bookSearchModel->categoryCheck($_POST['category'], $errorArray);
	
	// エラーの確認
	if ($errorArray['bookName']['flg'] && $errorArray['acthorName']['flg'] && $errorArray['publicationYear']['flg'] && $errorArray['category']['flg']) {
		// エラーがない場合
		
		// セッションに検索条件を入れる
		session_start();
		$_SESSION['search'] = $_POST;
		
		// 検索結果ページへ飛ぶ
		header("Location:book_search_result.php");
	} else {
		// エラーがあった場合
		// 入力画面の表示
		// ヘッダー出力
		$headerView->display($title, $rabbitFlg);
		$bookSearchView->display($errorArray, $category);
	}
} else {
	// 何もPOSTされていない場合
	// 検索項目フォームの表示
	// ヘッダー出力
	$headerView->display($title, $rabbitFlg);
	$bookSearchView->display($errorArray, $category);
}

// フッター出力
$footerView->display();
