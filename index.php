<?php
include_once 'init.php';

include_once 'views/header.php' ?>


<div class="row content">

  <div class="col-md-8">
    <?$id = Session::get(Config::get('session.user_session'));
     echo $id;
    ?>
    Content

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

        <input type="text" class="form-control" name="username"
               value="<? if ($alert !== 1): echo Input::get('username'); endif; ?>">
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

<? include_once 'views/footer.php' ?>


