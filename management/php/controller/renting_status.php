<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<?php

// 貸出中の蔵書の一覧

require_once(getcwd(). '/../config/log_db.php');
require_once(getcwd(). '/../view/renting_status_view.php');
require_once(getcwd(). '/../view/result_view.php');
require_once(getcwd(). '/../view/header_view.php');
require_once(getcwd(). '/../view/footer_view.php');
require_once(getcwd(). '/../config/constant.php');

$logDb = new logDb();
$rentingStatusView = new rentingStatusView();
$resultView = new resultView();
$headerView = new headerView();
$footerView = new footerView();

// タイトル設定
$title = "貸出状況 - 情報科学専門学校図書室管理サイト";
// クラス指定
$class = "renting";
// ヘッダー出力
$headerView->display($title, $class);

// 結果の初期化
$data = array();

// 全件数を取得
$data['total'] = $logDb->count();
// 冊数を確認
if ($data['total'] != "0") {
	// 借りられているものがある場合
	
	// ページ数計算
	$data['totalPage'] = ceil($data['total'] / PAGING_NUMBER);
	
	// 現在のページ数取り出し
	if (!empty($_GET['page'])) {
		// ページの指定がある場合
		if (preg_match('/^[1-9][0-9]*$/', $_GET['page'])) {
			// 数字だった場合
			if ($_GET['page'] <= $data['totalPage']) {
				// 正常なページ数だった場合
				$page = $_GET['page'];
			}
		}
	}
	if (empty($page)) {
		// $pageがまだ未定義の場合
		$page = 1;
	}
	$data['page'] = $page;
	
	// logテーブルから現在の貸出状況を取り出す
	// 取り出す情報を制限する
	$offset = PAGING_NUMBER * ($page - 1);
	$content = $logDb->select($offset, PAGING_NUMBER);
	
	// 表示件数
	$data['from'] = $offset + 1;
	$data['to'] = ($offset + PAGING_NUMBER) < $data['total'] ? ($offset + PAGING_NUMBER) : $data['total'];
	
	// 結果を表示
	$rentingStatusView->display($data, $content);
} else {
	// １冊も借りられていない場合
	$message = "現在、借りられている蔵書はありません\n";
	// 結果表示
	$resultView->display($message);
}

// フッター出力
$footerView->display();
