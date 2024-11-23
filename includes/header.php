<?php
session_start();
define("APPURL", "http://localhost/forumpro");
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Hakers Talk</title>

  <!-- Bootstrap core CSS -->
  <link href="<?php echo APPURL ?>/css/bootstrap.css" rel="stylesheet">
  <!-- Custom styles for this template -->
  <link href="<?php echo APPURL ?>/css/custom.css" rel="stylesheet">
</head>

<body>

  <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="<?php echo APPURL; ?>/index.php">Club-4-Hack</a>
      </div>
      <div class="collapse navbar-collapse">
        <ul class="nav navbar-nav navbar-right">
          <li class="active"><a href="<?php echo APPURL; ?>/index.php">Home</a></li>

          <?php if (!isset($_SESSION['username'])): ?>
            <li><a href="<?php echo APPURL; ?>/auth/register.php">Register</a></li>

          <?php else : ?>

            <li><a href="<?php echo APPURL; ?>/topic/create.php">Create</a></li>



          <?php endif; ?>



          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
              <?php
              if (isset($_SESSION['username'])) {
                echo htmlspecialchars($_SESSION['username']); // Display username after login
              } else {
                echo 'Login'; // Show 'Login' if user is not logged in
              }
              ?>
              <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
              <?php if (isset($_SESSION['username'])): ?>
                <li><a href="<?php echo APPURL; ?>/user/profile.php?id=<?php  echo $_SESSION['id']?>">Profile</a></li>
                <li><a href="#">Contact Admin</a></li>
                <li><a href="<?php echo APPURL; ?>/auth/logout.php">Logout</a></li>
              <?php else: ?>
                <li><a href="<?php echo APPURL; ?>/auth/login.php">Login</a></li>
                <li><a href="http://mikeben.me" target="_blank">About the dev</a></li>
              <?php endif; ?>
            </ul>
          </li>
        </ul>
      </div><!--/.nav-collapse -->
    </div>
  </div>