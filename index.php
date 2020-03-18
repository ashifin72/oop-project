<?php
include_once 'init.php';

include_once 'views/header.php' ?>


<div class="row content">

  <div class="col-md-8">
    <?
    //    $id = Session::get(Config::get('session.user_session'));
    //     echo $id;
    $user = new User();
    //    $id=1;
    //    $onUser = new User(1);

    ;

    ?>

    <? if ($user->isLoggedIn()):
      ?>
      Привет! <?= $user->data()->username; ?> <a href="logout.php">Выйти</a>
    <? else: ?>
      <a href="login.php">Авторизация</a>
    <? endif; ?>
  </div>
  <div class="col-md-4">

  </div>
</div>

<? include_once 'views/footer.php' ?>


