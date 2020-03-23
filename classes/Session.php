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
    if (self::exists($name)) {
      unset($_SESSION[$name]);
    }
  }
  // получаем данные из сессии
  public static  function get($name)
  {
    return $_SESSION[$name];
  }
  public static function flash($name, $string='')
  {// проверяем наличие сессии и чтоб она не была пустой и пишем в переменную
    if (self::exists($name) && self::get($name)!== ''){
      $session = self::get($name);
      self::delete($name);
      return $session;
    }else{
      self::put($name, $string);
    }
  }
}