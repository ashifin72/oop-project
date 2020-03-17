<?php

class Input
{
  public static function exiist($type = 'post')
  {
    switch ($type) {
      case 'post': // проверяем наличие данных если есть то возвращаем true
        return (!empty($_POST)) ? true : false;
      case 'get':
        return (!empty($_GET)) ? true : false;
      default:
        return false;
        break;
    }
  }

  public static function get($item)
  {
    if (isset($_POST[$item])) {
      return $_POST[$item];
    } else if (isset($_GET[$item])) {
      return $_GET[$item];
    }
    return '';
  }
}