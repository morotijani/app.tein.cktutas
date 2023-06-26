<?php 
    require_once ("../db_connection/conn.php");

    $News = new News;
    $Category = new Category;

    include ('news.header.php');

    if (isset($_POST['subscriber_email'])) {
        $email = sanitize($_POST['subscriber_email']);
        if ($email != '' || !empty($email)) {
    ?>

        <div class="p-4 p-md-5 mb-4 rounded text-body-emphasis bg-body-secondary">
            <div class="col-lg-6 px-0">
                <h1 class="display-4 fst-italic">News letter subscribe</h1>
                <p class="lead my-3"><?= $News->addSubscriber($conn, $email); ?></p>
                <p class="lead mb-0"><a href="<?= PROOT ; ?>news" class="text-body-emphasis fw-bold">Go back home...</a></p>
            </div>
        </div>

    <?php
        } else {
            redirect(PROOT . 'news');
        }
    } else {
        redirect(PROOT . 'news');
    }
?>


