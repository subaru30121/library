<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">

<?php

require_once(getcwd(). '/../view/study_search_view.php');
require_once(getcwd(). '/../view/header_view.php');
require_once(getcwd(). '/../view/footer_view.php');
require_once(getcwd(). '/../model/study_search_model.php');
require_once(getcwd(). '/../config/category_db.php');
require_once(getcwd(). '/../config/common_function.php');

$studySearchView = new studySearchView();
$headerView = new headerView();
$footerView = new footerView();
$studySearchModel = new studySearchModel();
$categoryDb = new categoryDb();
$commonFunction = new commonFunction();

// タイトル設定
$title = "卒論検索 - 情報科学専門学校図書室サイト";

// エラーの初期化
$errorArray = array();
// 分類の取り出し
$category = $categoryDb->select();
// うさぎ関連
$rabbitFlg = $commonFunction->rabbitBorn();

if (!empty($_POST)) {
	// データが送られてきた場合
	// 入力チェック
	// 蔵書名のバリデート
	$errorArray['theme'] = $studySearchModel->themeCheck($_POST['theme'], $errorArray);
	// 著者名のバリデート
	$errorArray['acthorName'] = $studySearchModel->acthorNameCheck($_POST['acthorName'], $errorArray);
	// 出版年のバリデート
	$errorArray['publicationYear'] = $studySearchModel->publicationYearCheck($_POST['publicationYear'], $errorArray);
	// 分類のバリデート
	$errorArray['category'] = $studySearchModel->categoryCheck($_POST['category'], $errorArray);
	
	// エラーの確認
	if ($errorArray['theme']['flg'] && $errorArray['acthorName']['flg'] && $errorArray['publicationYear']['flg'] && $errorArray['category']['flg']) {
		// エラーがない場合
		
		// セッションに検索条件を入れる
		session_start();
		$_SESSION['search'] = $_POST;
		
		// 検索結果ページへ飛ぶ
		header("Location:study_search_result.php");
	} else {
		// エラーがあった場合
		// 入力画面の表示
		// ヘッダー出力
		$headerView->display($title, $rabbitFlg);
		$studySearchView->display($errorArray, $category);
	}
} else {
	// 何もPOSTされていない場合
	// 検索項目フォームの表示
	// ヘッダー出力
	$headerView->display($title, $rabbitFlg);
	$studySearchView->display($errorArray, $category);
}

// フッター出力
$footerView->display();
