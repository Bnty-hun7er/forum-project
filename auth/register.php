<?php require "../includes/header.php"; ?>
<?php require "../config/config.php"; ?>

<?php
if (isset($_POST['register'])) {
    if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['username']) || empty($_POST['password']) || empty($_POST['password2'])) {
        echo "<script>alert('All fields are required')</script>";
    } else {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $username = $_POST['username'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $password2 = $_POST['password2'];

        if ($_POST['password'] !== $_POST['password2']) {
            echo "<script>alert('Passwords do not match')</script>";
            exit();
        }
        $about = $_POST['about'];

        $avatar = $_FILES['avatar']['name'];
        $avatar_tmp = $_FILES['avatar']['tmp_name'];
        $file_size = $_FILES['avatar']['size'];
        $file_type = pathinfo($avatar, PATHINFO_EXTENSION);
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];

        // Generate a unique file name
        $unique_avatar = uniqid('avatar_', true) . '.' . $file_type;
        $dir = "../img/" . $unique_avatar;

        // Check if the username already exists
        $check_username = $conn->prepare("SELECT * FROM users WHERE username = :username");
        $check_username->execute([':username' => $username]);
        
        if ($check_username->rowCount() > 0) {
            echo "<script>alert('Username already exists. Please choose a different one.')</script>";
        } elseif (!in_array(strtolower($file_type), $allowed_types)) {
            echo "<script>alert('Invalid file type. Only JPG, JPEG, PNG, and GIF are allowed.')</script>";
        } elseif ($file_size > 2 * 1024 * 1024) { // 2 MB size limit
            echo "<script>alert('File size exceeds the 2 MB limit.')</script>";
        } else {
            // Move the uploaded file to the desired directory
            if (move_uploaded_file($avatar_tmp, $dir)) {
                $insert = $conn->prepare("INSERT INTO users (name, email, username, password, about, avatar) VALUES (:name, :email, :username, :password, :about, :avatar)");
                $insert->execute(array(
                    ':name' => $name,
                    ':email' => $email,
                    ':username' => $username,
                    ':password' => $password,
                    ':about' => $about,
                    ':avatar' => $unique_avatar
                ));

                header("Location: " . APPURL . "/auth/login.php");
            } else {
                echo "<script>alert('Failed to upload avatar. Please try again.')</script>";
            }
        }
    }
}
?>













<div class="container">
	<div class="row">
		<div class="col-md-8">
			<div class="main-col">
				<div class="block">
					<h1 class="pull-left">Register</h1>
					<h4 class="pull-right">A Simple Forum</h4>
					<div class="clearfix"></div>
					<hr>
					<form role="form" enctype="multipart/form-data" method="post" action="register.php">
						<div class="form-group">
							<label>Name*</label> <input type="text" class="form-control"
								name="name" placeholder="Enter Your Name">
						</div>
						<div class="form-group">
							<label>Email Address*</label> <input type="email" class="form-control"
								name="email" placeholder="Enter Your Email Address">
						</div>
						<div class="form-group">
							<label>Choose Username*</label> <input type="text"
								class="form-control" name="username" placeholder="Create A Username">
						</div>
						<div class="form-group">
							<label>Password*</label> <input type="password" class="form-control"
								name="password" placeholder="Enter A Password">
						</div>
						<div class="form-group">
							<label>Confirm Password*</label> <input type="password"
								class="form-control" name="password2"
								placeholder="Enter Password Again">
						</div>
						<div class="form-group">
							<label>Upload Avatar</label>
							<input type="file" name="avatar">
							<p class="help-block"></p>
						</div>
						<div class="form-group">
							<label>About Me</label>
							<textarea id="about" rows="6" cols="80" class="form-control"
								name="about" placeholder="Tell us about yourself (Optional)"></textarea>
						</div>
						<input name="register" type="submit" class="color btn btn-default" value="Register" />
					</form>
				</div>
			</div>
		</div>
		<?php require "../includes/footer.php"; ?>