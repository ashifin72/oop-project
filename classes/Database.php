<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 05.03.2020
 * Time: 10:42
 */
//include "../config.php";
include_once  __DIR__ . '../../config.php';
class Database
{
  private static $instance = null;
  private $pdo, $query, $error = false, $results, $count;

  private function __construct()
  {
    // получаем массов с данными для соедения с дазой
    try {

      $this->pdo = new PDO(
          'mysql:host=' . Config::get('db.host') . ';dbname=' . Config::get('db.dbname'),
          Config::get('db.user'),
          Config::get('db.password')
      );

    } catch (PDOException $exception) {
      die($exception->getMessage());
    }
  }

// созлаем instance подключение к базе
  public static function getInstance()
  {
    if (!isset(self::$instance)) {
      // в статичную переменную записваем подключение из конструктора
      self::$instance = new Database();
    }
    return self::$instance;
  }

  // метод query выполняем запрос к БД
  public function query($sql, $params = [])
  {

    $this->error = false;

    $this->query = $this->pdo->prepare($sql);
    // получаем второй параметр в виде массива и разлаживаем с певым ключем 1
    if (count($params)) {
      $i = 1;
      foreach ($params as $param) {
        $this->query->bindValue($i, $param);
        $i++;
      }

    }
    // выводим error если execute возворащщает ошибку
    if (!$this->query->execute()) {
      $this->error = true;
    } else {
      // если норм то выводим данные через fetchAll и считаем массив
      $this->results = $this->query->fetchAll(PDO::FETCH_OBJ);
      $this->count = $this->query->rowCount();
    }
    return $this;

  }

  // выбрать данные по запросу по условию $where
  public function get($table, $where = [])
  {
    return $this->action('SELECT *', $table, $where);
  }


  //удалить запись из таблицы по условию $where
  public function delete($table, $where = [])
  {
    return $this->action('DELETE', $table, $where);
  }

  // формирует данные для кончного запроса перед query
  public function action($action, $table, $where = [])
  {
// в массиве только 3 элемента
    if (count($where) === 3) {
      //  задаем в массиве какие могут быть операторы
      $operators = ['=', '<', '<=', '>', '>='];
      $field = $where[0];
      $operator = $where[1];
      $value = $where[2];
      if (in_array($operator, $operators)) {
        $sql = "{$action} FROM {$table} WHERE {$field} {$operator} ?";
        if (!$this->query($sql, [$value])->error()) {
          return $this;
        }

      }

    }
    return false;
  }

  //записать данные в таблицу
  public function insert($table, $fields=[])
  {
    // получаем ключи массива в виде значений нового массива $keys
    $keys = array_keys($fields);
    $value='';
    foreach ($fields as $field){
      $value .= "?,";// дописываем ?, для каждого прохожденяи цикла
    }
    $val = rtrim($value, ','); // убираем крайнюю запятую спрва
    $sql ="INSERT INTO {$table} (" . implode(',',$keys) . ") VALUES (". $val .")";
    if (!$this->query($sql, $fields)->error()){
      return true;// если нет ошибок выполняем
    }
    return false;

  }

  //обновить данные записи в таблице по id
  public function update($table, $id, $fields=[])
  {
    // UPDATE users SET username=?, password=? WHERE id=2;
    $set = '';
    foreach ($fields as $key => $field){
      $set .= "{$key} = ?,";
    };

    $set = rtrim($set, ',');
    $sql= "UPDATE {$table} SET {$set} WHERE id={$id}";
//    echo $sql;
    if (!$this->query($sql, $fields)->error()){
      return true;// если нет ошибок выполняем
    }
    return false;

  }

  // гетер для ошибок error
  public function error()
  {
    return $this->error;
  }

  // гетер для результатов results
  public function results()
  {
    return $this->results;
  }

  // гетер для счетчика count
  public function count()
  {
    return $this->count;
  }
  // гетер для вывода первого пользователя (результата) по запросу
  public function first()
  {
    return $this->results()[0];
  }


}