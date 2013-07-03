<?php

require_once(getcwd(). '/../config/database.php');
require_once(getcwd(). '/../config/constant.php');

class bookStatusDb extends database {

	// 新規追加
	function add($id = null, $status = null) {
		// 引数のチェック
		if (!isset($id) || !isset($status)) {
			// 全て入ってなければ終了
			return false;
		}
		
		// DB接続
		$link = $this->connectDb();
		
		// SQL構築
		$sql = "INSERT INTO book_status (id, status, created) ";
		$sql .= "VALUES (:id, :status, :created)";
		
		// プリペアドステートメント
		$stmt = $link->prepare($sql);
		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		$stmt->bindParam(':status', $status, PDO::PARAM_INT);
		$stmt->bindparam(':created', $created);
		// 作成日時
		$created = null;
		// 実行
		$result = $stmt->execute();
		
		// DB接続切断
		$link = null;
		
		return $result;
	}
	
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
		while($record = $stmt->fetch()) {
			$result['bookStatus'] = $record['status'];
		}
		
		// DB接続切断
		$link = null;
		
		return $result;
	}
	
	// 状態変更
	function update($id = null, $status = null) {
		// 引数のチェック
		if (!isset($id) || !isset($status)) {
			// 入ってない場合
			return false;
		}
		
		// DB接続
		$link = $this->connectDb();
		
		// SQL構築
		$sql = "UPDATE book_status SET ";
		$sql .= "status = :status ";
		$sql .= "WHERE id = :id";
		// プリペアドステートメント
		$stmt = $link->prepare($sql);
		$stmt->bindParam(':status', $status, PDO::PARAM_INT);
		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		// 実行
		$result = $stmt->execute();
		
		// DB接続切断
		$link = null;
		
		return $result;
	}
	
	// 削除
	function delete($id = null) {
		// 引数のチェック
		if (!isset($id)) {
			// 入ってない場合
			return false;
		}
		
		// DB接続
		$link = $this->connectDb();
		
		// SQL構築
		$sql = "UPDATE book_status SET ";
		$sql .= "status = '4' ";
		$sql .= "WHERE id = :id";
		// プリペアドステートメント
		$stmt = $link->prepare($sql);
		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		// 実行
		$result = $stmt->execute();
		
		// DB接続切断
		$link = null;
		
		return $result;
	}
}
