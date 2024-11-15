<?php require "../includes/header.php"; ?>
<?php require "../config/config.php"; ?>


<?php



if (isset($_GET['name'])) {
    $name = $_GET['name'];
    $topics = $conn->query("SELECT * from topics where category = '$name' ");

    $topics->execute();

    $allTopics = $topics->fetchAll(PDO::FETCH_OBJ);

} else {
    header("Location: " . APPURL . "/404.php");
}








?>

<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="main-col">
                <div class="block">
                    <h1 class="pull-left"><?php echo $name ?></h1>
                    <h4 class="pull-right">A Simple Forum</h4>
                    <div class="clearfix"></div>
                    <hr>
                    <ul id="topics">

                        <?php foreach ($allTopics as $topic) : ?>
                            <li class="topic">
                                <div class="row">
                                    <div class="col-md-2">
                                        <img class="avatar pull-left" src="../img/<?php echo $topic->user_image; ?>" />
                                    </div>
                                    <div class="col-md-10">
                                        <div class="topic-content pull-right">
                                            <h3><a href="../topic/topic.php?id=<?php echo  $topic->id; ?>"><?php echo $topic->title; ?></a></h3>
                                            <div class="topic-info">
                                                <a href="profile.html">Author :  <?php echo $topic->author; ?></a> >> Posted On:  <?php echo $topic->created_at; ?>
                                                <span class="color badge pull-right"></span>
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
        <?php require "../includes/footer.php"; ?>