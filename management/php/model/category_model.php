<?php

require_once(getcwd(). '/../config/category_db.php');

class categoryModel {
	
	//クラス定義
	var $categoryDb;

	// 分類番号のチェック(add)
	function categoryIdAddCheck($categoryId = null, $errorArray = null) {
		// 引数の確認
		if (!isset($categoryId) || !isset($errorArray)) {
			// 全て入っていない場合
			return false;
		}
		
		// DB定義
		$this->categoryDb = new categoryDb();
		// エラーメッセージの初期化
		$errorArray['categoryId']['message'] = null;
		// フラグの初期化
		$errorArray['categoryId']['flg'] = false;
		$flg = array();
		
		// 入力されているか確認
		if (!empty($categoryId)) {
			// 入力されている場合
			// 数字2桁のみか確認
			if (preg_match("/^[0-9]{2}$/", $categoryId)) {
				// 数字2桁のみだった場合
				$flg['num'] = true;
			} else {
				// それ以外を使用していた場合
				$errorArray['categoryId']['message'] .= "半角数字2桁で入力してください\n";
				$flg['num'] = false;
			}
			// その番号が重複していないか確認
			$category = $this->categoryDb->select();
			$flg['double'] = true;
			// 全ての分類を比較
			foreach($category as $content) {
				if ($content['categoryId'] == $categoryId) {
					$flg['double'] = false;
					$errorArray['categoryId']['message'] .= "その分類番号は使用済みです\n";
					break;
				}
			}
			// エラー確認
			if ($flg['num'] && $flg['double']) {
				//エラーがない場合
				$errorArray['categoryId']['flg'] = true;
			}
		} else {
			// 入力されていない場合
			$errorArray['categoryId']['message'] .= "入力してください\n";
		}
		return $errorArray['categoryId'];
	}
	
	// 分類番号のチェック(change)
	function categoryIdChangeCheck($categoryId = null, $errorArray = null) {
		// 引数の確認
		if (!isset($categoryId) || !isset($errorArray)) {
			// 全て入っていない場合
			return false;
		}
		
		// DB定義
		$this->categoryDb = new categoryDb();
		// エラーメッセージの初期化
		$errorArray['categoryId']['message'] = null;
		// フラグの初期化
		$errorArray['categoryId']['flg'] = false;
		$flg = array();
		
		// 入力されているか確認
		if (!empty($categoryId)) {
			// 入力されている場合
			// 数字2桁のみか確認
			if (preg_match("/^[0-9]{2}$/", $categoryId)) {
				// 数字2桁のみだった場合
				$flg['num'] = true;
			} else {
				// それ以外を使用していた場合
				$errorArray['categoryId']['message'] .= "半角数字2桁で入力してください\n";
				$flg['num'] = false;
			}
			// その番号が存在しているか確認
			$category = $this->categoryDb->select();
			$flg['double'] = false;
			// 全ての分類を比較
			foreach($category as $content) {
				if ($content['categoryId'] == $categoryId) {
					// 存在している場合
					$flg['double'] = true;
					break;
				}
			}
			
			if (!$flg['double']) {
				// 存在していない場合
				$errorArray['categoryId']['message'] .= "その分類番号は存在しません\n";
			}
			
			// エラー確認
			if ($flg['num'] && $flg['double']) {
				//エラーがない場合
				$errorArray['categoryId']['flg'] = true;
			}
		} else {
			// 入力されていない場合
			$errorArray['categoryId']['message'] .= "入力してください\n";
		}
		return $errorArray['categoryId'];
	}
	
	// 分類名のチェック
	function categoryNameCheck($categoryName = null, $errorArray = null) {
		// 引数の確認
		if (!isset($categoryName) || !isset($errorArray)) {
			// 全て入っていない場合
			return false;
		}
		
		// エラーメッセージの初期化
		$errorArray['categoryName']['message'] = null;
		// フラグの初期化
		$errorArray['categoryName']['flg'] = false;
		
		// 入力されているか確認
		if (!empty($categoryName)) {
			// 入力されている場合
			// 文字数取得
			$categoryNameNum = mb_strlen($categoryName, 'UTF-8');
			// 文字数確認
			if ($categoryNameNum <= 50) {
				// 数字2桁のみだった場合
				$errorArray['categoryName']['flg'] = true;
			} else {
				// それ以外を使用していた場合
				$errorArray['categoryName']['message'] .= "50文字以内です\n";
			}
		} else {
			// 入力されていない場合
			$errorArray['categoryName']['message'] .= "入力してください\n";
		}
		
		return $errorArray['categoryName'];
	}
}
