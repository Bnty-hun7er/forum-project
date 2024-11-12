<?php
require "../includes/header.php";
require "../config/config.php";

// Check if the form was submitted
if (isset($_POST['submit'])) {
	// Get form data
	$title = $_POST['title'];
	$category = $_POST['category'];
	$body = $_POST['body'];
	$author = $_SESSION['username'];

	// Prepare the query to insert the topic into the database
	$create = $conn->prepare("INSERT INTO topics (title, category, body, author) VALUES (:title, :category, :body, :author)");
	$create->execute(array(
		':title' => $title,
		':category' => $category,
		':body' => $body,
		':author' => $author
	));

	// Check if the insertion was successful and set the session message
	if ($create) {
		$_SESSION['message'] = 'Topic Created Successfully';
	} else {
		$_SESSION['message'] = 'Failed to Create Topic';
	}

	// Redirect back to the create page
	header("Location: " . APPURL . "/topic/create.php");
	exit(); // Ensure no further code is executed after the redirect
}
?>

<div class="container">
	<div class="row">
		<div class="col-md-8">
			<div class="main-col">
				<div class="block">
					<h1 class="pull-left">Create A Topic</h1>
					<h4 class="pull-right">A Simple Forum</h4>
					<div class="clearfix"></div>
					<hr>
					<!-- Display alert if message is set -->
					<?php
					if (isset($_SESSION['message'])) {
						echo "<script>alert('" . $_SESSION['message'] . "')</script>";
						unset($_SESSION['message']); // Clear the message after it's displayed
					}
					?>
					<form role="form" method="POST" action="create.php">
						<div class="form-group">
							<label>Topic Title</label>
							<input type="text" class="form-control" name="title" placeholder="Enter Post Title" required>
						</div>
						<div class="form-group">
							<label>Category</label>
							<select class="form-control" name="category" required>
								<option value="Design">Design</option>
								<option value="Development">Development</option>
								<option value="Business & Marketing">Business & Marketing</option>
								<option value="Search Engines">Search Engines</option>
								<option value="Cloud & Hosting">Cloud & Hosting</option>
							</select>
						</div>
						<div class="form-group">
							<label>Topic Body</label>
							<textarea id="body" rows="10" cols="80" class="form-control" name="body" required></textarea>
							<script>
								CKEDITOR.replace('body');
							</script>
						</div>
						<button type="submit" name="submit" class="btn btn-default">Submit</button>
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