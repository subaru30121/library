<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<?php

// 分類の変更削除
require_once(getcwd(). '/../config/category_db.php');
require_once(getcwd(). '/../config/constant.php');
require_once(getcwd(). '/../view/category_id_view.php');
require_once(getcwd(). '/../view/category_info_view.php');
require_once(getcwd(). '/../view/result_view.php');
require_once(getcwd(). '/../view/header_view.php');
require_once(getcwd(). '/../view/footer_view.php');
require_once(getcwd(). '/../model/category_model.php');
require_once(getcwd(). '/../config/common_function.php');

$categoryDb = new categoryDb();
$categoryIdView = new categoryIdView();
$categoryInfoView = new categoryInfoView();
$resultView = new resultView();
$headerView = new headerView();
$footerView = new footerView();
$categoryModel = new categoryModel();
$function = new commonFunction();

// タイトル設定
$title = "分類管理 - 情報科学専門学校図書室管理サイト";
// クラス指定
$class = "categoryChange";
// ヘッダー出力
$headerView->display($title, $class);

// パラメータがあるか確認
if (empty($_REQUEST['status'])) {
	// 何も渡されていない場合
	// 入力画面
	
	// エラー配列初期化
	// $errorArray['項目名']['フラグ、メッセージ']
	$errorArray = array();
	
	// 入力画面表示
	$categoryIdView->display($errorArray);
} else {
	// パラメータを渡された場合
	$status = $_REQUEST['status'];
	// セッションスタート
	session_start();
	// パラメータによって処理を変更
	switch($status) {
		case FIRST_STAGE:
			// エラーの初期化
			$errorArray = array();
			// 分類番号の半角化
			$_POST['categoryId'] = $function->convert($_POST['categoryId'], "n", "UTF-8");
			// 分類番号のチェック
			$errorArray['categoryId'] = $categoryModel->categoryIdChangeCheck($_POST['categoryId'], $errorArray);
			// エラーの確認
			if ($errorArray['categoryId']['flg']) {
				// エラーがなかった場合
				// 結果の初期化
				$result = array();
				// 分類IDの検索(分類DB)
				$result = $categoryDb->selectOne($_POST['categoryId']);
				// セッション格納
				$_SESSION['categoryInfo'] = $result;
				
				// エラー初期化
				$errorArray = array();
				$categoryInfoView->display($errorArray);
			} else {
				// エラーがあった場合
				// 再び入力画面へ
				$categoryIdView->display($errorArray);
			}
			break;
		case SECOND_STAGE:
			// 変更か確認
			if (!empty($_POST['update'])) {
				// 変更の場合
				// エラーの初期化
				$errorArray = array();
				// 分類名のチェック
				$errorArray['categoryName'] = $categoryModel->categoryNameCheck($_POST['categoryName'], $errorArray);
				// エラーの確認
				if ($errorArray['categoryName']['flg']) {
					// エラーがない場合
					$result = $categoryDb->update($_SESSION['categoryInfo']['categoryId'], $_POST['categoryName']);
					// 結果判定
					if ($result) {
						$message = "成功";
					} else {
						$message = "失敗";
					}
					// 結果表示
					$resultView->display($message);
				} else {
					// エラーがあった場合
					// 再び入力画面へ
					$categoryInfoView->display($errorArray);
				}
			}
			// 削除か確認
			if (!empty($_POST['delete'])) {
				// 削除だった場合
				// 対象レコードの削除
				$result = $categoryDb->delete($_SESSION['categoryInfo']['categoryId']);
				// 結果判別
				if ($result) {
					$message = "成功";
				} else {
					$message = "失敗";
				}
				// 結果表示
				$resultView->display($message);
			}
			break;
		default:
			break;
	}
}
// フッター出力
$footerView->display();
