<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<?php

// 蔵書の貸出
require_once(getcwd(). '/../view/rental_view.php');
require_once(getcwd(). '/../view/result_view.php');
require_once(getcwd(). '/../view/header_view.php');
require_once(getcwd(). '/../view/footer_view.php');
require_once(getcwd(). '/../model/rental_model.php');
require_once(getcwd(). '/../config/book_status_db.php');
require_once(getcwd(). '/../config/log_db.php');
require_once(getcwd(). '/../config/constant.php');
require_once(getcwd(). '/../config/common_function.php');

$rentalView = new rentalView();
$resultView = new resultView();
$headerView = new headerView();
$footerView = new footerView();
$rentalModel = new rentalModel();
$bookStatusDb = new bookStatusDb();
$logDb = new logDb();
$function = new commonFunction();

// タイトル設定
$title = "蔵書貸出 - 情報科学専門学校図書室管理サイト";
// クラス指定
$class = "rental";
// ヘッダー出力
$headerView->display($title, $class);

// POSTされているか確認
if (!isset($_POST['bookId']) || !isset($_POST['studentId'])) {
	// POSTされていない場合
	// エラー初期化
	$errorArray = array();
	// 入力画面
	$rentalView->display($errorArray);
} else {
	// POSTされている場合
	
	// バリデート
	// エラー初期化
	$errorArray = array();
	// 学籍番号の半角化
	$_POST['studentId'] = $function->convert($_POST['studentId'], "n", "UTF-8");
	// 学籍番号のバリデート
	$errorArray['studentId'] = $rentalModel->studentIdCheck($_POST['studentId'], $errorArray);
	// 蔵書IDの半角化
	$_POST['bookId'] = $function->convert($_POST['bookId'], "n", "UTF-8");
	// 蔵書番号のバリデート
	$errorArray['bookId'] = $rentalModel->bookIdCheck($_POST['bookId'], $errorArray);
	
	// バリデート結果の確認
	if ($errorArray['studentId']['flg'] && $errorArray['bookId']['flg']) {
		// エラーがない場合
		$result = array();
		// 本の状態変更
		$result['status'] = $bookStatusDb->update($_POST['bookId'], LENDED);
		// ログの書き込み
		$result['log'] = $logDb->add($_POST['bookId'], $_POST['studentId']);
		
		// 結果判別
		if ($result['status'] && $result['log']) {
			$message = "成功";
		} else {
			$message = "失敗";
		}
		// 結果出力
		$resultView->display($message);
	} else {
		// エラーがある場合
		// 再び入力画面
		$rentalView->display($errorArray);
	}
}
// フッター出力
$footerView->display();
