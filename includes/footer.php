<?php 

	$topics = $conn->query ( "SELECT COUNT(*) AS all_topics FROM topics " );
	$topics->execute() ;
	$allTopics = $topics->fetch(PDO::FETCH_OBJ);


	$catogeries = $conn->query("SELECT categories.id as id , categories.name as name , COUNT(topics.category) as count_category FROM categories LEFT JOIN topics ON categories.name = topics.category GROUP BY (topics.category) "); 


	$catogeries->execute() ;

	$allcategories = $catogeries->fetchAll(PDO::FETCH_OBJ);



	// forum statistics


		//usercounts
	$users = $conn->query("SELECT COUNT(*) as count_users FROM users ");

	$users->execute();

		$allusers = $users->fetch(PDO::FETCH_OBJ);

		//topicCounts

		$Topics = $conn->query("SELECT COUNT(*) as count_topics FROM topics ");

		$Topics->execute();

		$getTopics = $Topics->fetch(PDO::FETCH_OBJ);
		


?>








<div class="col-md-4">
				<div class="sidebar">
					
					
					<div class="block">
					<h3>Categories</h3>
					<div class="list-group block ">
						<a href="#" class="list-group-item active">All Topics <span class="badge pull-right"><?php  echo $allTopics->all_topics ; ?></span></a> 
					<?php foreach ($allcategories as $catogery_count) : ?>
						<a href="<?php echo APPURL ?>/categories/show.php?name=<?php echo $catogery_count->name ; ?>" class="list-group-item"><?php echo  $catogery_count->name ;  ?><span class="color badge pull-right"><?php echo $catogery_count->count_category ;  ?></span></a>
					<?php endforeach ;  ?>
					</div>
					</div>

					<div class="block" style="margin-top: 20px;">
						<h3 class="margin-top: 40px">Forum Statistics</h3>
						<div class="list-group">
							<a href="#" class="list-group-item">Total Number of Users:<span class="color badge pull-right"><?php  echo $allusers->count_users  ;?></span></a>
							<a href="#" class="list-group-item">Total Number of Topics:<span class="color badge pull-right"><?php echo $getTopics->count_topics ?></span></a>
							
						</div>
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
    <script src="<?php echo APPURL?>/js/bootstrap.js"></script>
  </body>
</html>
