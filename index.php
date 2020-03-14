<?php
include_once 'models/Database.php';
include_once 'models/functions.php';
include_once 'models/Config.php';
include_once 'models/Input.php';
include_once 'models/Validate.php';

if (Input::exiist()) {
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
  if ($validation->passed()){
    echo 'passed';
  }else{
    foreach ($validation->errors() as $error) {
      echo $error . '<br>';

    }
  }
}

?>
<form action="" method="post">
  <div class="field">
    <label for="username"> Username</label>
    <input type="text" name="username" value="<?= Input::get('username') ?>">
  </div>
  <div class="field">
    <label for="">Password</label>
    <input type="text" name="password">
  </div>
  <div class="field">
    <label for="">Password Again</label>
    <input type="text" name="password_again">
  </div>
  <div class="field">
    <button type="submit">Submit</button>
  </div>
</form>

