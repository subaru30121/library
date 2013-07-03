<?php

require_once(getcwd(). '/../config/common_function.php');

class isbnModel {
	// クラス変数定義
	var $function;
	
	// ISBNのチェック
	function isbnCheck($isbn = null) {
		// 引数の確認
		if (is_null($isbn)) {
			// 入っていなければ終了
			return false;
		}
		
		// クラス定義
		$this->function = new commonFunction();
		// エラーの初期化
		$errorArray = array();
		// エラーメッセージの初期化
		$errorArray['isbn']['message'] = null;
		// ISBNの初期化
		$errorArray['isbn']['info'] = array();
		// フラグの初期化
		$errorArray['isbn']['flg'] = false;
		$numberFlg = false;
		
		// 入力されているか確認
		if (!empty($isbn)) {
			// 入力されている場合
			if (preg_match("/^[0-9]{13}$/", $isbn)) {
				// 数字13桁の場合
				$numberFlg = true;
			} else {
				// 指定だった場合
				$errorArray['isbn']['message'] .= "13桁にしてください\n";
			}
			if ($numberFlg) {
				// ISBNコードだった場合
				// 存在するか確認
				$isbnInfo = $this->function->isbn($isbn);
				if ($isbnInfo['flg']) {
					$errorArray['isbn']['flg'] = true;
					$errorArray['isbn']['info'] = $isbnInfo;
				} else {
					// 存在しない場合
					$errorArray['isbn']['message'] = "ISBNコードが存在しません\n";
				}
			}
		} else {
			// 入力されていない場合
			$errorArray['isbn']['flg'] = true;
		}
		
		return $errorArray['isbn'];
	}
}

