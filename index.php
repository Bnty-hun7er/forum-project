<?php require "includes/header.php"; ?>
<?php require "config/config.php"; ?>


<?php



$topics = $conn->query("SELECT topics.id as id , topics.title as title , 
		topics.category as category , topics.author as author , topics.user_id as user_id ,
		 topics.user_image as user_image , topics.created_at as replied_at , replies.user_id as reply_user_id ,
		 COUNT(replies.topic_id) as reply_count from topics LEFT JOIN replies ON 
		 topics.id = replies.topic_id 
		 GROUP BY (topics.id) ;");

$topics->execute();

$allTopics = $topics->fetchAll(PDO::FETCH_OBJ);





?>

<div class="container">
	<div class="row">
		<div class="col-md-8">
			<div class="main-col">
				<div class="block">
					<h1 class="pull-left">Welcome to Forum</h1>
					<h4 class="pull-right">A Simple Forum</h4>
					<div class="clearfix"></div>
					<hr>
					<ul id="topics">

						<?php foreach ($allTopics as $topic) : ?>
							<li class="topic">
								<div class="row">
									<div class="col-md-2">
										<img class="avatar pull-left" src="img/<?php echo $topic->user_image; ?>" />
									</div>
									<div class="col-md-10">
										<div class="topic-content pull-right">
											<h3><a href="topic/topic.php?id=<?php echo  $topic->id; ?>"><?php echo $topic->title; ?></a></h3>
											<div class="topic-info">

											<?php   ?>
												<a href="categories/show.php?name=<?php echo $topic->category ?>"><?php echo $topic->category; ?></a> >> <a href="<?php echo APPURL ;?>/user/profile.php?id=<?php echo $topic->user_id ;?>"><?php echo $topic->author; ?></a> >> <?php echo $topic->replied_at; ?>"
												<span class="color badge pull-right"><?php echo $topic->reply_count; ?></span>
											</div>
										</div>
									</div>
								</div>
							</li>


						<?php endforeach; ?>

					</ul>

				</div>
			</div>
		</div>
		<?php require "includes/footer.php"; ?>