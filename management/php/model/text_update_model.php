<?php

class textUpdateModel {
	
	// お知らせのチェック
	function newCheck($new = null) {
		// 引数の確認
		if (!isset($new)) {
			// 入っていなければ終了
			return false;
		}
		// エラーの初期化
		$errorArray = array();
		// エラーメッセージの初期化
		$errorArray['new']['message'] = null;
		// フラグの初期化
		$errorArray['new']['flg'] = false;
		
		// 入力されているか確認
		if (!empty($new)) {
			// 入力されている場合
			// 文字数取得
			$newNum = mb_strlen($new, 'UTF-8');
			if ($newNum <= 500) {
				// 上限を超えていない場合 
					$errorArray['new']['flg'] = true;
			} else {
				// 上限を超えていた場合
				$errorArray['new']['message'] .= "文字数が多いです\n";
			}
		} else {
			// 入力されていない場合
			$errorArray['new']['message'] = "入力してください\n";
		}
		
		return $errorArray['new'];
	}
	
	// お勧めのチェック
	function suggestCheck($suggest = null) {
		// 引数の確認
		if (!isset($suggest)) {
			// 入っていなければ終了
			return false;
		}
		// エラーの初期化
		$errorArray = array();
		// エラーメッセージの初期化
		$errorArray['suggest']['message'] = null;
		// フラグの初期化
		$errorArray['suggest']['flg'] = false;
		
		// 入力されているか確認
		if (!empty($suggest)) {
			// 入力されている場合
			// 文字数取得
			$suggestNum = mb_strlen($suggest, 'UTF-8');
			if ($suggestNum <= 500) {
				// 上限を超えていない場合 
					$errorArray['suggest']['flg'] = true;
			} else {
				// 上限を超えていた場合
				$errorArray['suggest']['message'] .= "文字数が多いです\n";
			}
		} else {
			// 入力されていない場合
			$errorArray['suggest']['message'] = "入力してください\n";
		}
		
		return $errorArray['suggest'];
	}
}
