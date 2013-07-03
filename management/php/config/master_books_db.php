<?php

require_once(getcwd(). '/../config/database.php');
require_once(getcwd(). '/../config/constant.php');

class masterBooksDb extends database {
	
	// 新規追加
	function add($bookName = null, $acthorName = null, $pubisher = null, $publicationYear = null, $isbn = null, $category = null, $comment = null) {
		// 引数のチェック
		if (!isset($bookName) || !isset($acthorName) || !isset($pubisher) || !isset($publicationYear) || !isset($isbn) || !isset($category) || !isset($comment)) {
			// 入っていなければ終了
			return false;
		}
		// DB接続
		$link = $this->connectDb();
		// 結果の初期化
		$result = array();
		
		// SQL構築
		$sql = "INSERT INTO master_books (bookName, acthor, pubisher, publicationYear, isbn, category, comment, created) ";
		$sql .= "VALUES (:bookName, :acthor, :pubisher, :publicationYear, :isbn, :category, :comment, :created)";
		
		// プリペアドステートメント
		$stmt = $link->prepare($sql);
		$stmt->bindParam(':bookName', $bookName, PDO::PARAM_STR);
		$stmt->bindParam(':acthor', $acthorName, PDO::PARAM_STR);
		$stmt->bindParam(':pubisher', $pubisher, PDO::PARAM_INT);
		$stmt->bindParam(':publicationYear', $publicationYear, PDO::PARAM_INT);
		$stmt->bindParam(':isbn', $isbn, PDO::PARAM_STR);
		$stmt->bindParam(':category', $category, PDO::PARAM_STR);
		$stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
		$stmt->bindParam(':created', $created);
		// 作成日時
		$created = null;
		// 実行
		$result['flg'] = $stmt->execute();
		
		if ($result['flg']) {
			// 成功した場合
			// IDの取り出し
			$result['id'] = $link->lastInsertId();
		}
		
		// DB接続切断
		$link = null;
		
		return $result;
	}
	
	// ID検索
	function selectOne($bookId = null) {
		// 引数のチェック
		if (!isset($bookId)) {
			// 入っていない場合
			return false;
		}
		
		// 結果初期化
		$result = array();
		
		// DB接続
		$link = $this->connectDb();
		
		// SQL構築
		$sql = "SELECT id, bookName, acthor, pubisher, publicationYear, isbn, category, comment ";
		$sql .= "FROM master_books ";
		$sql .= "WHERE id = :bookId";
		// プリペアドステートメント
		$stmt = $link->prepare($sql);
		$stmt->bindParam(':bookId', $bookId, PDO::PARAM_INT);
		// 実行
		if ($stmt->execute()) {
			// 見つかった場合
			$result['flg'] = true;
			// 結果を保存
			// 値を取得
			if ($record = $stmt->fetch()) {
				$result['id'] = $record['id'];
				$result['bookName'] = $record['bookName'];
				$result['acthorName'] = $record['acthor'];
				$result['pubisher'] = $record['pubisher'];
				$result['publicationYear'] = $record['publicationYear'];
				$result['isbn'] = $record['isbn'];
				$result['category'] = $record['category'];
				$result['comment'] = $record['comment'];
			} else {
				// 見つからない場合
				$result['flg'] = false;
				$result['message'] = "見つかりませんでした<br>\n";
			}
		} else {
			// 実行に失敗した場合
			$result['flg'] = false;
			$result['message'] = "異常な状態になったため動作を終了しました<br>\n";
		}
		
		// DB接続切断
		$link = null;
		
		return $result;
	}
	
	// データ更新
	function update($id = null, $bookName = null, $acthorName = null, $pubisher = null, $publicationYear = null, $isbn = null, $category = null, $comment = null) {
		// 引数のチェック
		if (!isset($id) || !isset($bookName) || !isset($acthorName) || !isset($pubisher) || !isset($publicationYear) || !isset($isbn) || !isset($category) || !isset($comment)) {
			// 入っていなければ終了
			return false;
		}
		// DB接続
		$link = $this->connectDb();
		
		// SQL構築
		$sql = "UPDATE master_books SET ";
		$sql .= "bookName = :bookName, ";
		$sql .= "acthor = :acthor, ";
		$sql .= "pubisher = :pubisher, ";
		$sql .= "publicationYear = :publicationYear, ";
		$sql .= "isbn = :isbn, ";
		$sql .= "category = :category, ";
		$sql .= "comment = :comment ";
		$sql .= "WHERE id = :bookId";
		
		// プリペアドステートメント
		$stmt = $link->prepare($sql);
		$stmt->bindParam(':bookName', $bookName, PDO::PARAM_STR);
		$stmt->bindParam(':acthor', $acthorName, PDO::PARAM_STR);
		$stmt->bindParam(':pubisher', $pubisher, PDO::PARAM_STR);
		$stmt->bindParam(':publicationYear', $publicationYear, PDO::PARAM_INT);
		$stmt->bindParam(':isbn', $isbn, PDO::PARAM_STR);
		$stmt->bindParam(':category', $category, PDO::PARAM_STR);
		$stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
		$stmt->bindParam(':bookId', $id, PDO::PARAM_INT);
		
		// 実行
		$result = $stmt->execute();
		
		// DB接続切断
		$link = null;
		
		return $result;
	}
	
	// 蔵書件数の取り出し
	function count($conditions) {
		// 引数の確認
		if (is_null($conditions)) {
			// ない場合
			return false;
		}
		
		// 検索条件の確認
		// フラグの初期化
		$flg = array();
		// 蔵書名の確認
		if (!empty($conditions['bookName'])) {
			// 蔵書名がある場合
			$flg['bookName'] = true;
		} else {
			// 蔵書名がない場合
			$flg['bookName'] = false;
		}
		// 著者名の確認
		if (!empty($conditions['acthorName'])) {
			// 著者名がある場合
			$flg['acthorName'] = true;
		} else {
			// 著者名がない場合
			$flg['acthorName'] = false;
		}
		// 出版年の確認
		if (!empty($conditions['publicationYear'])) {
			// 出版年がある場合
			$flg['publicationYear'] = true;
		} else {
			// 出版年がない場合
			$flg['publicationYear'] = false;
		}
		// 分類の確認
		if (!empty($conditions['category'])) {
			// 分類名がある場合
			$flg['category'] = true;
		} else {
			// 分類名がない場合
			$flg['category'] = false;
		}
		
		// DB接続
		$link = $this->connectDb();
		
		// SQL構築(複雑になるけど許して)
		$sql = "SELECT count(*) FROM master_books as master, book_status as status";
		// 検索条件があるか確認
		if ($flg['bookName'] || $flg['acthorName'] || $flg['publicationYear'] || $flg['category']) {
			// 何かしらある場合
			$sql .= " WHERE ";
			// SQL文構築
			// 蔵書名がある場合
			if ($flg['bookName']) {
				$sql .= "bookName LIKE \"%:bookName%\" and ";
			}
			// 著者名がある場合
			if ($flg['acthorName']) {
				$sql .= "acthor LIKE \"%:acthorName%\" and ";
			}
			// 出版年がある場合
			if ($flg['publicationYear']) {
				$sql .= "publicationYear >= :publicationYear and ";
			}
			// 分類がある場合
			if ($flg['category']) {
				$sql .= "category = :category and ";
			}
			// ステータスを見て破棄済みを除外
			$sql .= "master.id = status.id ";
			$sql .= "status.status <> '4'";
			
			// プリペアドステートメント
			$stmt = $link->prepare($sql);
			// 検索条件をバインド
			// 蔵書名がある場合
			if ($flg['bookName']) {
				$stmt->bindParam(":bookName", $conditions['bookName'], PDO::PARAM_STR);
			}
			// 著者名がある場合
			if ($flg['acthorName']) {
				$stmt->bindParam(":acthorName", $conditions['acthorName'], PDO::PARAM_STR);
			}
			// 出版年がある場合
			if ($flg['publicationYear']) {
				$stmt->bindParam(":publicationYear", $conditions['publicationYear'], PDO::PARAM_INT);
			}
			// 分類がある場合
			if ($flg['category']) {
				$stmt->bindParam(":category", $conditions['category'], PDO::PARAM_STR);
			}
			// 実行
			$stmt->execute();
			// 結果を保存
			while ($record = $stmt->fetch()) {
				$result['count'] = $record[0];
			}
		} else {
			// 検索条件がない場合
			// 実行
			foreach ($link->query($sql) as $record) {
				// 結果取得
				$result['count'] = $record[0];
			}
		}
		
		// DB接続切断
		$link = null;
		
		return $result;
	}
}
