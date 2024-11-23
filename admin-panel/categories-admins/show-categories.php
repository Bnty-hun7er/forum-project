<?php include "../layout/header.php"; ?>
<?php include "../../config/config.php"; ?>

<?php
if (!isset($_SESSION['adminname'])) {
    header("Location: " . ADMINURL . "/admins/login-admins.php");
}

$categories = $conn->query("SELECT * FROM categories");
$categories->execute();
$allCategories = $categories->fetchAll(PDO::FETCH_OBJ);
?>

<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-4 d-inline">Categories</h5>
                <a href="<?php echo ADMINURL; ?>/categories-admins/create-category.php" class="btn btn-primary mb-4 text-center float-right">Create Categories</a>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Update</th>
                            <th scope="col">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($allCategories as $category) : ?>
                            <tr>
                                <th scope="row"><?php echo $category->id; ?></th>
                                <td><?php echo $category->name; ?></td>
                                <td>
                                    <a href="update-category.php?id=<?php echo $category->id; ?>" class="btn btn-warning text-white text-center">Update</a>
                                </td>
                                <td>
                                    <button class="btn btn-danger text-center" onclick="confirmDeletion(<?php echo $category->id; ?>)">Delete</button>
                                </td>
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
        let userResponse = confirm("Are you sure you want to delete this category?");
        if (userResponse) {
            // If confirmed, redirect to the delete page with the category ID
            window.location.href = `delete-category.php?id=${id}`;
        }
    }
</script>

<?php include "../layout/footer.php"; ?>
