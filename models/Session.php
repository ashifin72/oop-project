<?php


class Session
{
  //записываем сессию
  public static function put($name, $value)
  {
    return $_SESSION[$name] = $value;
  }
  // проверяем наличие сессии
  public static function exists($name)
  {
    return (isset($_SESSION[$name])) ? true : false;
  }
  // удаляем сесию
  public static function delete($name)
  {
    if (self::exists($name)){
      unset($_SESSION[$name]);
    }
  }
  // получаем данные из сессии
  public static  function get($name)
  {
    return $_SESSION[$name];
  }
}