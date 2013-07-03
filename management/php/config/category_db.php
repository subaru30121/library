<?php

require_once(getcwd(). '/../config/database.php');

class categoryDb extends database {
	
	// 新規追加
	function add($categoryId = null, $categoryName = null) {
		// 引数のチェック
		if (!isset($categoryId) || !isset($categoryName)) {
			// 全てが入っていない場合
			return false;
		}
		
		// DB接続
		$link = $this->connectDb();
		
		// SQL構築
		$sql = "INSERT INTO category (categoryId, categoryName, created) ";
		$sql .= "VALUES (:categoryId, :categoryName, :created)";
		
		// プリペアドステートメント
		$stmt = $link->prepare($sql);
		$stmt->bindParam(':categoryId', $categoryId, PDO::PARAM_INT);
		$stmt->bindParam(':categoryName', $categoryName, PDO::PARAM_STR);
		$stmt->bindParam(':created', $created);
		// 作成日時
		$created = null;
		// 実行
		$result = $stmt->execute();
		
		// DB接続切断
		$link = null;
		
		return $result;
	}
	
	// 全件取り出し
	function select() {
		
		// DB接続
		$link = $this->connectDb();
		// 結果初期化
		$category = array();
		
		// SQL構築
		$sql = "SELECT categoryId, categoryName ";
		$sql .= "FROM category";
		
		$stmt = $link->prepare($sql);
		// 実行
		$stmt->execute();
		$num = 1;
		// 結果を保存
		while($record = $stmt->fetch()) {
			$category[$num]['categoryId'] = $record['categoryId'];
			$category[$num]['categoryName'] = $record['categoryName'];
			$num++;
		}
		
		// DB接続切断
		$link = null;
		
		return $category;
	}
	
	// 1件取り出し
	function selectOne($categoryId = null) {
		// 引数チェック
		if (!isset($categoryId)) {
			// 入っていない場合
			return false;
		}
		// DB接続
		$link = $this->connectDb();
		// 結果初期化
		$category = array();
		
		// SQL構築
		$sql = "SELECT categoryId, categoryName ";
		$sql .= "FROM category ";
		$sql .= "WHERE categoryId = :categoryId";
		
		// プリペアドステートメント
		$stmt = $link->prepare($sql);
		$stmt->bindParam(':categoryId', $categoryId, PDO::PARAM_INT);
		// 実行
		$stmt->execute();
		// 結果を保存
		if ($record = $stmt->fetch()) {
			$category['categoryId'] = $record['categoryId'];
			$category['categoryName'] = $record['categoryName'];
		}
		
		// DB接続切断
		$link = null;
		
		return $category;
	}
	
	// 部分取り出し
	function selectPart($offset, $count) {
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
		$sql = "SELECT categoryId, categoryName ";
		$sql .= "FROM category ";
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
			$result[$num]['categoryId'] = $record['categoryId'];
			$result[$num]['categoryName'] = $record['categoryName'];
			$num++;
		}
		
		// DB接続切断
		$link = null;
		
		return $result;
	}
	
	// 件数表示
	function count() {
		
		// DB接続
		$link = $this->connectDb();
		
		// SQL構築
		$sql = "SELECT count(*) FROM category";
		
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
	
	// 変更
	function update($categoryId = null, $categoryName = null) {
		// 引数チェック
		if (!isset($categoryId) || !isset($categoryName)) {
			// 入っていない場合
			return false;
		}
		
		// DB接続
		$link = $this->connectDb();
		
		// SQL構築
		$sql = "UPDATE category SET ";
		$sql .= "categoryName = :categoryName ";
		$sql .= "WHERE categoryId = :categoryId";
		// プリペアドステートメント
		$stmt = $link->prepare($sql);
		$stmt->bindParam(':categoryName', $categoryName, PDO::PARAM_STR);
		$stmt->bindparam(':categoryId', $categoryId, PDO::PARAM_INT);
		// 実行
		$result = $stmt->execute();
		
		// DB接続切断
		$link = null;
		
		return $result;
	}
	
	// 削除
	function delete($categoryId = null) {
		//引数チェック
		if (!isset($categoryId)) {
			// 入っていない場合
			return false;
		}
		
		// DB接続
		$link = $this->connectDb();
		
		// SQL構築
		$sql = "DELETE FROM category ";
		$sql .= "WHERE categoryId = :categoryId";
		// プリペアドステートメント
		$stmt = $link->prepare($sql);
		$stmt->bindParam(':categoryId', $categoryId, PDO::PARAM_INT);
		// 実行
		$result = $stmt->execute();
		
		// DB接続切断
		$link = null;
		
		return $result;
	}
}
