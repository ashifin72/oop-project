<?php


class User
{
  private $db, $data, $session_name, $isLoggedIn, $cookieName;

  public function __construct($user = null)
  {
    $this->db = Database::getInstance();
    $this->session_name = Config::get('session.user_session');
    $this->cookieName = Config::get('cookie.cookie_name');
    if (!$user) { //если данных нет то пишем из сесии id
      if (Session::exists($this->session_name)) {
        $user = Session::get($this->session_name);//id
        if ($this->find($user)) {// если пользователь залогинен записываем в isLoggedIn = true
          $this->isLoggedIn = true;
        }
      }

    } else {
      $this->find($user);
    }
  }

  public function create($fields = [])
  {
    $this->db->insert('users', $fields);
  }

  public function login($email = null, $password = null, $remember = false)
  {
    if (!$email && !$password && $this->exists()){

      Session::put($this->session_name, $this->data()->id);

    }else { // если емаил есть то получаем первого пользователя с таким мылом из БД
      $user = $this->find($email);
      // сравниваем пароль из формы и пароль из базы если верно то открываем сессию и возвращаем  true
      if ($user) {
        if (password_verify($password, $this->data()->password)) {
          Session::put($this->session_name, $this->data()->id);
          // если отмечен remember
          if ($remember) {
            // генерим hash
            $hash = hash('sha256', uniqid());
            // плучаем текущий хеш пользователя если он есть по id  пользователя
            $hashCheck = $this->db->get('user_sessions', ['user_id', '=', $this->data()->id]);
            // если записи не существует то создаем
            if (!$hashCheck->count()) {
              $this->db->insert('user_sessions', [
                  'user_id' => $this->data()->id,
                  'hash' => $hash,
              ]);
            }else{
              $hash = $hashCheck->first()->hash;
            }
            Cookie::put($this->cookieName, $hash, Config::get('cookie.cookie_expiry'));
          }
          return true;
        }
      }
    }
    return false;
  }
  // получаем данные пользователя по email или  id
  public function find($value = null)
  {
    if (is_numeric($value)) {

      $this->data = $this->db->get('users', ['id', '=', $value])->first();
    } else {
      $this->data = $this->db->get('users', ['email', '=', $value])->first();
    }
    if ($this->data) {
      return true;
    }
    return false;
  }

  //гетер для вывода data
  public function data()
  {
    return $this->data;
  }

//гетер для вывода авторизации
  public function isLoggedIn()
  {
    return $this->isLoggedIn;
  }

  public function logout()
  {
    // удаляем запись из базы
    $this->db->delete('user_sessions', ['user_id', '=', $this->data()->id]);
    // удаляем сесию
    Session::delete($this->session_name);
    // удаляем куки
    Cookie::delete($this->cookieName);
  }

  // проверяем существует ли пользователь
  public function exists()
  {
    return (!empty($this->data)) ? true : false;
  }
// обновляем пользователя
  public function update($fields=[], $id = null)
  {
    if (!$id && $this->isLoggedIn()){// если нет id  и пользователь залогинен то берем id  этого пользователя
      $id = $this->data()->id;
    }
    $this->db->update('users', $id, $fields);
  }
}