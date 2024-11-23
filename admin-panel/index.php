<?php include "layout/header.php"; ?>
<?php include "../config/config.php"; ?>

<?php

if (!isset($_SESSION['adminname'])) {
  header("Location: " . ADMINURL . "/admins/login-admins.php");
}


$countAdmins = $conn->prepare("SELECT COUNT(id) as adminCount FROM admins");
$countAdmins->execute();
$adminCount = $countAdmins->fetch(PDO::FETCH_OBJ);



$countTopics = $conn->prepare("SELECT COUNT(id) as topicCount from topics");
$countTopics->execute();
$topicCount = $countTopics->fetch(PDO::FETCH_OBJ);

$countCategories = $conn->prepare("SELECT  COUNT(id) as categoryCount  FROM categories");
$countCategories->execute();
$categoryCount = $countCategories->fetch(PDO::FETCH_OBJ);

$countReplies = $conn->prepare("SELECT  COUNT(id) as replyCount FROM replies ");
$countReplies->execute();
$replyCount = $countReplies->fetch(PDO::FETCH_OBJ);









?>




<div class="row">
  <div class="col-md-3">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Topics</h5>
        <!-- <h6 class="card-subtitle mb-2 text-muted">Bootstrap 4.0.0 Snippet by pradeep330</h6> -->
        <p class="card-text">number of topics: <?php echo $topicCount->topicCount; ?></p>

      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Categories</h5>

        <p class="card-text">number of categories: <?php echo $categoryCount->categoryCount; ?></p>

      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Admins</h5>

        <p class="card-text">number of admins: <?php echo $adminCount->adminCount; ?></p>

      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Replies</h5>

        <p class="card-text">number of replies: <?php echo $replyCount->replyCount; ?></p>

      </div>
    </div>
  </div>
</div>
<!--  <div class="row">
        <div class="col">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Card title</h5>
              <table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">First</th>
      <th scope="col">Last</th>
      <th scope="col">Handle</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">1</th>
      <td>Mark</td>
      <td>Otto</td>
      <td>@mdo</td>
    </tr>
    <tr>
      <th scope="row">2</th>
      <td>Jacob</td>
      <td>Thornton</td>
      <td>@fat</td>
    </tr>
    <tr>
      <th scope="row">3</th>
      <td>Larry</td>
      <td>the Bird</td>
      <td>@twitter</td>
    </tr>
  </tbody>
</table> -->


<?php include "layout/footer.php"; ?>