<?php

class studentModel {
	
	// ユーザ名のバリデート
	function userNameCheck($userName = null) {
	
		// 引数の確認
		if (is_null($userName)) {
			// 入っていなければ終了
			return false;
		}
		
		// エラーの初期化
		$errorArray = array();
		// エラーメッセージの初期化
		$errorArray['userName']['message'] = null;
		// フラグの初期化
		$errorArray['userName']['flg'] = false;
		// 入力されているか確認
		if (!empty($userName)) {
			// 入力されている場合
			// 文字数取得
			$userNameNum = mb_strlen($userName, 'UTF-8');
			// 文字数確認
			if ($userNameNum == 8) {
				// 上限を超えていない場合
				$errorArray['userName']['flg'] = true;
			} else {
				// 上限を超えていた場合
				$errorArray['userName']['message'] .= "文字数が間違ってます\n";
			}
		} else {
			// 入力されていない場合
			$errorArray['userName']['message'] .= "入力してください\n";
		}
		
		return $errorArray['userName'];
	}
	
	// パスワードのバリデート
	function passwordCheck($password = null) {
		
		// 引数の確認
		if (is_null($password)) {
			// 入っていなければ終了
			return false;
		}
		
		// エラーの初期化
		$errorArray = array();
		// エラーメッセージの初期化
		$errorArray['password']['message'] = null;
		// フラグの初期化
		$errorArray['password']['flg'] = false;
		
		// 入力されているか確認
		if (!empty($password)) {
			// 入力されている場合
			$errorArray['password']['flg'] = true;
		} else {
			// 入力されていない場合
			$errorArray['password']['message'] = "入力してください\n";
		}
		
		return $errorArray['password'];
	}
}
