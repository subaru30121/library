<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<?php

require_once(getcwd(). '/../view/header_view.php');
require_once(getcwd(). '/../view/footer_view.php');
require_once(getcwd(). '/../view/text_update_view.php');
require_once(getcwd(). '/../view/result_view.php');
require_once(getcwd(). '/../model/text_update_model.php');

$textUpdateView = new textUpdateView();
$resultView = new resultView();
$headerView = new headerView();
$footerView = new footerView();
$textUpdateModel = new textUpdateModel();

// タイトル設定
$title = "トップページ変更 - 情報科学専門学校図書室管理サイト";
// クラス指定
$class = "textUpdate";
// ヘッダー出力
$headerView->display($title, $class);
// エラー初期化
$errorArray = array();

if (!empty($_POST)) {
	// データが送信されてきた場合
	// バリデーション
	// お知らせのチェック
	$errorArray['new'] = $textUpdateModel->newCheck($_POST['new']);
	// お勧めの本のチェック
	// $errorArray['suggest'] = $textUpdateModel->suggestCheck($_POST['suggest']);
	$errorArray['suggest']['flg'] = true;
	if ($errorArray['new']['flg'] && $errorArray['suggest']['flg']) {
		// 正常な値だった場合
		// 最新情報の上書き
		$fp = fopen(getcwd(). '/../../../student/text/new.txt', "w");
		fputs($fp, $_POST['new']);
		fclose($fp);
		// お勧めの本の上書き
		/*
		$fp = fopen(getcwd(). '/../../../student/text/suggest.txt', "w");
		fputs($fp, $_POST['suggest']);
		fclose($fp);
		*/
		// メッセージ
		$message = "トップページの内容を変更しました";
		// 結果表示
		$resultView->display($message);
	} else {
		// 異常な値があった場合
		// テキスト情報初期化
		$new = null;
		$suggest = null;
		// 入力フォーム表示
		$textUpdateView->display($errorArray, $new, $suggest);
	}
} else {
	// 送信されてきてない場合
	// テキスト読み込み
	// 最新情報
	$new = null;
	$fp = fopen(getcwd(). '/../../../student/text/new.txt', "r");
	for($line = 1; !feof($fp); $line++){ 
		$new .= fgets($fp);
	}
	fclose($fp);
	// お勧めの本
	$suggest = null;
	/*
	$fp = fopen(getcwd(). '/../../../student/text/suggest.txt', "r");
	for($line = 1; !feof($fp); $line++){ 
		$suggest .= fgets($fp);
	}
	fclose($fp);
	*/
	// フォームを表示
	$textUpdateView->display($errorArray, $new, $suggest);
}

// フッター出力
$footerView->display();
