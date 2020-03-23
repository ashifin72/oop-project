<?php
include_once 'init.php';

include_once 'views/header.php' ?>


<div class="row content">

  <div class="col-md-8">

      <? echo Session::flash('success')?>

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


