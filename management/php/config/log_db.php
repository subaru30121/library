<?php

require_once(getcwd(). '/../config/database.php');
require_once(getcwd(). '/../config/constant.php');

class logDb extends database {

	// 新規追加
	function add($bookId = null, $studentId = null) {
		// 引数のチェック
		if (!isset($bookId) || !isset($studentId)) {
			// 入っていない場合
			return false;
		}
		
		// DB接続
		$link = $this->connectDb();
		
		// SQL構築
		$sql = "INSERT INTO log (bookId, studentNumber, lendedDay, returnDay, status, created) ";
		$sql .= "VALUES (:bookId, :studentNumber, :lendedDay, :returnDay, '1', :created)";
		
		// プリペアドステートメント
		$stmt = $link->prepare($sql);
		$stmt->bindParam(':bookId', $bookId, PDO::PARAM_INT);
		$stmt->bindParam(':studentNumber', $studentId, PDO::PARAM_STR);
		$stmt->bindParam(':lendedDay', $lendedDay);
		$stmt->bindParam(':returnDay', $returnDay);
		$stmt->bindParam(':created', $created);
		// 貸出日
		$lendedDay = date("Y/m/d");
		// 返却予定日
		$returnDay = date("Y/m/d",strtotime("+2 week"));
		// 作成日時
		$created = null;
		// 実行
		$result = $stmt->execute();
		
		//DB接続切断
		$link = null;
		
		return $result;
	}
	
	// 削除
	function delete($bookId = null) {
		// 引数のチェック
		if (!isset($bookId)) {
			// 入っていない場合
			return false;
		}
		
		// DB接続
		$link = $this->connectDb();
		
		// SQL構築
		$sql = "UPDATE log SET ";
		$sql .= "status = '0' ";
		$sql .= "WHERE bookId = :id";
		// プリペアドステートメント
		$stmt = $link->prepare($sql);
		$stmt->bindParam(':id', $bookId, PDO::PARAM_INT);
		// 実行
		$result = $stmt->execute();
		
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
		$sql = "SELECT count(*) FROM log ";
		$sql .= "WHERE status <> '0'";
		
		// 実行
		foreach ($link->query($sql) as $record) {
			// 結果取得
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
		$sql = "SELECT master.id, master.bookName, log.studentNumber, log.lendedDay, log.returnDay ";
		$sql .= "FROM log as log, master_books as master ";
		$sql .= "WHERE log.bookId = master.id ";
		$sql .= "and log.status <> '0' ";
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
			$result[$num]['id'] = $record['id'];
			$result[$num]['bookName'] = $record['bookName'];
			$result[$num]['studentId'] = $record['studentNumber'];
			$result[$num]['lendedDay'] = $record['lendedDay'];
			$result[$num]['returnDay'] = $record['returnDay'];
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
		$sql = "SELECT bookId, studentNumber, lendedDay, returnDay ";
		$sql .= "FROM log ";
		$sql .= "WHERE bookId = :id and ";
		$sql .= "status <> '0'";
		// プリペアドステートメント
		$stmt = $link->prepare($sql);
		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		// 実行
		$stmt->execute();
		// 結果を保存
		while($record = $stmt->fetch()) {
			$result['id'] = $record['bookId'];
			$result['studentNumber'] = $record['studentNumber'];
			$result['lendedDay'] = $record['lendedDay'];
			$result['returnDay'] = $record['returnDay'];
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
