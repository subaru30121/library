<?php

require_once(getcwd(). '/../config/database.php');
require_once(getcwd(). '/../config/constant.php');

class requestDb extends database {
	
	// ID削除
	function deleteId($bookId = null) {
		// 引数のチェック
		if (!isset($bookId)) {
			// 入っていない場合
			return false;
		}
		
		// DB接続
		$link = $this->connectDb();
		
		// SQL構築
		$sql = "UPDATE request SET ";
		$sql .= "flg = FALSE ";
		$sql .= "WHERE requestId = :id";
		
		// プリペアドステートメント
		$stmt = $link->prepare($sql);
		$stmt->bindParam(':id', $bookId, PDO::PARAM_INT);
		
		// 実行
		$result = $stmt->execute();
		
		//DB接続切断
		$link = null;
		
		return $result;
	}
	
	// ISBN削除
	function deleteIsbn($isbn = null) {
		// 引数のチェック
		if (!isset($isbn)) {
			// 入っていない場合
			return false;
		}
		
		// DB接続
		$link = $this->connectDb();
		
		// SQL構築
		$sql = "UPDATE request SET ";
		$sql .= "flg = FALSE ";
		$sql .= "WHERE isbn = :isbn";
		
		// プリペアドステートメント
		$stmt = $link->prepare($sql);
		$stmt->bindParam(':isbn', $isbn, PDO::PARAM_STR);
		
		// 実行
		$result = $stmt->execute();
		
		//DB接続切断
		$link = null;
		
		return $result;
	}
	
	// 件数表示
	function count() {
		
		// DB接続
		$link = $this->connectDb();
		
		// SQL構築
		$sql = "SELECT count(*) FROM request ";
		$sql .= "WHERE flg IS TRUE";
		
		// 実行
		foreach ($link->query($sql) as $record) {
			// 結果取得
			$count = $record[0];
		}
		// DB接続切断
		$link = null;
		
		// 配列になっているため件数のみ返す
		return $count;
	}
	
	// 件数表示(ISBN)
	function countIsbn($isbn = null) {
		
		// 引数のチェック
		if (!isset($isbn)) {
			// 入っていない場合
			return false;
		}
		
		// DB接続
		$link = $this->connectDb();
		
		// SQL構築
		$sql = "SELECT count(*) FROM request ";
		$sql .= "WHERE isbn = :isbn and ";
		$sql .= "flg IS TRUE";
		// プリペアドステートメント
		$stmt = $link->prepare($sql);
		$stmt->bindParam(':isbn', $isbn, PDO::PARAM_STR);
		// 実行
		$stmt->execute();
		// 結果を保存
		while ($record = $stmt->fetch()) {
			$count = $record[0];
		}
		// DB接続切断
		$link = null;
		
		return $count;
	}
	
	// 内容表示
	function select($offset, $count) {
		// 引数のチェック
		if (!isset($offset) || !isset($count)) {
			// 入っていない場合
			return false;
		}
		
		// 結果初期化
		$result = array();
		// DB接続
		$link = $this->connectDb();
		
		// SQL構築
		$sql = "SELECT requestId, studentName, bookName, requestDay ";
		$sql .= "FROM request ";
		$sql .= "WHERE flg IS TRUE ";
		$sql .= "ORDER BY requestId DESC ";
		$sql .= "limit :offset, ";
		$sql .= ":count";
		
		// プリペアドステートメント
		$stmt = $link->prepare($sql);
		$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
		$stmt->bindParam(':count', $count, PDO::PARAM_INT);
		// 実行
		$stmt->execute();
		
		// 値を取得
		$num = 1;
		while ($record = $stmt->fetch()) {
			$result[$num]['requestId'] = $record['requestId'];
			$result[$num]['studentName'] = $record['studentName'];
			$result[$num]['bookName'] = $record['bookName'];
			$result[$num]['requestDay'] = $record['requestDay'];
			$num++;
		}
		
		// DB接続切断
		$link = null;
		
		return $result;
	}
	
	// 1件取り出し
	function selectOne($id = null) {
		// 引数のチェック
		if (!isset($id)) {
			// 入ってない場合
			return false;
		}
		
		// 結果初期化
		$result = null;
		
		// DB接続
		$link = $this->connectDb();
		
		// SQL構築
		$sql = "SELECT requestId, studentId, class, studentName, bookName, isbn, requestDay ";
		$sql .= "FROM request ";
		$sql .= "WHERE requestId = :id";
		// プリペアドステートメント
		$stmt = $link->prepare($sql);
		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		// 実行
		$stmt->execute();
		// 結果を保存
		while($record = $stmt->fetch()) {
			$result['requestId'] = $record['requestId'];
			$result['studentId'] = $record['studentId'];
			$result['class'] = $record['class'];
			$result['studentName'] = $record['studentName'];
			$result['bookName'] = $record['bookName'];
			$result['isbn'] = $record['isbn'];
			$result['requestDay'] = $record['requestDay'];
		}
		
		// 存在していたか確認
		if (!empty($result)) {
			// 存在していた場合
			$result['flg'] = true;
		} else {
			// 存在しなかった場合
			$result['flg'] = false;
		}
		
		// DB接続切断
		$link = null;
		
		return $result;
	}
}
