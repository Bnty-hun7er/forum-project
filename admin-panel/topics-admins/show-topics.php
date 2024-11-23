<?php include "../layout/header.php"; ?>
<?php include "../../config/config.php" ?>


<?php
if (!isset($_SESSION['adminname'])) {
  header("Location: " . ADMINURL . "/admins/login-admins.php");
}

$topics = $conn->query("SELECT * FROM topics order by id ASC");
$topics->execute();
$allTopics = $topics->fetchAll(PDO::FETCH_OBJ);
?>



<div class="row">
  <div class="col">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title mb-4 d-inline">Topics</h5>

        <table class="table">
          <thead>


            <tr>
              <th scope="col">#</th>
              <th scope="col">title</th>
              <th scope="col">category</th>
              <th scope="col">user</th>
              <th scope="col">delete</th>
            </tr>
          </thead>
          <tbody>

            <?php foreach ($allTopics as $topic) : ?>

              <tr>
                <th scope="row"><?php echo $topic->id ?></th>
                <td><?php echo $topic->title ?></td>
                <td><?php echo $topic->category ?></td>
                <td>                 <img style="width: 40px; height: 40px; border-radius:50%; " src="../../img/<?php echo $topic->user_image; ?>" /> 
                <?php echo $topic->author ?></td>
                <td> <button class="btn btn-danger text-center" onclick="confirmDeletion(<?php echo $topic->id; ?>)">Delete</button> </td>
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
    let userResponse = confirm("Are you sure you want to delete this topic?");
    if (userResponse) {
      // If confirmed, redirect to the delete page with the category ID
      window.location.href = `delete-topics-admin.php?id=${id}`;
    }
  }
</script>



<?php include "../layout/footer.php"; ?>