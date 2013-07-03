<?php

require_once(getcwd(). '/../config/common_function.php');

class bookSearchModel {
	
	// クラス変数定義
	var $function;
	
	// 蔵書名のバリデート
	function bookNameCheck($bookName = null, $errorArray = null) {
	
		// 引数の確認
		if (!isset($bookName) || !isset($errorArray)) {
			// 入っていなければ終了
			return false;
		}
		
		// エラーメッセージの初期化
		$errorArray['bookName']['message'] = null;
		// フラグの初期化
		$errorArray['bookName']['flg'] = false;
		// 入力されているか確認
		if (!empty($bookName)) {
			// 入力されている場合
			// 文字数取得
			$bookNameNum = mb_strlen($bookName, 'UTF-8');
			// 文字数確認
			if ($bookNameNum <= 50) {
				// 上限を超えていない場合
				$errorArray['bookName']['flg'] = true;
			} else {
				// 上限を超えていた場合
				$errorArray['bookName']['message'] .= "文字数が多いです\n";
			}
		} else {
			// 入力されていない場合
			$errorArray['bookName']['flg'] = true;
		}
		
		return $errorArray['bookName'];
	}
	
	// 著者名のバリデート
	function acthorNameCheck($acthorName = null, $errorArray = null) {
		
		// 引数の確認
		if (!isset($acthorName) || !isset($errorArray)) {
			// 入っていなければ終了
			return false;
		}
		
		// エラーメッセージの初期化
		$errorArray['acthorName']['message'] = null;
		// フラグの初期化
		$errorArray['acthorName']['flg'] = false;
		
		// 入力されているか確認
		if (!empty($acthorName)) {
			// 入力されている場合
			// 文字数取得
			$acthorNameNum = mb_strlen($acthorName, 'UTF-8');
			if ($acthorNameNum <= 50) {
				// 上限を超えていない場合 
				$errorArray['acthorName']['flg'] = true;
			} else {
				// 上限を超えていた場合
				$errorArray['acthorName']['message'] .= "文字数が多いです\n";
			}
		} else {
			// 入力されていない場合
			$errorArray['acthorName']['flg'] = true;
		}
		
		return $errorArray['acthorName'];
	}
	
	// 出版年のチェック
	function publicationYearCheck($publicationYear = null, $errorArray = null) {
		// 引数の確認
		if (!isset($publicationYear) || !isset($errorArray)) {
			// 入っていなければ終了
			return false;
		}
		
		// クラス定義
		$this->function = new commonFunction();
		// エラーメッセージの初期化
		$errorArray['publicationYear']['message'] = null;
		// フラグの初期化
		$errorArray['publicationYear']['flg'] = false;
		
		// 入力されているか確認
		if (!empty($publicationYear)) {
			// 入力されている場合
			if ($this->function->publicationYearCheck($publicationYear)) {
				// 正常な場合
				$errorArray['publicationYear']['flg'] = true;
			} else {
				// 異常な場合
				$errorArray['publicationYear']['message'] .= "変なことはしないでください\n";
			}
		} else {
			// 入力されていない場合
			$errorArray['publicationYear']['flg'] = true;
		}
		
		return $errorArray['publicationYear'];
	}
	
	// 分類のチェック
	function categoryCheck($categoryId = null, $errorArray = null) {
		// 引数の確認
		if (!isset($categoryId) || !isset($errorArray)) {
			// 入っていなければ終了
			return false;
		}
		
		// クラス定義
		$this->function = new commonFunction();
		// エラーメッセージの初期化
		$errorArray['category']['message'] = null;
		// フラグの初期化
		$errorArray['category']['flg'] = false;
		
		
		// 入力されているか確認
		if (!empty($categoryId)) {
			// 入力されている場合
			if ($this->function->categoryCheck($categoryId)) {
				// 分類番号が正確な場合
				$errorArray['category']['flg'] = true;
			} else {
				// 間違った分類番号の場合
				$errorArray['category']['message'] .= "正しい分類を入力してください\n";
			}
		} else {
			// 入力されていない場合
			$errorArray['category']['flg'] = true;
		}
		
		return $errorArray['category'];
	}
}
