<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<?php

require_once(getcwd(). '/../view/header_view.php');
require_once(getcwd(). '/../view/footer_view.php');
require_once(getcwd(). '/../view/request_isbn_view.php');
require_once(getcwd(). '/../view/book_info_view.php');
require_once(getcwd(). '/../view/result_view.php');
require_once(getcwd(). '/../model/isbn_model.php');
require_once(getcwd(). '/../config/common_function.php');
require_once(getcwd(). '/../config/request_db.php');

$headerView = new headerView();
$footerView = new footerView();
$requestIsbnView = new requestIsbnView();
$bookInfoView = new bookInfoView();
$resultView = new resultView();
$isbnModel = new isbnModel();
$commonFunction = new commonFunction();
$requestDb = new requestDb();

// ログインされてるか確認
session_start();
if (empty($_SESSION['loginData'])) {
	// ログインしていない場合
	// ログイン画面へリダイレクト
	header('Location:request_student.php');
}

// セッションキー変更
// 前のキーは残さない
session_regenerate_id(true);

// タイトル設定
$title = "購入依頼 - 情報科学専門学校図書室サイト";

// エラーの初期化
$errorArray = array();
// うさぎ関連
$rabbitFlg = $commonFunction->rabbitBorn();
// ヘッダー出力
$headerView->display($title, $rabbitFlg);
if (empty($_POST)) {
	// 何も入力されていない場合
	// 入力フォームを表示
	$requestIsbnView->display($errorArray);
} else if (!empty($_POST['isbn'])) {
	// ISBNが入力されてる場合
	// 入力チェック
	// ISBNのバリデート
	$errorArray['isbn'] = $isbnModel->isbnCheck($_POST['isbn']);
	if ($errorArray['isbn']['flg']) {
		// エラーがない場合
		$_SESSION['bookData'] = $errorArray['isbn']['info'];
		// 蔵書詳細表示
		$bookInfoView->display();
	} else {
		// エラーがあった場合
		// 入力フォームを再表示
		$requestIsbnView->display($errorArray);
	}
} else if (!empty($_POST['request'])) {
	// 送信ボタンが押された場合
	// 蔵書情報がセッションにあるか確認
	if (empty($_SESSION['bookData'])) {
		// ない場合
		// 入力フォームを表示
		$requestIsbnView->display($errorArray);
		// フッター出力
		$footerView->display();
		return;
	}
	// 結果初期化
	$resultFlg = false;
	// DBに保存
	$resultFlg['db'] = $requestDb->add($_SESSION['loginData']['id'], $_SESSION['loginData']['class'], $_SESSION['loginData']['name'], $_SESSION['bookData']['bookName'], $_SESSION['bookData']['isbn']);
	// メール送信
	// あとで
	$resultFlg['mail'] = true;
	
	if ($resultFlg['db'] && $resultFlg['mail']) {
		// どちらも成功した場合
		$message = "購入依頼を出しました";
	} else {
		// 失敗した場合
		$message = "購入依頼を出すことが出来ませんでした\n";
	}
	// 結果表示
	$resultView->display($message);
	// セッションの初期化
	$_SESSION = array();
} else {
	// ISBN入力されていない
	$errorArray['isbn']['message'] = "ISBNを入力してください";
	// 入力フォームを再表示
	$requestIsbnView->display($errorArray);
}

// フッター出力
$footerView->display();
