<?php


class Cookie
{
  // проверяем наличие куки
 public static function exists($name){
   return(isset($_COOKIE[$name])) ? true : false;
 }
 // получаем куки
  public static function get($name){
    return $_COOKIE[$name];
  }
  //записываем куки
  public static function put($name, $value, $expiry)
  {
    if (setcookie($name, $value, time() + $expiry, '/')){
      return true;
    }
    return false;
  }
  // удаляем куки
  public static function delete($name){
    self::put($name, '', time() - 1);
  }
}