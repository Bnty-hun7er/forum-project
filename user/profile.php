<?php
require "../includes/header.php";
require "../config/config.php";
?>

<?php
if (!isset($_SESSION['username'])) {
    header("Location: " . APPURL . "/login.php");
    exit();
}

if (isset($_GET['id']) ) {
    $id = $_GET['id'];
    $selectuser = $conn->prepare("SELECT * FROM users WHERE id = $id");
    $selectuser->execute();

    $user = $selectuser->fetch(PDO::FETCH_OBJ);

    // if ($user->id !== $_SESSION['id']) {
    //     echo "<script>alert('You are not authorized to edit this profile');</script>";
    //     header("Location: " . APPURL . "");
    //     exit();
    // }
}

?>

<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="main-col">
                <div class="block">
                    <h1 class="pull-left">Profile</h1>
                    <h4 class="pull-right">info</h4>
                    <div class="clearfix"></div>
                    <hr>
                    <!-- Display alert if message is set -->

                    <div class="col-md-2">
                        <img class="avatar pull-left" src="../img/<?php echo $user->avatar; ?>" />
                    </div> <br><br><br><br>



                    <div class="form-group">
                        <label>ID : <?php echo $user->id; ?> </label>
                    </div>

                    <div class="form-group">
                        <label>Username : <?php echo $user->username; ?> </label>
                    </div>

                    <div class="form-group">
                        <label>Email : <?php echo $user->email; ?> </label>
                    </div>

                    <div class="form-group">
                        <label>About : <?php echo $user->about; ?> </label>
                    </div>

                    <div class="form-group">
                        <label>Joined on : <?php echo $user->signed_at; ?> </label>
                    </div>

                    <?php if ($user->id == $_SESSION['id']) : ?>
                        <form method="post" action="edit-user.php?id=<?php echo $id; ?>">

                            <button type="submit" class="btn btn-primary">Edit</button>
                        </form>
                    <?php endif; ?>



                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="<?php echo APPURL ?>/js/bootstrap.js"></script>
</body>

</html>