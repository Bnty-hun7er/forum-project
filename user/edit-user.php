<?php
require "../includes/header.php";
require "../config/config.php";

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: " . APPURL . "/login.php");
    exit();
}

// Check if the ID is provided in the URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = intval($_GET['id']); // Ensure the ID is an integer
    $selectuser = $conn->prepare("SELECT * FROM users WHERE id = :id");
    $selectuser->bindParam(':id', $id, PDO::PARAM_INT);
    $selectuser->execute();
    $edituser = $selectuser->fetch(PDO::FETCH_OBJ);

    // Validate if the user exists and is authorized to edit
    if (!$edituser || $edituser->id !== intval($_SESSION['id'])) {
        echo "<script>alert('You are not authorized to edit this profile');</script>";
        header("Location: " . APPURL . "/auth/login.php");
        exit();
    }
} else {
    echo "<script>alert('Invalid User ID');</script>";
    header("Location: " . APPURL . "/index.php");
}

// Handle the form submission
if (isset($_POST['submit'])) {
    // Validate required fields
    if (empty($_POST['name']) || empty($_POST['uname']) || empty($_POST['email']) || empty($_POST['about'])) {
        echo "<script>alert('All fields are required');</script>";
    } else {
        // Sanitize and assign input data
        $name = htmlspecialchars(trim($_POST['name']));
        $uname = htmlspecialchars(trim($_POST['uname']));
        $email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
        $about = htmlspecialchars(trim($_POST['about']));
        $id = intval($_POST['id']);

        // Check for valid email
        if (!$email) {
            echo "<script>alert('Please provide a valid email address');</script>";
        } else {
            // Update user data in the database
            $updateuser = $conn->prepare("UPDATE users 
                SET name = :name, email = :email, username = :username, about = :about 
                WHERE id = :id");
            $updateuser->execute(array(
                ':name' => $name,
                ':email' => $email,
                ':username' => $uname,
                ':about' => $about,
                ':id' => $id,
            ));

            // Set success message and redirect
            $_SESSION['message'] = 'Profile updated successfully. Please log in again.';
			session_abort();
            header("Location: " . APPURL . "/auth/login.php");
        }
    }
}
?>

<!-- HTML for the profile update form -->
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="main-col">
                <div class="block">
                    <h1 class="pull-left">Edit Profile</h1>
                    <h4 class="pull-right">Club4Hackz</h4>
                    <div class="clearfix"></div>
                    <hr>
                    <!-- Display alert if a message is set in the session -->
                    <?php
                    if (isset($_SESSION['message'])) {
                        echo "<script>alert('" . $_SESSION['message'] . "');</script>";
                        unset($_SESSION['message']); // Clear the message after displaying it
                    }
                    ?>
                    <form role="form" method="POST" action="edit-user.php?id=<?php echo $id; ?>">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" value="<?php echo htmlspecialchars($edituser->name); ?>" class="form-control" name="name" placeholder="Enter the name" required>
                        </div>
                        <div class="form-group">
                            <label>User Name</label>
                            <input type="text" value="<?php echo htmlspecialchars($edituser->username); ?>" class="form-control" name="uname" placeholder="Enter the username" required>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" value="<?php echo htmlspecialchars($edituser->email); ?>" class="form-control" name="email" placeholder="Enter the email" required>
                        </div>
                        <div class="form-group">
                            <label>About</label>
                            <textarea id="body" rows="10" cols="80" class="form-control" name="about" required><?php echo htmlspecialchars($edituser->about); ?></textarea>
                            <script>
                                CKEDITOR.replace('body');
                            </script>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $edituser->id; ?>">
                        <button type="submit" name="submit" class="btn btn-default">UPDATE Profile</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="<?php echo APPURL; ?>/js/bootstrap.js"></script>
</body>
</html>
