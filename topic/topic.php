<?php  include "../includes/header.php" ?>
<?php  include "../config/config.php" ?>

<?php  

if (!isset($_SESSION['username'])) {
    echo "<script>
            alert('You are not logged in, please login');
            window.location.href = '" . APPURL . "../auth/login.php';
          </script>";
    exit();
}



	if (isset($_GET['id'])) {
		$id = $_GET['id'];
		$topic = $conn->query("SELECT * FROM topics WHERE id = '$id'");
		$topic->execute();
		$singleTopic  = $topic->fetch(PDO::FETCH_OBJ);


		$topicCount = $conn->query("SELECT COUNT(*) as topic_count FROM topics WHERE author = '$singleTopic->author'");
		$topicCount->execute();
		$topicCount = $topicCount->fetch(PDO::FETCH_OBJ);

		$reply  = $conn->query("SELECT * FROM replies WHERE topic_id = '$id'");
		$reply->execute();
		$allReply = $reply->fetchAll(PDO::FETCH_OBJ);


	}








?>

	<div class="container">
		<div class="row">
			<div class="col-md-8">
				<div class="main-col">
					<div class="block">

<!--this for the paticular topic div ---->
						<h1 class="pull-left"><?php echo $singleTopic->title ; ?></h1>
						<h4 class="pull-right">club4hack</h4>
						<div class="clearfix"></div>
						<hr>
						<ul id="topics">
							<li id="main-topic" class="topic topic">
								<div class="row">
									<div class="col-md-2">
										<div class="user-info">
											<img class="avatar pull-left" src="../img/<?php echo $singleTopic->user_image ; ?>" />
											<ul>
												<li><strong><?php echo $singleTopic->author ; ?></strong></li>
												<li><?php echo $topicCount->topic_count ?> Posts</li>
												<li><a href="profile.php">Profile</a>
											</ul>
										</div>
									</div>
									<div class="col-md-10">
										<div class="topic-content pull-right">
											<p><?php echo $singleTopic->body ; ?></p>
										</div>
									</div>




									<a class="btn btn-danger" href="delete.php?id=<?php echo $singleTopic->id ;?>" role="button">Delete</a>
									<a class="btn btn-warning" href="update.php?id=<?php echo $singleTopic->id ;?>" role="button">Edit</a>
								</div>
							</li>


<!--this for the all replies ---->

		<?php foreach($allReply as $replylist) : ?>
							<li class="topic topic">
								<div class="row">
									<div class="col-md-2">
										<div class="user-info">
											<img class="avatar pull-left" src="img/<?php  echo $replylist->user_image ?>" />
											<ul>
												<li><strong><?php  echo $replylist->user_name ?></strong></li>
												<li><a href="profile.php">Profile</a>
											</ul>
										</div>
									</div>
									<div class="col-md-10">
										<div class="topic-content pull-right">
											<p><?php  echo $replylist->reply ?></p>
										</div>
									</div>
								</div>
							</li>
										
		<?php endforeach; ?>

						
						
						</ul>
						<h3>Reply To Topic</h3>
						<form role="form">
							<div class="form-group">
								<textarea id="reply" rows="10" cols="80" class="form-control" name="reply"></textarea>
								<script>
									CKEDITOR.replace('reply');
								</script>
							</div>
							<button type="submit" class="color btn btn-default">Submit</button>
						</form>
					</div>
				</div>
			</div>
		
		
		
		
			<?php  include "../includes/footer.php" ?>