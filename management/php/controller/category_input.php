<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<?php

// 分類の新規追加
require_once(getcwd(). '/../view/category_view.php');
require_once(getcwd(). '/../view/result_view.php');
require_once(getcwd(). '/../view/header_view.php');
require_once(getcwd(). '/../view/footer_view.php');
require_once(getcwd(). '/../model/category_model.php');
require_once(getcwd(). '/../config/category_db.php');
require_once(getcwd(). '/../config/constant.php');
require_once(getcwd(). '/../config/common_function.php');

$categoryView = new categoryView();
$resultView = new resultView();
$headerView = new headerView();
$footerView = new footerView();
$categoryModel = new categoryModel();
$categoryDb = new categoryDb();
$function = new commonFunction();

// タイトル設定
$title = "分類追加 - 情報科学専門学校図書室管理サイト";
// クラス指定
$class = "categoryInput";
// ヘッダー出力
$headerView->display($title, $class);

// データを送信しているか
if (isset($_POST['categoryId']) || isset($_POST['categoryName'])) {
	// 送信されてきた場合
//追加分
//var_dump($_POST);
	// エラーの初期化
	$errorArray = array();
	// 蔵書IDの半角化
	$_POST['categoryId'] = $function->convert($_POST['categoryId'],'n',"UTF-8");
	// 分類番号のバリデート
	$errorArray['categoryId'] = $categoryModel->categoryIdAddCheck($_POST['categoryId'], $errorArray);
	// 分類名のバリデート
	$errorArray['categoryName'] = $categoryModel->categoryNameCheck($_POST['categoryName'], $errorArray);
	
	// 入力エラーの確認
	if ($errorArray['categoryId']['flg'] && $errorArray['categoryName']['flg']) {
		// 入力エラーがなかった場合
		// DBに登録
		$result = $categoryDb->add($_POST['categoryId'], $_POST['categoryName']);
		// 結果判定
		if ($result) {
			$message = "成功";
		} else {
			$message = "失敗";
		}
		// 結果表示
		$resultView->display($message);
	} else {
		// 入力エラーがあった場合
		// 再び入力画面へ
		$categoryView->display($errorArray);
	}
} else {
	// 送信されていない場合
	// エラーの初期化
	$errorArray = array();
	// 入力画面の表示
	$categoryView->display($errorArray);
}
// フッター出力
$footerView->display();
