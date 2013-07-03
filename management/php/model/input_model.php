<?php

require_once(getcwd(). '/../config/common_function.php');

class inputModel {
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
			$errorArray['bookName']['message'] .= "入力してください\n";
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
			$errorArray['acthorName']['message'] = "入力してください\n";
		}
		
		return $errorArray['acthorName'];
	}
	
	// 出版社のチェック
	function pubisherCheck($pubisher = null, $errorArray = null) {
		// 引数の確認
		if (!isset($pubisher) || !isset($errorArray)) {
			// 入っていなければ終了
			return false;
		}
		
		// エラーメッセージの初期化
		$errorArray['pubisher']['message'] = null;
		// フラグの初期化
		$errorArray['pubisher']['flg'] = false;
		
		// 入力されているか確認
		if (!empty($pubisher)) {
			// 入力されている場合
			// 文字数取得
			$pubisherNum = mb_strlen($pubisher, 'UTF-8');
			if ($pubisherNum <= 30) {
				// 上限を超えていない場合 
					$errorArray['pubisher']['flg'] = true;
			} else {
				// 上限を超えていた場合
				$errorArray['pubisher']['message'] .= "文字数が多いです\n";
			}
		} else {
			// 入力されていない場合
			$errorArray['pubisher']['message'] .= "入力してください\n";
		}
		
		return $errorArray['pubisher'];
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
			$errorArray['publicationYear']['message'] .= "入力してください\n";
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
				$errorArray['category']['message'] .= "変なことはしないでください\n";
			}
		} else {
			// 入力されていない場合
			$errorArray['category']['message'] .= "入力してください\n";
		}
		
		return $errorArray['category'];
	}
	
	// コメントのチェック
	function commentCheck($comment = null, $errorArray = null) {
		// 引数の確認
		if (!isset($comment) || !isset($errorArray)) {
			// 入っていなければ終了
			return false;
		}
		
		// エラーメッセージの初期化
		$errorArray['comment']['message'] = null;
		// フラグの初期化
		$errorArray['comment']['flg'] = false;
		
		
		// 入力されているか確認
		if (!empty($comment)) {
			// 入力されている場合
			// 文字数取得
			$commentNum = mb_strlen($comment, 'UTF-8');
			if ($commentNum <= 1000) {
				// 上限を超えていない場合 
					$errorArray['comment']['flg'] = true;
			} else {
				// 上限を超えていた場合
				$errorArray['comment']['message'] .= "文字数が多いです\n";
			}
		} else {
			// 入力されていない場合
			$errorArray['comment']['flg'] = true;
		}
		
		return $errorArray['comment'];
	}
	
	// ISBNのチェック
	function isbnCheck($isbn = null, $errorArray = null) {
		// 引数の確認
		if (is_null($isbn) || is_null($errorArray)) {
			// 入っていなければ終了
			return false;
		}
		
		// クラス定義
		$this->function = new commonFunction();
		// エラーメッセージの初期化
		$errorArray['isbn']['message'] = null;
		// ISBNの初期化
		$errorArray['isbn']['info'] = array();
		// フラグの初期化
		$errorArray['isbn']['flg'] = false;
		$numFlg = false;
		
		// 入力されているか確認
		if (!empty($isbn)) {
			// 入力されている場合
			if (preg_match("/^[0-9]{13}$/", $isbn)) {
				// 数字13桁の場合
				$numFlg = true;
			} else {
				// 指定だった場合
				$errorArray['isbn']['message'] .= "13桁にしてください\n";
			}
			if ($numFlg) {
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

