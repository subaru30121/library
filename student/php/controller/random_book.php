<?php

require_once(getcwd(). '/../../php/view/random_book_view.php');
require_once(getcwd(). '/../../php/config/master_books_db.php');
require_once(getcwd(). '/../../php/config/common_function.php');
require_once(getcwd(). '/../../php/config/category_db.php');

$randomBookView = new randomBookView();
$masterbooksDb = new masterbooksDb();
$categoryDb = new categoryDb();
$commonFunction = new commonFunction();

$data = $masterbooksDb->random();
$category = $categoryDb->selectOne($data['category']);
$data['category'] = $category['categoryName'];

$randomBookView->display($data);

