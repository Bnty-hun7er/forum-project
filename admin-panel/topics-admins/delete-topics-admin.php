<?php include "../layout/header.php" ?>
<?php include "../../config/config.php" ?>


<?php 

if (isset($_GET['id'])){
    $id =   $_GET['id'];

    $deleteTopic = $conn->prepare("DELETE FROM topics WHERE id = '$id'");
    $deleteTopic->execute();

    header("Location: " . ADMINURL . "/topics-admins/show-topics.php");
}

?>