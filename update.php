<?php
include_once 'init.php';
$user= new User();
$validate = new Validate();
if (Input::exiist()){
  if (Token::check(Input::get('token'))){
    $validate->check($_POST,[
        'username'=>[
            'required' => true,
            'min' => 3,
            'max' => 15,
        ]
    ]);
    $alert = '';
    if ($validate->passed()){

      $user->update(['username' => Input::get('username')]);
      Redirect::to('update.php');
      $alert = 1;
    }else{
      $alert = 2;
    }
  }
}


?>
<? include_once 'views/header.php' ?>
<div class="row justify-content-center">
  <form action="" method="post" class="col-md-4">
    <? if ($alert == 1): ?>
      <div class="alert alert-success" role="alert">
        Пользователь изменен!
      </div>
    <? elseif ($alert == 2) :
      foreach ($validate->errors() as $error) {
        ?>
        <div class="alert alert-danger" role="alert">
          <?= $error; ?>
        </div>
      <? } endif; ?>

    <div class="form-group">
      <label for="username">Username</label>

      <input type="text" class="form-control" name="username" value="<?= $user->data()->username ?>">
    </div>
    <div class="field">
      <button type="submit" class="btn btn-primary">Submit</button>
    </div>
    <input type="hidden" name="token" value="<?= Token::generate(); ?>">
  </form>
</div>

<? include_once 'views/footer.php' ?>