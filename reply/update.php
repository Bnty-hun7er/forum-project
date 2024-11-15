<?php
require "../includes/header.php";
require "../config/config.php";

// Ensure the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: " . APPURL . "/login.php");
    exit();
}

// Check if 'id' is provided and is a valid number
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']); // Convert to integer to ensure a valid ID

    // Prepare the statement to select the reply
    $select = $conn->prepare("SELECT * FROM replies WHERE id = :id");
    $select->execute([':id' => $id]);
    $reply = $select->fetch(PDO::FETCH_OBJ);

    // Check if the reply exists and if the user is authorized to edit it
    if (!$reply) {
        echo "<script>alert('Reply not found')</script>";
        header("Location: " . APPURL . "/topics.php");
        exit();
    } elseif ($reply->user_id !== $_SESSION['id']) {
        echo "<script>alert('You are not authorized to edit this reply')</script>";
        header("Location: " . APPURL . "/topic/topic.php?id=" . $reply->topic_id);
        exit();
    }
} else {
    echo "<script>alert('Invalid ID')</script>";
    header("Location: " . APPURL . "/topics.php");
    exit();
}

// Check if the form was submitted
if (isset($_POST['submit'])) {
    if (empty($_POST['reply'])) {
        echo "<script>alert('All fields are required')</script>";
    } else {
        // Get the form data
        $updatedReply = htmlspecialchars($_POST['reply']); // Sanitize input

        // Prepare the query to update the reply
        $update = $conn->prepare("UPDATE replies SET reply = :reply WHERE id = :id");
        $update->execute([
            ':reply' => $updatedReply,
            ':id' => $id
        ]);

        // Set session message based on the outcome
        if ($update) {
            $_SESSION['message'] = 'Reply updated successfully';
        } else {
            $_SESSION['message'] = 'Failed to update reply';
        }

        // Redirect to the topic page
        header("Location: " . APPURL . "/topic/topic.php?id=" . $reply->topic_id);
        exit();
    }
}
?>

<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="main-col">
                <div class="block">
                    <h1 class="pull-left">Edit Reply</h1>
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
                    <form role="form" method="POST" action="update.php?id=<?php echo $id; ?>">
                        <div class="form-group">
                            <label>Edit reply</label>
                            <textarea class="form-control" name="reply" placeholder="Enter reply" required><?php echo htmlspecialchars($reply->reply); ?></textarea>
                        </div>
                        <button type="submit" name="submit" class="btn btn-default">UPDATE</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="<?php echo APPURL; ?>/js/bootstrap.js"></script>
</body>
</html>
