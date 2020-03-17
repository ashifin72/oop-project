<?php


class User
{
 private $db, $data, $session_name;

 public function __construct()
 {
   $this->db=Database::getInstance();
   $this->session_name=Config::get('session.user_session');
 }
 public function create($fields=[])
 {
   $this->db->insert('users', $fields);
 }
 public function login($email = null,$password = null)
 {
   if ($email){ // если емаил есть то получаем первого пользователя с таким мылом из БД
     $user = $this-> find($email);
     // сравниваем пароль из формы и пароль из базы если верно то открываем сессию и возвращаем  true
     if($user){
       if (password_verify($password, $this->data()->password )){
         Session::put($this->session_name, $this->data()->id);
         return true;
       }
     }

   }
   return false;
 }
 // получаем данные пользователя по email
 public function find($email = null)
 {
   $this->data = $this->db->get('users', ['email', '=', $email])->first();
   if ($this->data){
     return true;
   }
   return false;

 }
  //гетер для вывода data
 public function data()
 {
   return $this->data;
 }

}