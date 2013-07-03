<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<?php

// 蔵書の新規追加機能
require_once(getcwd(). '/../config/master_books_db.php');
require_once(getcwd(). '/../config/book_status_db.php');
require_once(getcwd(). '/../config/category_db.php');
require_once(getcwd(). '/../config/constant.php');
require_once(getcwd(). '/../config/common_function.php');
require_once(getcwd(). '/../view/input_view.php');
require_once(getcwd(). '/../model/input_model.php');
require_once(getcwd(). '/../view/isbn_view.php');
require_once(getcwd(). '/../view/result_view.php');
require_once(getcwd(). '/../view/header_view.php');
require_once(getcwd(). '/../view/footer_view.php');

$masterBooksDb = new masterBooksDb();
$bookStatusDb = new bookStatusDb();
$categoryDb = new categoryDb();
$function = new commonFunction();
$inputView = new inputView();
$inputModel = new inputModel();
$isbnView = new isbnView();
$resultView = new resultView();
$headerView = new headerView();
$footerView = new footerView();

// 分類の取り出し
$category = $categoryDb->select();

// タイトル設定
$title = "蔵書追加 - 情報科学専門学校図書室管理サイト";
// クラス指定
$class = "bookInput";
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
	$isbnView->display($errorArray);
} else {
	// パラメータを渡された場合
	$status = $_REQUEST['status'];
	// パラメータによって処理を変更
	switch($status) {
		case FIRST_STAGE:
			// 入力チェック
			// エラーの初期化
			$errorArray = array();
			// ISBNの半角化
			$_POST['isbn'] = $function->convert($_POST['isbn'], "n", "UTF-8");
			// ISBNのバリデート
			$errorArray['isbn'] = $inputModel->isbnCheck($_POST['isbn'], $errorArray);
			
			// 入力エラーの確認
			if ($errorArray['isbn']['flg']) {
				// セッション開始
				session_start();
				// ISBN情報の保存
				$_SESSION['isbn'] = $_POST['isbn'];
				$inputView->display($errorArray, $category);
			} else {
				// 再び入力画面
				$isbnView->display($errorArray);
			}
			break;
		case SECOND_STAGE:
			// 入力チェック
			// エラーの初期化
			$errorArray = array();
			// 蔵書名のバリデート
			$errorArray['bookName'] = $inputModel->bookNameCheck($_POST['bookName'], $errorArray);
			// 著者名のバリデート
			$errorArray['acthorName'] = $inputModel->acthorNameCheck($_POST['acthorName'], $errorArray);
			// 出版社のバリデート
			$errorArray['pubisher'] = $inputModel->pubisherCheck($_POST['pubisher'], $errorArray);
			// 出版年のバリデート
			$errorArray['publicationYear'] = $inputModel->publicationYearCheck($_POST['publicationYear'], $errorArray);
			// 分類のバリデート
			$errorArray['category'] = $inputModel->categoryCheck($_POST['category'], $errorArray);
			// コメントのバリデート
			$errorArray['comment'] = $inputModel->commentCheck($_POST['comment'], $errorArray);
			
			// 入力エラーの確認
			if ($errorArray['bookName']['flg'] && $errorArray['acthorName']['flg'] && $errorArray['pubisher']['flg'] && 
				$errorArray['publicationYear']['flg'] && $errorArray['category']['flg'] && $errorArray['comment']['flg']) {
				// 入力エラーがなかった場合
				
				// 結果の初期化
				$result = false;
				$outcome = array();
				// セッション開始
				session_start();
				// マスターDBの書き込み(フラグ, ID)
				$outcome = $masterBooksDb->add($_POST['bookName'], $_POST['acthorName'], $_POST['pubisher'], $_POST['publicationYear'], $_SESSION['isbn'], $_POST['category'], $_POST['comment']);
				if ($outcome['flg']) {
					// 書き込みに成功した場合
					// 状態DBの書き込み
					$result = $bookStatusDb->add($outcome['id'], POSSIBLE);
				}
				
				// 結果判別
				if ($result) {
					// DBの書き込みに成功した場合
					$message = "OK\n";
					$message .= "蔵書番号は". $outcome['id']. "番です";
				} else {
					$message = "失敗";
				}
				// 結果出力
				$resultView->display($message);
			} else {
				// 入力エラーがあった場合
				// 再び入力画面へ
				$inputView->display($errorArray, $category);
			}
			break;
		default:
			break;
	}
}

// フッター出力
$footerView->display();
