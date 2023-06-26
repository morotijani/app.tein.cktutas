<?php 
    require_once ("db_connection/conn.php");

    $News = new News;
    $Category = new Category;

    $newsUrl = '';
    if (isset($_GET['url']) && !empty($_GET['url'])) {
        $newsUrl = $_GET['url'];
    } else {
        redirect(PROOT . 'news/');
    }

    include ('news.header.php');
?>

       


    <div class="row g-5">
        <div class="col-md-8">
            <?php 
                $view = $News->singleView($conn, $newsUrl);
                if ($view == false) {
                    redirect(PROOT);
                } else {
                    $News->updateViews($conn, $newsUrl);
                    echo $News->singleView($conn, $newsUrl);
                }
            ?>
     
            <nav class="blog-pagination" aria-label="Pagination">
                <a class="btn btn-outline-success rounded-pill" href="<?= PROOT; ?>">Go back</a>
            </nav>

        </div>

        <?php include ('news.left.side.php'); ?>
    </div>
    
<?php include ('news.footer.php'); ?>
