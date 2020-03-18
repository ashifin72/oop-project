<?php
include_once 'init.php';

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

    if ($validate->passed()) {// если валидация пошла
      $user = new User();// создаем user  и проеряем на соответвие почты и пароля
      // загоняем в переменную значение отмечен true  или нет false remember
      $remember = (Input::get('remember')) === 'on' ? true : false;
      $login = $user->login(Input::get('email'), Input::get('password'), $remember);
      if ($login) {
        Redirect::to('index.php');
      } else {

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
    <? if ($validate):
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
      <div class="form-check">
        <input class="form-check-input" name="remember" type="checkbox" id="remember" >
        <label class="form-check-label" for="defaultCheck1">
          Remember me
        </label>
      </div>
      <div class="field">
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
    </form>
  </div>
</div>

<? include_once 'views/footer.php' ?>

