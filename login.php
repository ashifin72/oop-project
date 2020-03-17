<?php
session_start();
include_once 'classes/Database.php';
include_once 'classes/functions.php';
include_once 'classes/Config.php';
include_once 'classes/Input.php';
include_once 'classes/Validate.php';
include_once 'classes/Token.php';
include_once 'classes/Session.php';
include_once 'classes/User.php';

if (Input::exiist()) { // если поля заполненны
  if (Token::check(Input::get('token'))) { // токен верен
    $validate = new Validate();
    $validate->check($_POST, [
        'email' => [
            'required' => true,
            'email' => true,

        ],
        'password' => [
            'required' => true,
        ],
    ]);
    $alert = ''; // добавляем переменную для вывода извещения
    if ($validate->passed()) {// если валидация пошла
      $user = new User();// создаем user  и проеряем на соответвие почты и пароля
      $login = $user->login(Input::get('email'), Input::get('password'));
      if ($login) {
        $alert = 1;
      } else {
        $alert = 2;
        $validate->addError('Ошибка авторизации!');
      }
    } else {
      $alert = 2;
    }
  }
}


?>
<? include_once 'views/header.php' ?>
<div class="row content justify-content-center">

  <div class="col-md-4">
    <? if ($alert == 1): ?>
      <div class="alert alert-success" role="alert">
        Вы зашли!
      </div>
    <? elseif ($alert == 2) :
      foreach ($validate->errors() as $error) {
        ?>
        <div class="alert alert-danger" role="alert">
          <?= $error; ?>
        </div>
      <? } endif; ?>

    <form action="" method="post">
      <div class="form-group">
        <label for="username">Email</label>

        <input type="text" class="form-control" name="email" value="<?= Input::get('email'); ?>">
      </div>
      <div class="form-group">
        <label for="">Password</label>
        <input type="text" name="password" class="form-control">
      </div>

      <input type="hidden" name="token" value="<?= Token::generate(); ?>">
      <div class="field">
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
    </form>
  </div>
</div>

<? include_once 'views/footer.php' ?>

