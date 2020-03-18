<?php
session_start();
include_once 'classes/Database.php';
include_once 'classes/functions.php';
include_once 'classes/Config.php';
include_once 'classes/Input.php';
include_once 'classes/Validate.php';
include_once 'classes/Token.php';
include_once 'classes/Session.php';
include_once 'classes/User.php';
include_once 'classes/Redirect.php';
include_once 'classes/Cookie.php';

if (Cookie::exists(Config::get('cookie.cookie_name')) && !Session::exists(Config::get('session.user_session'))){
  $hash = Cookie::get(Config::get('cookie.cookie_name'));
  $hashCheck = Database::getInstance()->get('user_sessions', ['hash', '=', $hash]);
  if ($hashCheck-count()){
    $user= new User($hashCheck->first()->user_id);
    $user->login();
  }
}
