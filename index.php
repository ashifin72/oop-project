<?php
include_once 'models/Database.php';
include_once 'models/functions.php';

//$users = Database::getInstance()->query(
//    "SELECT * FROM users WHERE username IN (?, ?)",
//    ['admin',
//     'user2'
//    ]
//);

$users = Database::getInstance()->get('users', ['password', '=', '123654789']);
//$users = Database::getInstance()->delete('users', ['username', '=', 'user3']);

if ($users->error()){
  echo 'ERROR!!!';
}else{
  foreach ($users->results() as $user){
    echo $user->username . '<br>';
  }
}

