<?php
class database {
	// DB接続情報
    var $dbUser = "libraryRoom2013";
    var $dbPass = "nvh0wr8hgmce9vrwg";
    var $dsn = "mysql:dbname=library_system;host=localhost";
    
    // DBへの接続
    function connectDb() {
    	
    	// MySQLに接続
    	$link = new PDO($this->dsn, $this->dbUser, $this->dbPass);
    	// 文字コードセット
    	$link->query('SET NAMES utf8');
    	
    	return $link;
    }
}
