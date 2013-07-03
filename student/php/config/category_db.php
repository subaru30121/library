<?php

require_once(getcwd(). '/../../php/config/database.php');

class categoryDb extends database {
	
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
		$stmt->bindParam(':categoryId', $categoryId);
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
}
