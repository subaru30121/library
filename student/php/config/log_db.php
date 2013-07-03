<?php

require_once(getcwd(). '/../config/database.php');
require_once(getcwd(). '/../config/constant.php');

class logDb extends database {
	
	// 上位を抽出
	function ranking() {
		
		// 結果初期化
		$result = array();
		// DB接続
		$link = $this->connectDb();
		
		// SQL構築
		$sql = "select bookId, count(bookId) from log group by bookId order by count(bookId) DESC limit 0, ". RANKING_NUMBER;
		
		// プリペアドステートメント
		$stmt = $link->prepare($sql);
		// 実行
		$stmt->execute();
		
		// 値を取得
		$num = 1;
		while ($record = $stmt->fetch()) {
			$result[$num]['bookId'] = $record['bookId'];
			$result[$num]['count'] = $record['count(bookId)'];
			$num++;
		}
		
		// DB接続切断
		$link = null;
		
		return $result;
	}
}
