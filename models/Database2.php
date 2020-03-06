<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 05.03.2020
 * Time: 10:42
 */

class Database
{
  private $db;

  public function __construct()
  {
    // получаем массов с данными для соедения с дазой
    $dbOptions = (require __DIR__ . '/config.php')['db'];

    $this->db = new \PDO(
        'mysql:host=' . $dbOptions['host'] . ';dbname=' . $dbOptions['dbname'],
        $dbOptions['user'],
        $dbOptions['password']
    );
    $this->db->exec('SET NAMES UTF8');// устанавливаем кодировку UTF8
  }


  //получить все записи из таблицы
  public function getAll($table)
  {
    $sql = "SELECT * FROM $table";
    //Загоняем запрос  с помощью метода prepare() ы переменную
    $qwery = $this->db->prepare($sql);
    $qwery->execute();
    $result = $qwery->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }

  //получить одну запись из таблицы по id
  public function getOne($table, $id)
  {
    $sql = "SELECT * FROM $table WHERE id = :id";
    $qwery = $this->db->prepare($sql);
    $qwery->execute(['id' => $id]);
    $result = $qwery->fetch(PDO::FETCH_ASSOC);
    return $result;
  }

  //записать данные в таблицу
  public function insert($table, $data)
  {
    $sql = "INSERT INTO $table (`data`) VALUES (:data)";
    $params = [
        'data' => $data,
    ];
    $qwery = $this->db->prepare($sql);
    $qwery->execute($params);
  }

  //обновить данные записи в таблице по id
  public function update($table, $data, $id)
  {
    $sql = "UPDATE `$table` SET `data` = :data WHERE `id` = :id";
    $params = [
        'data' => $data,
        'id' => $id,
    ];
    $qwery = $this->db->prepare($sql);
    $qwery->execute($params);
  }

  //удалить запись из таблицы по id
  public function delete($table, $id)
  {
    $sql = "DELETE FROM $table WHERE  `id` = :id";
    $params = [
        'id' => $id,
    ];
    $qwery = $this->db->prepare($sql);
    $qwery->execute($params);
  }
}