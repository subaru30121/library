<?php

require_once(getcwd(). '/../config/common_function.php');
require_once(getcwd(). '/../model/input_model.php');
require_once(getcwd(). '/../config/master_books_db.php');
require_once(getcwd(). '/../config/log_db.php');

class changeModel extends inputModel {
	
	// クラス定義
	// functionはinputModelで定義済み
	var $masterBooksDb;
	var $logDb;

	// 蔵書IDのチェック
	function bookIdCheck($bookId = null, $errorArray = null) {
		// 引数の確認
		if (!isset($bookId) || !isset($errorArray)) {
			// 入ってなければ終了
			return false;
		}
		
		// エラーメッセージの初期化
		$errorArray['bookId']['message'] = null;
		// フラグの初期化
		$errorArray['bookId']['flg'] = false;
		$flg = array();
		// 関数の定義
		$this->function = new commonFunction;
		$this->masterBooksDb = new masterBooksDb();
		$this->logDb = new logDb();
		// 入力されているか確認
		if (!empty($bookId)) {
			// 入力されている場合
			// 数字のみか確認
			if ($this->function->numberCheck($bookId)) {
				// 数字のみだった場合
				$flg['num'] = true;
			} else {
				// 数字以外を使用していた場合
				$flg['num'] = false;
				$errorArray['bookId']['message'] .= "半角数字を使用してください\n";
			}
			// その番号が存在しているか確認
			$book = array();
			// 蔵書情報の取り出し
			$book = $this->masterBooksDb->selectOne($bookId);
			$flg['double'] = false;
			if ($book['flg']) {
				$flg['double'] = true;
			} else {
				// 存在していない場合
				$errorArray['bookId']['message'] .= "蔵書番号が存在しません\n";
			}
			
			// その蔵書が貸出中ではないか確認
			$book = array();
			// ログの取り出し
			$book = $this->logDb->selectOne($bookId);
			$flg['lended'] = false;
			if (!$book['flg']) {
				// ログに存在していない場合
				$flg['lended'] = true;
			} else {
				// 存在していない場合
				$errorArray['bookId']['message'] .= "その本は貸出中です\n";
			}
			
			// エラー確認
			if ($flg['num'] && $flg['double'] && $flg['lended']) {
				//エラーがない場合
				$errorArray['bookId']['flg'] = true;
			}
		} else {
			// 入力されていない場合
			$errorArray['bookId']['message'] .= "入力してください\n";
		}
		
		return $errorArray['bookId'];
	}
}
