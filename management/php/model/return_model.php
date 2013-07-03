﻿<?php

require_once(getcwd(). '/../config/common_function.php');
require_once(getcwd(). '/../config/master_books_db.php');
require_once(getcwd(). '/../config/book_status_db.php');

class returnModel {

	// クラス定義
	var $function;
	var $masterBooksDb;
	var $bookStatusDb;
	
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
		$flg['num'] = false;
		$flg['double'] = false;
		$flg['lended'] = false;
		// 関数の定義
		$this->function = new commonFunction;
		$this->masterBooksDb = new masterBooksDb();
		$this->bookStatusDb = new bookStatusDb();
		// 入力されているか確認
		if (!empty($bookId)) {
			// 入力されている場合
			// 数字のみか確認
			if ($this->function->numberCheck($bookId)) {
				// 数字のみだった場合
				$flg['num'] = true;
			} else {
				// 数字以外を使用していた場合
				$errorArray['bookId']['message'] .= "半角数字を使用してください\n";
			}
			
			// 数字のみか確認
			if ($flg['num']) {
				// 数字のみだった場合
				// その番号が存在しているか確認
				$book = array();
				$book = $this->masterBooksDb->selectOne($bookId);
				if ($book['flg']) {
					$flg['double'] = true;
				} else {
					// 存在していない場合
					$errorArray['bookId']['message'] .= "蔵書番号が存在しません\n";
				}
			}
			
			// 数字のみで存在している番号か確認
			if ($flg['double']) {
				// 数字のみで存在している番号だった場合
				// 貸出中か確認
				// 結果の初期化
				$result = array();
				$result = $this->bookStatusDb->selectOne($bookId, $result);
				// 貸出中か比較
				if ($result['bookStatus'] == LENDED) {
					// 貸出中ではない場合
					$flg['lended'] = true;
				} else {
					// 貸出中の場合
					$errorArray['bookId']['message'] .= "貸出中ではありません\n";
				}
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


