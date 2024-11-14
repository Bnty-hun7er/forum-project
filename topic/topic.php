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




	//reply submission 
if (isset($_POST['submit'])) {
    if (empty($_POST['reply']) ) {
        echo "<script>alert('reply cant  be empty')</script>";
    } else {
        // Get form data
        $reply = htmlspecialchars($_POST['reply']);
        $user_id = ($_SESSION['id']);
		$topic_id = $id;
        $repliedBy = $_SESSION['username'];
        $user_image = $_SESSION['avatar'];

        try {
            // Prepare the query to insert the topic into the database
            $createReply = $conn->prepare("INSERT INTO replies (reply, user_id, user_image, topic_id,user_name) VALUES ( :reply, :user_id, :user_image , :topic_id , :user_name)");
            $createReply->execute(array(
                ':reply' => $reply,
                ':user_id' => $user_id,
                ':user_image' => $user_image,
                ':topic_id' => $topic_id,
                ':user_name' => $repliedBy
            ));






            $_SESSION['message'] = 'Replied Successfully';
        } catch (PDOException $e) {
            $_SESSION['message'] = 'Failed to reply : ' . $e->getMessage();
        }

        // Redirect back to the create page
        header("Location: " . APPURL . "/topic/topic.php?id=".$id."");
        exit();
    }
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


					<?php	if (isset($_SESSION['message'])) {
						echo "<script>alert('" . $_SESSION['message'] . "')</script>";
						unset($_SESSION['message']); // Clear the message after it's displayed
					}
					?>
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
							<?php  if (isset($_SESSION['username'])) :?>
							
							<?php  if ($singleTopic->author == $_SESSION['username']) : ?>

									<a class="btn btn-danger" href="delete.php?id=<?php echo $singleTopic->id ;?>" role="button">Delete</a>
									<a class="btn btn-warning" href="update.php?id=<?php echo $singleTopic->id ;?>" role="button">Edit</a>
							<?php   endif; ?>
							<?php   endif; ?>
								
								
								</div>
							</li>


<!--this for the all replies ---->

		<?php foreach($allReply as $replylist) : ?>
							<li class="topic topic">
								<div class="row">
									<div class="col-md-2">
										<div class="user-info">
											<img class="avatar pull-left" src="../img/<?php  echo $replylist->user_image ?>" />
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
						<form role="form" method="post" action = "topic.php?id=<?php echo $id ;?>">
							<div class="form-group">
								<textarea id="reply" rows="10" cols="80" class="form-control" name="reply"></textarea>
								<script>
									CKEDITOR.replace('reply');
								</script>
							</div>
							<button type="submit" name = "submit" class="color btn btn-default">Submit</button>
						</form>
					</div>
				</div>
			</div>
		
		
		
		
			<?php  include "../includes/footer.php" ?>