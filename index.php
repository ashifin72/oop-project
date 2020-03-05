<?php
include_once 'models/Database.php';
include_once 'models/functions.php';

$new_db = new Database();
$table = 'categories';
$id = 1;
//$new_db -> getAll($table);
ash_debug($new_db -> getAll($table));
ash_debug($new_db -> getOne($table, $id));
