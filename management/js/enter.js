function changeKeyCode() {
	// エンターをタブに変更
	if (!(event.srcElement.type == "button" || event.srcElement.type == "submit" || event.srcElement.type == "textarea")) {
		// ボタンかsubmitかテキストエリアではない場合
		if (event.keyCode == 13) {
			event.keyCode = 9;
		}
	}
}

function check() {
	// 確認ダイアログ表示
	if (window.confirm('送信してよろしいですか？') == true) {
		return true;
	} else {
		return false;
	}
}
