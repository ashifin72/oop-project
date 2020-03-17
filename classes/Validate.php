<?php


class Validate
{
  private $passed = false, $errors = [], $db = null;

  public function __construct()
  {
    $this->db = Database::getInstance();
  }

  public function check($sourse, $items = [])
  {
    foreach ($items as $item => $rules) {
      foreach ($rules as $rule => $rule_value) {
        // получаем значение поля
        $value = $sourse[$item];
        // проверяем на заполнение поля
        if ($rule == 'required' && empty($value)) {
          // если поле путое выдаем ошибку
          $this->addError("{$item} не  заполнено!");
        } else if (!empty($value)) { // поле не пустое то начинаем проверки
          switch ($rule) {
            // проверяем на минималку
            case 'min':
              if (strlen($value) < $rule_value) {
                $this->addError("{$item} содержит меньше  {$rule_value} знаков");
              }
              break;
            case 'max':
              if (strlen($value) > $rule_value) {
                $this->addError("{$item} содержит больше  {$rule_value} знаков");
              }
              break;
            case 'matches':
              if ($value != $sourse[$rule_value]){
                $this->addError("пароли не совпадают!");
              }
              break;
            case 'unique':
              // получаем возможного пользователя
              $check = $this->db->get($rule_value,[$item, '=', $value] );
               //если пользователь существует то count() покажет значение

              if($check->count()){
                $this->addError("{$value} уже есть на сайте");
              }
              break;
            case 'email':
              if (!filter_var($value, FILTER_VALIDATE_EMAIL)){
                $this->addError("{$value} не коректный email");
              }
              break;
          }
        }
      }
    }
    if (empty($this->errors)){
      $this->passed=true;
    }
    return $this;

  }

  // если есть ошибка записываем ее в массив
  public function addError($error)
  {
    $this->errors[] = $error;
  }

  // получаем массив ошибок
  public function errors()
  {
    return $this->errors;
  }

  public function passed()
  {
    return $this->passed;
  }
}