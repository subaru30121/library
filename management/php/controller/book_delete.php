<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<?php

// 本の破棄
require_once(getcwd(). '/../config/master_books_db.php');
require_once(getcwd(). '/../config/category_db.php');
require_once(getcwd(). '/../config/book_status_db.php');
require_once(getcwd(). '/../view/change_view_id.php');
require_once(getcwd(). '/../view/book_info_only_view.php');
require_once(getcwd(). '/../view/result_view.php');
require_once(getcwd(). '/../view/header_view.php');
require_once(getcwd(). '/../view/footer_view.php');
require_once(getcwd(). '/../model/change_model.php');
require_once(getcwd(). '/../config/common_function.php');
require_once(getcwd(). '/../config/constant.php');

$masterBooksDb = new masterBooksDb();
$categoryDb = new categoryDb();
$bookStatusDb = new bookStatusDb();
$changeViewId = new changeViewId();
$bookInfoOnlyView = new bookInfoOnlyView();
$resultView = new resultView();
$headerView = new headerView();
$footerView = new footerView();
$changeModel = new changeModel();
$function = new commonFunction();

// タイトル設定
$title = "蔵書破棄 - 情報科学専門学校図書室管理サイト";
// クラス指定
$class = "bookDelete";
// ヘッダー出力
$headerView->display($title, $class);
// h1設定
$h1 = "蔵書破棄";

// パラメータがあるか確認
if (empty($_REQUEST['status'])) {
	// 何も渡されていない場合
	// 入力画面
	
	// エラー配列初期化
	// $errorArray['項目名']['フラグ、メッセージ']
	$errorArray = array();
	
	// 入力画面表示
	$changeViewId->display($errorArray, $h1);
} else {
	// パラメータを渡された場合
	$status = $_REQUEST['status'];
	// 分類取り出し
	$category = $categoryDb->select();
	// パラメータによって処理を変更
	switch($status) {
		case FIRST_STAGE:
			// 入力チェック
			// エラーの初期化
			$errorArray = array();
			// 蔵書IDの半角化
			$_POST['bookId'] = $function->convert($_POST['bookId'], "n", "UTF-8");
			// 蔵書IDのバリデート
			$errorArray['bookId'] = $changeModel->bookIdCheck($_POST['bookId'], $errorArray);
			
			// エラーの確認
			if ($errorArray['bookId']['flg']) {
				// エラーがない場合
				// 結果の初期化
				$result = array();
				// セッション開始
				session_start();
				// 蔵書IDの検索(マスターDB)
				$result = $masterBooksDb->selectOne($_POST['bookId'], $result);
				if ($result['flg']) {
					// IDが見つかった場合
					// 分類の日本語化
					$category = $categoryDb->selectOne($result['category']);
					$result['category'] = $category['categoryName'];
					// 状態の検索(状態DB)
					$result = $bookStatusDb->selectOne($_POST['bookId'], $result);
					// 状態の日本語化
					$result['bookStatus'] = $function->statusToString($result['bookStatus']);
					// セッション格納
					$_SESSION['bookInfo'] = $result;
					
					$bookInfoOnlyView->display();
				}
			} else {
				// 入力エラーがあった場合
				// 再び入力画面へ
				$changeViewId->display($errorArray, $h1);
			}
			break;
		case SECOND_STAGE:
			session_start();
			// 状態の確認
			$message = null;
			$outcome = array();
			$outcome = $bookStatusDb->selectOne($_SESSION['bookInfo']['id'], $outcome);
			if ($outcome['bookStatus'] == DELETE_PLAN) {
				// 本が「破棄予定」の場合
				// 結果の初期化
				$result = array();
				// 状態の変更
				$result['status'] = $bookStatusDb->delete($_SESSION['bookInfo']['id']);
				// 結果判別
				if ($result['status']) {
					$message = "成功";
				} else {
					$message = "失敗";
				}
			} else {
				// 破棄予定の本ではなかった場合
				// エラーメッセージ
				$message = "破棄予定の本ではありません\n管理画面で破棄予定にした後にもう一度おこなってください";
			}
			// 結果表示
			$resultView->display($message);
			break;
		defalut:
			break;
	}
}
// フッター出力
$footerView->display();
