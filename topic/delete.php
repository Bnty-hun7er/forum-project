

<?php  include "../includes/header.php"?>
<?php  include "../config/config.php"?>



 <?php


    if(isset($_GET['id'])) {
        $id = $_GET['id'] ; 

        $delete = $conn->query("DELETE FROM topics WHERE id = '$id' ");
        $delete->execute();

        header("Location: " . APPURL . "/index.php");
           
    }


 ?>
