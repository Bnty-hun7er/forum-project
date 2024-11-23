<?php include "../layout/header.php"; ?>
<?php include "../../config/config.php" ?>


<?php
if (!isset($_SESSION['adminname'])) {
  header("Location: " . ADMINURL . "/admins/login-admins.php");
}

$selectreply = $conn->prepare("SELECT * FROM replies order by id ASC");
$selectreply->execute();
$allReplies = $selectreply->fetchAll(PDO::FETCH_OBJ);
?>

<div class="row">
  <div class="col">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title mb-4 d-inline">Replies</h5>

        <table class="table">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">reply</th>
              <th scope="col">user name</th>
              <th scope="col">go to topic</th>
              <th scope="col">delete</th>
            </tr>
          </thead>
          <tbody>

            <?php foreach ($allReplies as $reply) : ?>

              <tr>
                <th scope="row"><?php echo $reply->id  ?></th>
                <td><?php echo $reply->reply ?></td>
                <td><img style="width: 40px; height: 40px; border-radius:50%; " src="../../img/<?php echo $reply->user_image; ?>"><?php echo $reply->user_name  ?></td>
                <td><a href="http://localhost/forumpro/topic/topic.php?id=<?php echo $reply->topic_id ; ?>" class="btn btn-success text-center ">go to topic</a></td>

                <td><a  onclick="confirmDeletion(<?php echo $reply->id  ?>)"    class="btn btn-danger  text-center ">delete</a></td>
              </tr>

            <?php endforeach; ?>

          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>


<script>
  function confirmDeletion(id) {
    // Display the confirmation dialog
    let userResponse = confirm("Are you sure you want to delete this reply?");
    if (userResponse) {
      // If confirmed, redirect to the delete page with the category ID
      window.location.href = `delete-reply-admin.php?id=${id}`;
    }
  }
</script>



<?php include "../layout/footer.php"; ?>