

<?php  include "../includes/header.php"?>
<?php  include "../config/config.php"?>



 <?php


    if(isset($_GET['id'])) {
        $id = $_GET['id'] ; 





        

        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $select = $conn->prepare("SELECT * FROM replies WHERE id = '$id'");
            $select->execute();
                    
            $reply = $select->fetch(PDO::FETCH_OBJ);


			if ($reply->user_id !== $_SESSION['id']) {
				echo "<script>alert('You are not authorized to delete this topic')</script>";
                sleep(2);
				header("Location: " . APPURL . "");
				exit();
			}else {

                $delete = $conn->query("DELETE FROM replies WHERE id = '$id' ");
                $delete->execute();
        
                header("Location: " . APPURL . "/topic/topic.php?id=" . $reply->topic_id);

            }

        }



       
           
    }


 ?>
