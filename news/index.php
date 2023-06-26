<?php 
    require_once ("../db_connection/conn.php");

    $News = new News;
    $Category = new Category;

    include ('news.header.php');

    $total = $conn->query("SELECT * FROM tein_news WHERE news_featured = 0 AND news_status = 0")->rowCount();
    $per_page = 10;
    $current_page = ((isset($_GET['page']) && !empty($_GET['page'])) ? $_GET['page'] : 1);

    $pagination = new Pagination($current_page, $total, $per_page);
    $offset = $pagination->offSet();
    $hasNext = $pagination->hasNextPage();
    $hasPrev = $pagination->hasPrevPage();

    echo $News->fetch_oneFeaturedNews($conn); 
?>

    <div class="row mb-2">
        <?= $News->fetchFeaturedNews($conn); ?>
    </div>

    <div class="row g-5">
        <div class="col-md-8">
            <h3 class="pb-4 mb-4 fst-italic border-bottom">
                From the Firehose
            </h3>
            <div class="row" data-masonry="{&quot;percentPosition&quot;: true }" style="position: relative; height: 690px;">
                <?= $News->fetchNews($conn, $offset, $per_page); ?>
            </div>

            <nav class="blog-pagination" aria-label="Pagination">
                <a class="btn btn-outline-success rounded-pill <?= (($hasPrev) ? '' : 'disabled'); ?>" href="<?= (($hasPrev) ? '?page=' . $current_page - 1 .'' : 'javascript:;'); ?>">Older</a>
                <a class="btn btn-outline-secondary rounded-pill <?= (($hasNext) ? '' : 'disabled'); ?>" href="<?= (($hasNext) ? '?page=' . $current_page + 1 .'' : 'javascript:;'); ?>">Newer</a>
            </nav>
        </div>

        <?php include ('news.left.side.php'); ?>
    </div>
    
<?php include ('news.footer.php'); ?>

<!-- AUTO POP UP Modal -->
<div class="modal fade" id="autoModal" tabindex="-1" aria-labelledby="autoModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
          <div class="modal-header">
              <h1 class="modal-title fs-5" id="autoModalLabel">Modal title</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
              pay dues
              get membership card
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary">Save changes</button>
          </div>
      </div>
    </div>
</div>

<script>
    $(window).on('load', function() {
        var delayMs = 1500; // delay in milliseconds

        setTimeout(function() {
            $('#autoModal').modal('show');
        }, delayMs);
    });
</script>