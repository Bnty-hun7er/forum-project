<?php include "../layout/header.php" ; ?>
<?php include "../../config/config.php" ; ?>

<?php

if (!isset($_SESSION['adminname'])) {
  header("Location: " . ADMINURL . "/admins/login-admins.php");
}

if (isset($_POST['submit'])) {
  if (empty($_POST['name']) ) {
    echo "<script>alert('name is  required')</script>";
  } else {
    $name = $_POST['name'];
   
    // Check if the username already exists
    $check_username = $conn->prepare("SELECT * FROM categories WHERE name = :name");
    $check_username->execute([':name' => $name]);

    if ($check_username->rowCount() > 0) {
      echo "<script>alert('Category already exists. Please choose a different one.')</script>";
    } else {
      $insertCategory= $conn->prepare("INSERT INTO categories (name) VALUES (:name)");
      $insertCategory->execute(array(
        ':name' => $name,
       
      ));

      header("Location: " . ADMINURL . "/categories-admins/show-categories.php");
    }
  }
}
?>


<div class="row">
        <div class="col">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title mb-5 d-inline">Create Categories</h5>
          <form method="POST" action="" enctype="multipart/form-data">
                <!-- Email input -->
                <div class="form-outline mb-4 mt-4">
                  <input type="text" name="name" id="form2Example1" class="form-control" placeholder="name" />
                 
                </div>

      
                <!-- Submit button -->
                <button type="submit" name="submit" class="btn btn-primary  mb-4 text-center">create</button>

          
              </form>

            </div>
          </div>
        </div>
        
        
<?php include "../layout/footer.php" ?>
