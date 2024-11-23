<?php include "../layout/header.php"; ?>
<?php include "../../config/config.php"; ?>


<?php

if (!isset($_SESSION['adminname'])) {
  header("Location: " . ADMINURL . "/admins/login-admins.php");
}


if (isset($_GET['id'])){

  $id = $_GET['id'];

  $category = $conn->query("SELECT * FROM categories where id ='$id'");

  $category->execute();
  
  $singleCategory= $category->fetch(PDO::FETCH_OBJ);
  
  if(isset($_POST['submit'])){
    $name = $_POST['name'];
    $updcat = $conn->prepare("UPDATE categories SET name = :name WHERE id = '$id'");
    $updcat->execute(
      array(
        ':name' => $name
      )
    );
    header("Location: " . ADMINURL . "/categories-admins/show-categories.php");
  }
}




?>
<div class="row">
  <div class="col">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title mb-5 d-inline">Update Categories</h5>
        <form method="POST" action="update-category.php?id=<?php echo $id ;?>" enctype="multipart/form-data">
          <!-- Email input -->
          <div class="form-outline mb-4 mt-4">
            <input type="text" value="<?php  echo $singleCategory->name?>" name="name" id="form2Example1" class="form-control" placeholder="name" />

          </div>


          <!-- Submit button -->
          <button type="submit" name="submit" class="btn btn-primary  mb-4 text-center">update</button>


        </form>

      </div>
    </div>
  </div>
</div>
<?php include "../layout/footer.php"; ?>