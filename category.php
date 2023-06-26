<?php 
    require_once ("db_connection/conn.php");

    $News = new News;
    $Category = new Category;

    include ('news.header.php');

    if (isset($_GET['url']) && !empty($_GET['url'])) {
        $url = sanitize($_GET['url']);
    } else {
        redirect(PROOT);
    }
?>

    <div class="row g-5">
        <div class="col-md-8">
            <h3 class="pb-4 mb-4 fst-italic border-bottom">
                From the Firehose
            </h3>
            <div class="row" data-masonry="{&quot;percentPosition&quot;: true }" style="position: relative; height: 690px;">
                <?php 
                    $news = $Category->fetchCategoryNews($conn, $url);
                    if ($news == false) {
                        redirect(PROOT);
                    } else {
                        echo $news;
                    }
                ?>
            </div>

            <nav class="blog-pagination" aria-label="Pagination">
                <a class="btn btn-outline-success rounded-pill" href="#">Older</a>
                <a class="btn btn-outline-secondary rounded-pill disabled">Newer</a>
            </nav>
        </div>

        <?php include ('news.left.side.php'); ?>
    </div>
    
<?php include ('news.footer.php'); ?>

