<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<?php

require_once(getcwd(). '/../view/request_detail_view.php');
require_once(getcwd(). '/../view/header_view.php');
require_once(getcwd(). '/../view/footer_view.php');
require_once(getcwd(). '/../view/result_view.php');
require_once(getcwd(). '/../config/request_db.php');
require_once(getcwd(). '/../config/common_function.php');

$requestDetailView = new requestDetailView();
$headerView = new headerView();
$footerView = new footerView();
$resultView = new resultView();
$requestDb = new requestDb();
$commonFunction = new commonFunction();

// タイトル設定
$title = "購入依頼詳細 - 情報科学専門学校図書室サイト";
// クラス指定
$class = "requestList";
// エラーの初期化
$errorArray = array();

// セッション開始
session_start();

// ヘッダー出力
$headerView->display($title, $class);

// リクエストID取り出し
if (!empty($_GET['id'])) {
	// ページの指定がある場合
	if (preg_match('/^[1-9][0-9]*$/', $_GET['id'])) {
		// 数字だった場合
		$requestId = $_GET['id'];
	}
}

// 一つ削除
if (!empty($_POST['one']) && !empty($_SESSION['requestInfo']['requestId'])) {
	// リクエストIDを使用し、レコード一つを削除
	$result = $requestDb->deleteId($_SESSION['requestInfo']['requestId']);
	// 結果判定
	if ($result) {
		$message = "削除に成功しました";
	} else {
		$message = "削除に失敗しました";
	}
	// 表示
	$resultView->display($message);
	// セッション破棄
	$_SESSION = array();
	// フッター出力
	$footerView->display();
	return;
}

// まとめて削除
if (!empty($_POST['multiple']) && !empty($_SESSION['requestInfo']['isbn'])) {
	// ISBNを使用し、同じ蔵書をすべて削除
	$result = $requestDb->deleteIsbn($_SESSION['requestInfo']['isbn']);
	// 結果判定
	if ($result) {
		$message = "削除に成功しました";
	} else {
		$message = "削除に失敗しました";
	}
	// 表示
	$resultView->display($message);
	// セッション破棄
	$_SESSION = array();
	// フッター出力
	$footerView->display();
	return;
}

// 内容表示
// IDの確認
if (empty($requestId)) {
	// 蔵書IDがまだ未定義の場合
	$message = "正しい蔵書IDを設定してください";
	$resultView->display($message);
} else {
	// 蔵書IDが定義されてる場合
	// 蔵書情報の取り出し
	$result = $requestDb->selectOne($requestId);
	if ($result['flg']) {
		// 見つかった場合
		// 詳細を検索
		$bookInfo = $commonFunction->isbn($result['isbn']);
		// 著者名・出版社・出版年の挿入
		$result['acthorName'] = $bookInfo['acthorName'];
		$result['publisher'] = $bookInfo['publisher'];
		$result['publicationYear'] = $bookInfo['publicationYear'];
		// 同じ蔵書の数の検索
		$result['equal'] = $requestDb->countIsbn($result['isbn']);
		// 外部サイトへのURL
		$result['url'] = "http://www.amazon.co.jp/s/ref=nb_sb_noss?__mk_ja_JP=%83J%83%5E%83J%83i&url=search-alias%3Dstripbooks&field-keywords=". $result['isbn'];
		// セッションに格納
		$_SESSION['requestInfo'] = $result;
		// 詳細表示
		$requestDetailView->display($result);
	} else {
		// 見つからない場合
		$message = "その蔵書は破棄されたか存在しません";
		$resultView->display($message);
	}
}
// フッター出力
$footerView->display();
