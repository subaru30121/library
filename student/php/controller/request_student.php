<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<?php

require_once(getcwd(). '/../view/header_view.php');
require_once(getcwd(). '/../view/footer_view.php');
require_once(getcwd(). '/../view/request_student_view.php');
require_once(getcwd(). '/../model/student_model.php');
require_once(getcwd(). '/../config/common_function.php');

$headerView = new headerView();
$footerView = new footerView();
$requestStudentView = new requestStudentView();
$studentModel = new studentModel();
$commonFunction = new commonFunction();

// タイトル設定
$title = "購入依頼 - 情報科学専門学校図書室サイト";

// エラーの初期化
$errorArray = array();
// ログイン情報の初期化
$loginData = array();
// うさぎ関連
$rabbitFlg = $commonFunction->rabbitBorn();
if (empty($_POST)) {
	// 何も入力されていない場合
	// ヘッダー出力
	$headerView->display($title, $rabbitFlg);
	// 入力フォームを表示
	$requestStudentView->display($errorArray, $loginData);
} else {
	// 何か入力されてる場合
	// 入力チェック
	// 学籍番号のバリデート
	$errorArray['userName'] = $studentModel->userNameCheck($_POST['userName']);
	// パスワードのバリデート
	$errorArray['password'] = $studentModel->passwordCheck($_POST['password']);
	// ログイン判定の初期化
	$loginData['flg'] = false;
	// エラー判定
	if ($errorArray['userName']['flg'] && $errorArray['password']['flg']) {
		// 正常な値の場合
		// ログイン処理
		$loginData = $commonFunction->login($_POST['userName'], $_POST['password']);
		if (!$loginData['flg']) {
			// ログイン失敗時のメッセージ
			$loginData['errorMessage'] = "ユーザ名またはパスワードが違います\n";
		}
	}
	// ログイン判定
	if ($loginData['flg']) {
		// ログイン成功の場合
		// セッションにログイン情報をセット
		session_start();
		$_SESSION['loginData'] = $loginData;
		// ISBN入力にリダイレクト
		header('Location:request_isbn.php');
	} else {
		// ログイン失敗の場合
		// ヘッダー出力
		$headerView->display($title, $rabbitFlg);
		// 入力フォームを再表示
		$requestStudentView->display($errorArray, $loginData);
	}
}

// フッター出力
$footerView->display();
