<?php
require "../includes/header.php";
require "../config/config.php";
//session_start(); // Ensure session_start() is at the top

if (!isset($_SESSION['username'])) {
	header("Location: " . APPURL . "/login.php");
	exit();
}

// Check if the ID is provided and fetch the user
if (isset($_GET['id'])) {
	$id = $_GET['id'];
	$selectuser = $conn->prepare("SELECT * FROM users WHERE id = :id");
	$selectuser->bindParam(':id', $id, PDO::PARAM_INT);
	$selectuser->execute();
	$edituser = $selectuser->fetch(PDO::FETCH_OBJ);

	if (!$edituser || $edituser->id !== $_SESSION['id']) {
		echo "<script>alert('You are not authorized to edit this topic')</script>";
		header("Location: " . APPURL . "/auth/login.php");
		exit();
	}
}

// Handle the form submission
if (isset($_POST['submit'])) {
	if (empty($_POST['name']) || empty($_POST['uname']) || empty($_POST['email']) || empty($_POST['about'])) {
		echo "<script>alert('All fields are required')</script>";
	} else {
		$name = $_POST['name'];
		$uname = $_POST['uname'];
		$email = $_POST['email'];
		$about = $_POST['about'];
		$id = $_POST['id'];

		$updateuser = $conn->prepare("UPDATE users SET name = :name, email = :email, username = :username, about = :about WHERE id ='$id'");
		$updateuser->execute(array(
			':name' => $name,
			':email' => $email,
			':username' => $uname,
			':about' => $about,
		));

		$_SESSION['message'] = 'Profile updated successfully';
		header("Location: " . APPURL . "/auth/login.php");
		exit();
	}
}
?>


<div class="container">
	<div class="row">
		<div class="col-md-8">
			<div class="main-col">
				<div class="block">
					<h1 class="pull-left">Edit Profile</h1>
					<h4 class="pull-right">Club4Hackz</h4>
					<div class="clearfix"></div>
					<hr>
					<!-- Display alert if message is set -->
					<?php
					if (isset($_SESSION['message'])) {
						echo "<script>alert('" . $_SESSION['message'] . "')</script>";
						unset($_SESSION['message']); // Clear the message after it's displayed
					}
					?>
					<form role="form" method="POST" action="edit-user.php?id=<?php echo $id ?>">
						<div class="form-group">
							<label>Name</label>
							<input type="text" value="<?php echo $edituser->name ?>" class="form-control" name="name" placeholder="Enter the username" required>
						</div>
						<div class="form-group">
							<label> User Name</label>
							<input type="text" value="<?php echo $edituser->username ?>" class="form-control" name="uname" placeholder="Enter the username" required>
						</div>
						<div class="form-group">
							<label>email</label>
							<input type="text" value="<?php echo $edituser->email ?>" class="form-control" name="email" placeholder="Enter the username" required>
						</div>
						<div class="form-group">
							<label>About</label>
							<textarea id="body" rows="10" cols="80" class="form-control" name="about" required><?php echo $edituser->about ?></textarea>
							<script>
								CKEDITOR.replace('body');
							</script>
						</div>
						<input type="hidden" name="id" value="<?php echo $edituser->id ?>">
						<button type="submit" name="submit" class="btn btn-default">UPDATE Profile</button>
					</form>
				</div>
			</div>
		</div>

	</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="<?php echo APPURL ?>/js/bootstrap.js"></script>
</body>

</html>