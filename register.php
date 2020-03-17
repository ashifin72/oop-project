<?php
require_once 'init.php';

if (Input::exiist())
  if (Token::check(Input::get('token'))) {
    $validate = new Validate();
    $validation = $validate->check($_POST, [
        'username' => [
            'required' => true,
            'min' => 2,
            'max' => 15,

        ],
        'email' => [
            'required' => true,
            'email' => true,
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
          'email' => Input::get('email'),
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
<? include_once 'views/header.php' ?>
  <div class="row content justify-content-center">

    <div class="col-md-6">

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
          <label for="username">Email</label>

          <input type="text" class="form-control" name="email"
                 value="<? if ($alert !== 1): echo Input::get('email'); endif; ?>">
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