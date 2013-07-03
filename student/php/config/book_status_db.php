<?php

require_once(getcwd(). '/../../php/config/database.php');

class bookStatusDb extends database {
	
	// 状態の取り出し(ID検索)
	function selectOne($id = null, $result) {
		// 引数のチェック
		if (!isset($id) || !isset($result)) {
			// 入ってない場合
			return false;
		}
		
		// DB接続
		$link = $this->connectDb();
		
		// SQL構築
		$sql = "SELECT id, status ";
		$sql .= "FROM book_status ";
		$sql .= "WHERE id = :id";
		// プリペアドステートメント
		$stmt = $link->prepare($sql);
		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		// 実行
		$stmt->execute();
		// 結果を保存
		$result['bookStatus'] = null;
		while($record = $stmt->fetch()) {
			$result['bookStatus'] = $record['status'];
		}
		
		// DB接続切断
		$link = null;
		
		return $result;
	}
}
