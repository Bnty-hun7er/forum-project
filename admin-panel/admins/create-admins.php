<?php include "../layout/header.php"; ?>
<?php include "../../config/config.php"; ?>


<?php

if (!isset($_SESSION['adminname'])) {
  header("Location: " . ADMINURL . "/admins/login-admins.php");
}

if (isset($_POST['submit'])) {
  if (empty($_POST['email']) || empty($_POST['adminname']) || empty($_POST['password'])) {
    echo "<script>alert('All fields are required')</script>";
  } else {
    $adminname = $_POST['adminname'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if the username already exists
    $check_username = $conn->prepare("SELECT * FROM admins WHERE adminname = :adminname");
    $check_username->execute([':adminname' => $adminname]);

    if ($check_username->rowCount() > 0) {
      echo "<script>alert('Username already exists. Please choose a different one.')</script>";
    } else {
      $insertadmin = $conn->prepare("INSERT INTO admins (email, adminname, password) VALUES (:email, :adminname, :password)");
      $insertadmin->execute(array(
        ':email' => $email,
        ':adminname' => $adminname,
        ':password' => $password

      ));

      header("Location: " . ADMINURL . "/admins/login-admins.php");
    }
  }
}
?>

<div class="row">
  <div class="col">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title mb-5 d-inline">Create Admins</h5>
        <form method="POST" action="" enctype="multipart/form-data">
          <!-- Email input -->
          <div class="form-outline mb-4 mt-4">
            <input type="email" name="email" id="form2Example1" class="form-control" placeholder="email" />

          </div>

          <div class="form-outline mb-4">
            <input type="text" name="adminname" id="form2Example1" class="form-control" placeholder="username" />
          </div>
          <div class="form-outline mb-4">
            <input type="password" name="password" id="form2Example1" class="form-control" placeholder="password" />
          </div>







          <!-- Submit button -->
          <button type="submit" name="submit" class="btn btn-primary  mb-4 text-center">create</button>


        </form>

      </div>
    </div>
  </div>
</div>
<?php include "../layout/footer.php"; ?>