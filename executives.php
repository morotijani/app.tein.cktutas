<?php 
    require_once ("db_connection/conn.php");
    $Category = new Category;
    $News = new News;
    include ('news.header.php');

    $query = "
        SELECT * FROM tein_membership 
        WHERE membership_executive = ?
    ";
    $statement = $conn->prepare($query);
    $statement->execute(['Yes']);
    $rows = $statement->fetchAll();

?>
    <div class="p-4 p-md-5 mb-4 rounded text-body-emphasis bg-body-secondary" style="background: linear-gradient(0deg, #616161, #424242a8), url(<?= PROOT; ?>dist/media/bg-1.jpg); background-position: center; background-repeat: no-repeat; background-size: cover;">
        <div class="col-lg-6 px-0">
            <h1 class="display-4 fst-italic">Know your executives</h1>
            <p class="lead my-3">Lorem ipsum dolor sit amet consectetur adipisicing elit. Culpa eum omnis mollitia adipisci, sed veniam in consequatur totam obcaecati, facere ipsam quas et assumenda velit esse repudiandae voluptate laboriosam incidunt!</p>
            <p class="lead mb-0"><a href="<?= PROOT ; ?>" class="text-body-emphasis fw-bold">Go back home...</a></p>
        </div>
    </div>

        <div class="row g-5">
            <div class="col-md-8">
                <div class="row">
                <?php foreach ($rows as $row): ?>
                    <div class="col-md-4">
                        <div class="card">
                            <img src="<?= PROOT . $row["membership_passport"]; ?>" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title"><?= ucwords($row["membership_fname"] . ' ' . $row["membership_lname"]); ?></h5>
                            </div>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><?= ucwords($row["membership_position"]); ?></li>
                                <li class="list-group-item"><?= $row["membership_identity"] ?></li>
                                <li class="list-group-item"><?= $row["membership_email"] ?></li>
                            </ul>
                        </div>
                    </div>
                <?php endforeach; ?>
                </div>
     
            <nav class="blog-pagination mt-5" aria-label="Pagination">
                <a class="btn btn-outline-success rounded-pill" href="<?= PROOT; ?>">Go back</a>
            </nav>

        </div>

        <?php include ('news.left.side.php'); ?>
    </div>
    
<?php include ('news.footer.php'); ?>


