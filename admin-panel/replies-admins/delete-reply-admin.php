<?php include "../layout/header.php" ?>
<?php include "../../config/config.php" ?>


<?php 

if (isset($_GET['id'])){
    $id =   $_GET['id'];

    $deleteReply = $conn->prepare("DELETE FROM replies WHERE id = '$id'");
    $deleteReply->execute();

    header("Location: " . ADMINURL . "/replies-admins/show-replies.php");
}

?>


<?php include "../layout/footer.php" ?>