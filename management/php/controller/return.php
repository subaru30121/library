<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<?php

// 蔵書の貸出
require_once(getcwd(). '/../view/return_view.php');
require_once(getcwd(). '/../view/result_view.php');
require_once(getcwd(). '/../view/header_view.php');
require_once(getcwd(). '/../view/footer_view.php');
require_once(getcwd(). '/../model/return_model.php');
require_once(getcwd(). '/../config/book_status_db.php');
require_once(getcwd(). '/../config/log_db.php');
require_once(getcwd(). '/../config/constant.php');
require_once(getcwd(). '/../config/common_function.php');

$returnView = new returnView();
$resultView = new resultView();
$headerView = new headerView();
$footerView = new footerView();
$returnModel = new returnModel();
$bookStatusDb = new bookStatusDb();
$logDb = new logDb();
$function = new commonFunction();

// タイトル設定
$title = "蔵書返却 - 情報科学専門学校図書室管理サイト";
// クラス指定
$class = "return";
// ヘッダー出力
$headerView->display($title, $class);

// POSTされているか確認
if (!isset($_POST['bookId'])) {
	// POSTされていない場合
	// エラー初期化
	$errorArray = array();
	// 入力画面
	$returnView->display($errorArray);
} else {
	// POSTされている場合
	
	// バリデート
	// エラー初期化
	$errorArray = array();
	// 蔵書IDの半角化
	$_POST['bookId'] = $function->convert($_POST['bookId'], "n", "UTF-8");
	// 蔵書番号のバリデート
	$errorArray['bookId'] = $returnModel->bookIdCheck($_POST['bookId'], $errorArray);
	// バリデート結果の確認
	if ($errorArray['bookId']['flg']) {
		// エラーがない場合
		$result = array();
		// 本の状態変更
		$result['status'] = $bookStatusDb->update($_POST['bookId'], POSSIBLE);
		// ログの書き込み
		$result['log'] = $logDb->delete($_POST['bookId']);
		// 結果判別
		if ($result['status'] && $result['log']) {
			$message = "成功";
		} else {
			$message = "失敗";
		}
		// 結果表示
		$resultView->display($message);
	} else {
		// エラーがある場合
		// 再び入力画面
		$returnView->display($errorArray);
	}
}
// フッター出力
$footerView->display();
