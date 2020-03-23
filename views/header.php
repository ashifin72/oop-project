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
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="/">Project OOP</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <a class="nav-link" href="index.php">Home </a>
        </li>
        <? $user= new User();
        if ($user->isLoggedIn()):?>
        <li class="nav-item">
          <a class="nav-link disabled" href="update.php">Update <?=$user->data()->username ?></a>
        </li>
        <li class="nav-item">
          <a class="nav-link disabled" href="change_password.php">Update Password</a>
        </li>
          <li class="nav-item">
            <a class="nav-link disabled" href="logout.php">Exit</a>
          </li>

        <? else:?>
        <li class="nav-item">
          <a class="nav-link disabled" href="login.php">Login</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="register.php">Register</a>
        </li>
        <? endif; ?>
      </ul>

    </div>
  </nav>
