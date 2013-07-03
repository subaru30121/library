<?php

require_once(getcwd(). '/../../php/config/database.php');

class requestDb extends database {
	
	// 新規追加
	function add($studentId = null, $class = null, $studentName = null,  $bookName = null, $isbn = null) {
		// 引数のチェック
		if (is_null($studentId) || is_null($class) || is_null($studentName) || is_null($bookName) || is_null($isbn)) {
			// 入っていなければ終了
			return false;
		}
		// DB接続
		$link = $this->connectDb();
		// 結果の初期化
		$result = array();
		// 日付の設定
		$requestDay = date('Y-m-d');
		
		// SQL構築
		$sql = "INSERT INTO request (studentId, class, studentName, bookName, isbn, requestDay, flg, created) ";
		$sql .= "VALUES (:studentId, :class, :studentName, :bookName, :isbn, :requestDay, true, null)";
		
		// プリペアドステートメント
		$stmt = $link->prepare($sql);
		$stmt->bindParam(':studentId', $studentId, PDO::PARAM_STR);
		$stmt->bindParam(':class', $class, PDO::PARAM_STR);
		$stmt->bindParam(':studentName', $studentName, PDO::PARAM_STR);
		$stmt->bindParam(':bookName', $bookName, PDO::PARAM_STR);
		$stmt->bindParam(':isbn', $isbn, PDO::PARAM_STR);
		$stmt->bindParam(':requestDay', $requestDay);
		// 実行
		$result['flg'] = $stmt->execute();
		
		// DB接続切断
		$link = null;
		
		return $result['flg'];
	}
}
