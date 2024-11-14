

<?php  include "../includes/header.php"?>
<?php  include "../config/config.php"?>



 <?php


    if(isset($_GET['id'])) {
        $id = $_GET['id'] ; 





        

        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $select = $conn->prepare("SELECT * FROM topics WHERE id = '$id'");
            $select->execute();
                    
            $topic = $select->fetch(PDO::FETCH_OBJ);


			if ($topic->author != $_SESSION['username']) {
				echo "<script>alert('You are not authorized to delete this topic')</script>";
                sleep(2);
				header("Location: " . APPURL . "");
				exit();
			}else {

                $delete = $conn->query("DELETE FROM topics WHERE id = '$id' ");
                $delete->execute();
        
                header("Location: " . APPURL . "/index.php");

            }

        }



       
           
    }


 ?>
