<?php


class Token
{
  // генерирует токинг
  public static function generate()
   {
     return Session::put(Config::get('session.token_name'), md5(uniqid()));
   }
   // сверяем токины
  public static function check($token)
  {
    // получаем значение токена что передала форма
    $tokenName = Config::get('session.token_name');
    if (Session::exists($tokenName) && $token == Session::get($tokenName));
    {
      Session::delete($tokenName); // удаляем сессию и возвращаем true
      return true;
    }
    return false;
  }
}
