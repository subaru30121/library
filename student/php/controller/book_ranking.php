<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<?php

// 蔵書ランキング

require_once(getcwd(). '/../view/result_view.php');
require_once(getcwd(). '/../view/header_view.php');
require_once(getcwd(). '/../view/footer_view.php');
require_once(getcwd(). '/../view/book_ranking_view.php');
require_once(getcwd(). '/../config/common_function.php');
require_once(getcwd(). '/../config/log_db.php');
require_once(getcwd(). '/../config/master_books_db.php');

$resultView = new resultView();
$headerView = new headerView();
$footerView = new footerView();
$bookRankingView = new bookRankingView();
$commonFunction = new commonFunction();
$logDb = new logDb();
$masterBooksDb = new masterBooksDb();

// タイトル設定
$title = "蔵書ランキング - 情報科学専門学校図書室管理サイト";
// うさぎ関連
$rabbitFlg = $commonFunction->rabbitBorn();
// ヘッダー出力
$headerView->display($title, $rabbitFlg);

// logDb参照でランキング上位を抽出
$data = $logDb->ranking();
if (!empty($data)) {
	// 蔵書情報の問い合わせ
	for ($rankingNumber = 1; $rankingNumber <= RANKING_NUMBER; $rankingNumber++) {
		if (empty($data[$rankingNumber])) {
			// 途中でレコードが無くなった場合
			break;
		}
		$ranking[$rankingNumber] = $masterBooksDb->selectOne($data[$rankingNumber]['bookId']);
	}
	// 画面表示
	$bookRankingView->display($ranking);
} else {
	// ログがない場合
	$message = "ただいま稼働準備中です。\n";
	$message .= "しばらくお待ちください。\n";
	$resultView->display($message);
}

// フッター出力
$footerView->display();
