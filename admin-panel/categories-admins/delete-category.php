<?php include "../layout/header.php" ?>
<?php include "../../config/config.php" ?>


<?php 

if (isset($_GET['id'])){
    $id =   $_GET['id'];

    $deleteCategory = $conn->prepare("DELETE FROM categories WHERE id = '$id'");
    $deleteCategory->execute();

    header("Location: " . ADMINURL . "/categories-admins/show-categories.php");
}

?>