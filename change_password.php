<?php
include_once 'init.php';
$user = new User();
$validate = new Validate();
if (Input::exiist()) {
  if (Token::check(Input::get('token'))) {
    $validate->check($_POST, [
        'current_password' => ['required' => true, 'min' => 4],
        'new_password' => ['required' => true, 'min' => 4],
        'new_password_again' => ['required' => true, 'min' => 4, 'matches' => 'new_password'],
    ]);
    $alert = '';
    if ($validate->passed()) {
      if (password_verify(Input::get('current_password'), $user->data()->password)) {
        $user->update(['password' => password_hash(Input::get('new_password'), PASSWORD_DEFAULT)]);
        Session::flash('success', 'Ваш пароль изменен!');
        Redirect::to('index.php');
      } else {
        $alert = 2;
        $validate->addError('Старый пароль не верен!');
      }

    } else {
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
        <label for="username">Currrent password</label>

        <input type="text" class="form-control" name="current_password" value="">
      </div>
      <div class="form-group">
        <label for="username">New password</label>

        <input type="text" class="form-control" name="new_password" value="">
      </div>
      <div class="form-group">
        <label for="username">New password again</label>

        <input type="text" class="form-control" name="new_password_again" value="">
      </div>
      <div class="field">
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
      <input type="hidden" name="token" value="<?= Token::generate(); ?>">
    </form>
  </div>

<? include_once 'views/footer.php' ?>