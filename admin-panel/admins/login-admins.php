<?php include "../layout/header.php" ; ?>
<?php include "../../config/config.php" ; ?>

<?php  //  define('ADMINURL', 'http://localhost/forumpro/admin-panel');
  ?>

<?php


if (isset($_SESSION['adminname'])) {
	header("Location: " . ADMINURL . "/index.php");
}


  

if (isset($_POST['submit'])) {

	$email = $_POST['email'];
	$password = $_POST['password'];

	$login = $conn->prepare("SELECT * FROM admins WHERE email = :email");
	$login->execute(array(
		':email' => $email
	));

	$fetch = $login->fetch(PDO::FETCH_ASSOC);

	if (password_verify($password, $fetch['password'])) {

		$_SESSION['email'] = $fetch['email'];
		$_SESSION['adminname'] = $fetch['adminname'];
		
		// echo "<script>alert('Login Successfull')</script>";

		header("Location: " . ADMINURL . "/index.php");
	} else {
		echo "<script>alert('Invalid Email or Password')</script>";
	} 
}


?>


      <div class="row">
        <div class="col">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title mt-5">Login</h5>
              <form method="POST" class="p-auto" action="login-admins.php">
                  <!-- Email input -->
                  <div class="form-outline mb-4">
                    <input type="email" name="email" id="form2Example1" class="form-control" placeholder="Email" />
                   
                  </div>

                  
                  <!-- Password input -->
                  <div class="form-outline mb-4">
                    <input type="password" name="password" id="form2Example2" placeholder="Password" class="form-control" />
                    
                  </div>



                  <!-- Submit button -->
                  <button type="submit" name="submit" class="btn btn-primary  mb-4 text-center">Login</button>

                 
                </form>

            </div>
       </div>
     </div>
     <?php include "../layout/footer.php" ; ?>

   