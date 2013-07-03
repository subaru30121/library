<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">

<?php

// 本の変更、削除
require_once(getcwd(). '/../config/master_books_db.php');
require_once(getcwd(). '/../config/category_db.php');
require_once(getcwd(). '/../config/book_status_db.php');
require_once(getcwd(). '/../view/change_view_id.php');
require_once(getcwd(). '/../view/book_info_view.php');
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
$bookInfoView = new bookInfoView();
$resultView = new resultView();
$headerView = new headerView();
$footerView = new footerView();
$changeModel = new changeModel();
$function = new commonFunction();

// タイトル設定
$title = "蔵書管理 - 情報科学専門学校図書室管理サイト";
// クラス指定
$class = "bookChange";
// ヘッダー出力
$headerView->display($title, $class);
// h1設定
$h1 = "蔵書変更・削除";

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
				$result = $masterBooksDb->selectOne($_POST['bookId']);
				if ($result['flg']) {
					// IDが見つかった場合
					// 状態の検索(状態DB)
					$result = $bookStatusDb->selectOne($_POST['bookId'], $result);
					// 状態の日本語化
					$result['bookStatus'] = $function->statusToString($result['bookStatus']);
					// セッション格納
					$_SESSION['bookInfo'] = $result;
					
					// エラー初期化
					$errorArray = array();
					$bookInfoView->display($errorArray, $category);
				}
			} else {
				// 入力エラーがあった場合
				// 再び入力画面へ
				$changeViewId->display($errorArray, $h1);
			}
			break;
		case SECOND_STAGE:
			// 変更か確認
			session_start();
			if (!empty($_POST['update'])) {
				// 変更だった場合
				// 入力チェック
				// エラーの初期化
				$errorArray = array();
				// 蔵書名のバリデート
				$errorArray['bookName'] = $changeModel->bookNameCheck($_POST['bookName'], $errorArray);
				// 著者名のバリデート
				$errorArray['acthorName'] = $changeModel->acthorNameCheck($_POST['acthorName'], $errorArray);
				// 出版社のバリデート
				$errorArray['pubisher'] = $changeModel->pubisherCheck($_POST['pubisher'], $errorArray);
				// 出版年のバリデート
				$errorArray['publicationYear'] = $changeModel->publicationYearCheck($_POST['publicationYear'], $errorArray);
				// ISBNの半角化
				$_POST['isbn'] = $function->convert($_POST['isbn'], "n", "UTF-8");
				// ISBNのバリデート
				$errorArray['isbn'] = $changeModel->isbnCheck($_POST['isbn'], $errorArray);
				// 分類のバリデート
				$errorArray['category'] = $changeModel->categoryCheck($_POST['category'], $errorArray);
				// コメントのバリデート
				$errorArray['comment'] = $changeModel->commentCheck($_POST['comment'], $errorArray);
				
				// 入力エラーの確認
				if ($errorArray['bookName']['flg'] && $errorArray['acthorName']['flg'] && $errorArray['pubisher']['flg'] && 
					$errorArray['publicationYear']['flg'] && $errorArray['isbn']['flg'] && $errorArray['category']['flg'] && $errorArray['comment']['flg']) {
					// 入力エラーがなかった場合
					$result = $masterBooksDb->update($_SESSION['bookInfo']['id'], $_POST['bookName'], $_POST['acthorName'], $_POST['pubisher'], $_POST['publicationYear'], $_POST['isbn'], $_POST['category'], $_POST['comment']);
					// 結果判別
					if ($result) {
						$message = "成功";
					} else {
						$message = "失敗";
					}
					// 結果出力
					$resultView->display($message);
				} else {
					// 入力エラーがあった場合
					// 再び入力画面へ
					$bookInfoView->display($errorArray, $category);
				}
			}
			// 削除か確認
			if (!empty($_POST['delete'])) {
				// 削除だった場合
				// 状態を削除予定に変更
				$result = $bookStatusDb->update($_SESSION['bookInfo']['id'], 3);
				// 結果判別
				if ($result) {
					$message = "成功";
				} else {
					$message = "失敗";
				}
				// 結果出力
				$resultView->display($message);
			}
			break;
		defalut:
			break;
	}
}
// フッター出力
$footerView->display();
