<?php
session_start();
include_once 'models/Database.php';
include_once 'models/functions.php';
include_once 'models/Config.php';
include_once 'models/Input.php';
include_once 'models/Validate.php';
include_once 'models/Token.php';
include_once 'models/Session.php';
include_once 'models/User.php';

if (Input::exiist())
  if (Token::check(Input::get('token'))) {
    $validate = new Validate();
    $validation = $validate->check($_POST, [
        'username' => [
            'required' => true,
            'min' => 2,
            'max' => 15,
            'unique' => 'users'
        ],
        'password' => [
            'required' => true,
            'min' => 2,

        ],
        'password_again' => [
            'required' => true,
            'matches' => 'password'
        ]

    ]);
    $alert = '';
    if ($validation->passed()) {

      $user = new User();
      $user->create([
          'username' => Input::get('username'),
          'password' => password_hash(Input::get('password'), PASSWORD_DEFAULT),
      ]);
      $alert = 1;
      Session::flash('success', 'Регистрация удачная');
    } else {
      $alert = 2;

    }

  }

?>
<!doctype html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta name="description" content="">

  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

  <!-- Template Basic Images Start -->
  <meta property="og:image" content="path/to/image.jpg">
  <link rel="icon" href="img/favicon/favicon.ico">
  <link rel="apple-touch-icon" sizes="180x180" href="img/favicon/apple-touch-icon-180x180.png">
  <!-- Template Basic Images End -->

  <!-- Custom Browsers Color Start -->
  <meta name="theme-color" content="#000">
  <!-- Custom Browsers Color End -->

  <link rel="stylesheet" href="assets/css/main.min.css">

  <title>Project OOP</title>
</head>
<body>
<div class="container">
  <div class="row content">
    <div class="col-md-8">
      ТЕСТ
      <a href="/"> Главная </a>
    </div>
    <div class="col-md-4">
      <? if ($alert == 1): ?>
        <div class="alert alert-success" role="alert">
          <?= Session::flash('success'); ?>
        </div>
      <? elseif ($alert == 2) :
        foreach ($validation->errors() as $error) {
          ?>
          <div class="alert alert-danger" role="alert">
            <?= $error; ?>
          </div>
        <? } endif; ?>
      <form action="" method="post">
        <div class="form-group">
          <label for="username"> Username</label>

          <input type="text" class="form-control" name="username" value="<? if ($alert !== 1): echo Input::get('username'); endif;?>">
        </div>
        <div class="form-group">
          <label for="">Password</label>
          <input type="text" name="password" class="form-control">
        </div>
        <div class="form-group">
          <label for="">Password Again</label>
          <input type="text" name="password_again" class="form-control">
        </div>
        <input type="hidden" name="token" value="<?= Token::generate(); ?>">
        <div class="field">
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
      </form>
    </div>
  </div>

</div>
<script src="js/scripts.min.js"></script>
</body>
</html>


