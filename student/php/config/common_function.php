<?php

require_once(getcwd(). '/../../php/config/category_db.php');
require_once(getcwd(). '/../../php/config/constant.php');

class commonFunction {

	// 分類DB
	var $categoryDb;

	// 数字か判定
	function numberCheck($str = null) {
		
		// 引数の確認
		if (!isset($str)) {
			// 入ってなければ終了
			return false;
		}
		
		// 数字か確認
		if (preg_match("/^[0-9]+$/", $str)) {
			// 数字のみだった場合
			return true;
		} else {
			// それ以外を使用していた場合
			return false;
		}
	}
	
	// 分類にあるか判定
	function categoryCheck($categoryId = null) {
		
		// 引数のチェック
		if (!isset($categoryId)) {
			// 入っていない場合
			return false;
		}
		
		// クラス定義
		$this->categoryDb = new categoryDb();
		
		// 分類の取り出し
		$category = $this->categoryDb->select();
		
		// 全件と比較
		foreach($category as $content) {
			if ($content['categoryId'] == $categoryId) {
				// 分類番号が一致した場合
				return true;
			}
		}
		// 一致しなかった場合
		return false;
	}
	
	// 出版年の正当性確認
	function publicationYearCheck($publicationYear = null) {
		
		// 引数のチェック
		if (!isset($publicationYear)) {
			// 入っていない場合
			return false;
		}
		
		// 数字か判定
		if (!$this->numberCheck($publicationYear)) {
			// 数字ではない場合
			return false;
		}
		
		// 現在より先になっていないか判定
		if ($publicationYear <= date('Y')) {
			// 今年か過去になっている場合
			return true;
		} else {
			// 未来を指定している場合
			return false;
		}
	}
	
	// 状態の日本語化
	function statusToString($bookStatus = null) {
		
		// 引数のチェック
		if (!isset($bookStatus)) {
			// 入っていない場合
			return false;
		}
		
		// 状態の判別
		switch ($bookStatus) {
			case POSSIBLE:
				// 貸出可能
				$message = "貸出可能です";
				break;
			case LENDED:
				// 貸出中
				$message = "貸出中です";
				break;
			case DELETE_PLAN:
				// 破棄予定
				$message = "破棄予定です";
				break;
			case 4:
				// 破棄済み
				$message = "破棄済みです";
				break;
			default:
				// それ以外の場合
				return false;
		}
		
		$bookStatus = $message;
		
		return $bookStatus;
	}
	
	// 文字列の長さ調整
	function strLength($str = null) {
		// 引数確認
		if (is_null($str)) {
			// 引数がない場合
			return false;
		}
		
		// 長さ確認
		// 文字列のバイト数を比較
		if (strlen($str) >= 26) {
			// 17文字以上だった場合
			// 調整する
			// 文字列の文字数で判定
			$str = mb_substr($str, 0, 13, "UTF-8");
			$str .= "...";
		}
		
		return $str;
	}
	
	// ISBNの検索
	function isbn($isbn) {
		
		// 引数のチェック
		if (!isset($isbn)) {
			// 入っていない場合
			return false;
		}
		
		// 結果初期化
		$result = array();
		// URL生成
		$url = "http://iss.ndl.go.jp/api/sru?operation=searchRetrieve&query=isbn=";
		$url .= $isbn;
		//XML取得
		$xml = simplexml_load_file($url);
		// 蔵書があるか確認;
		// 失敗の場合
		if ($xml->numberOfRecords == "0") {
			// フラグを立てて終了
			$result['flg'] = false;
			return $result;
		} else {
			$result['flg'] = true;
		}
		// 見つかった場合
		if ($xml->numberOfRecords == "1") {
			// 1冊見つかった場合
			// 蔵書情報の取り出し
			// 蔵書名の取り出し
			preg_match('/<dc:title>(.+)</u', $xml->records->record->recordData, $name);
			$result['bookName'] = $name[1];
			// 著者名の取り出し
			preg_match('/<dc:creator>(.+)</u', $xml->records->record->recordData, $acthor);
			$result['acthorName'] = $acthor[1];
			// 出版社の取り出し
			preg_match('/<dc:publisher>(.+)</u', $xml->records->record->recordData, $publisher);
			$result['publisher'] = $publisher[1];
			// 出版年の取り出し
			preg_match('/\"[0-9]{4}\"/', $xml->extraResponseData, $year);
			$result['publicationYear'] = substr($year[0], 1, 4);
			// ISBNの収納
			$result['isbn'] = $isbn;
		} else {
			// 複数冊見つかった場合
			// 一番上の情報の取り出し
			// 蔵書名の取り出し
			preg_match('/<dc:title>(.+)</u', $xml->records->record[0]->recordData, $name);
			$result['bookName'] = $name[1];
			// 著者名の取り出し
			preg_match('/<dc:creator>(.+)</u', $xml->records->record[0]->recordData, $acthor);
			$result['acthorName'] = $acthor[1];
			// 出版社の取り出し
			preg_match('/<dc:publisher>(.+)</u', $xml->records->record[0]->recordData, $publisher);
			$result['publisher'] = $publisher[1];
			// 出版年の取り出し
			preg_match('/\"[0-9]{4}\"/', $xml->extraResponseData, $year);
			$result['publicationYear'] = substr($year[0], 1, 4);
			// ISBNの収納
			$result['isbn'] = $isbn;
		}
		return $result;
	}
	
	// うさぎの出現
	function rabbitBorn() {
		// うさぎ関連
		$random = mt_rand(0,100);
		$rabbitFlg = false;
		if (($random % 50) == 0) {
			$rabbitFlg = true;
		}
		return $rabbitFlg;
	}
	
	// htmlspecialchars
	function h($str) {
		// 引数の確認
		if (is_null($str)) {
			return false;
		}
		
		return htmlspecialchars($str, ENT_QUOTES, "UTF-8");
	}
	
	// 岩崎ログイン処理
	function login ($userName = null, $password = null) {
		// 引数の確認
		if (is_null($userName) || is_null($password)) {
			return false;
		}
		// ログイン情報の初期化
		$loginData = array();
		
		$sessionKey = $this->login_inabi($userName, $password);
		
		// アクセスできるか確認
		if (empty($sessionKey)) {
			// アクセスできなかった場合
			$loginData['flg'] = false;
			return $loginData;
		} else {
			// アクセスできた場合
			$loginData['flg'] = true;
		}
		
		$url = 'http://10.17.1.2:8080/ws/getStudentInf.php?id='. $userName. "&session=". $sessionKey;
		
		$data = $this->getContents($url);
		$xml = simplexml_load_string($data);
		
		// 学籍番号の保存
		$loginData['id'] = (int)$xml->attributes()->id;
		// 氏名の取り出し
		$loginData['name'] = (string)$xml->name;
		// クラスの取り出し
		$loginData['class'] = (string)$xml->class;
		
		/*
		$loginData['flg'] = true;
		// 学籍番号の保存
		$loginData['id'] = '1220012';
		// 氏名の取り出し
		$loginData['name'] = '石下谷　昂';
		// クラスの取り出し
		$loginData['class'] = '1T5';
		*/
		return $loginData;
	}
	
	function login_inabi($id, $pass) {
		//ログインキーを取得する
		$getLoginKeyUrl = "http://10.17.1.2:8080/ws/getLoginKey.php?id=".$id;
		$loginKey = simplexml_load_file($getLoginKeyUrl) or die("XMLパースエラー");

		//暗号化処理
		$pass = base64_encode($pass);
		$size = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_ECB); 
		$pass = $this->pkcs5_pad($pass, $size); 
		$strBin = pack("H*",bin2hex($pass));
		$td = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '',  MCRYPT_MODE_ECB, '');
		// 警告起きるのは仕様です
		@mcrypt_generic_init($td, $loginKey, '        ');
		$enc = mcrypt_generic($td, $strBin);
		$enc64 = base64_encode($enc);
		$enc64Url = urlencode($enc64);

		//セッションキーを取得
		$loginUrl = "http://10.17.1.2:8080/ws/login.php?id=".$id."&passKey=".$enc64Url;
		$sessionKey = simplexml_load_file($loginUrl);

		return $sessionKey;
	}

	function pkcs5_pad ($text, $blocksize) {
		$pad = $blocksize - (strlen($text) % $blocksize); 
		return $text . str_repeat(chr($pad), $pad); 
	}

	function getContents($url) {
		$pattern = "http";
		if (preg_match("#^".$pattern."#",$url) == 0) {
			// "http"で始まっていないのでエラー
			return false;
		}
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch);
		curl_close($ch);
		return $result;
	}
}
