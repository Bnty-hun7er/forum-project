<?php require "../includes/header.php"; ?>
<?php require "../config/config.php"; ?>

<?php


if (isset($_SESSION['username'])) {
	header("Location: " . APPURL . "/index.php");
}




if (isset($_POST['login'])) {

	$email = $_POST['email'];
	$password = $_POST['password'];

	$login = $conn->prepare("SELECT * FROM users WHERE email = :email");
	$login->execute(array(
		':email' => $email
	));

	$row = $login->fetch(PDO::FETCH_ASSOC);

	if (password_verify($password, $row['password'])) {

		$_SESSION['email'] = $email;
		$_SESSION['name'] = $row['name'];
		$_SESSION['username'] = $row['username'];
		$_SESSION['id'] = $row['id'];
		$_SESSION['avatar'] = $row['avatar'];

		header("Location: " . APPURL . "/index.php");
	} else {
		echo "<script>alert('Invalid Email or Password')</script>";
	}
}


?>










<div class="container">
	<div class="row">
		<div class="col-md-8">
			<div class="main-col">
				<div class="block">
					<h1 class="pull-left">Get in</h1>
					<h4 class="pull-right">A Simple Forum</h4>
					<div class="clearfix"></div>
					<hr>
					<form role="form" enctype="multipart/form-data" method="post" action="login.php">

						<div class="form-group">
							<label>Email Address*</label> <input type="email" class="form-control"
								name="email" placeholder="Enter Your Email Address">
						</div>

						<div class="form-group">
							<label>Password*</label> <input type="password" class="form-control"
								name="password" placeholder="Enter A Password">
						</div>

						<input name="login" type="submit" class="color btn btn-default" value="login" />
					</form>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div id="sidebar">


				<div class="block">
					<h3>Categories</h3>
					<div class="list-group">
						<a href="#" class="list-group-item active">All Topics <span class="color badge pull-right">14</span></a>
						<a href="#" class="list-group-item">Design<span class="color badge pull-right">4</span></a>
						<a href="#" class="list-group-item">Development<span class="color badge pull-right">9</span></a>
						<a href="#" class="list-group-item">Business & Marketing <span class="color badge pull-right">12</span></a>
						<a href="#" class="list-group-item">Search Engines<span class="color badge pull-right">7</span></a>
						<a href="#" class="list-group-item">Cloud & Hosting <span class="color badge pull-right">3</span></a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div><!-- /.container -->


<!-- Bootstrap core JavaScript
    ================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="js/bootstrap.js"></script>
</body>

</html>