<?php 
    require_once ("db_connection/conn.php");
    if (!admin_is_logged_in()) {
        admn_login_redirect();
    }
    include ("includes/header.php");
    $Category = new Category;
    $News = new News;

    $message = '';
    // CATEGORY
    $category = (isset($_POST['category']) ? sanitize($_POST['category']) : '');

    // category edit
    if ((isset($_GET['type']) && $_GET['type'] == 'category') && (isset($_GET['status']) && $_GET['status'] == 'edit')) {
        $id = sanitize((int)$_GET['id']);

        $sql = "
            SELECT * FROM tein_category 
            WHERE id = ? 
            LIMIT 1
        ";
        $statement = $conn->prepare($sql);
        $statement->execute([$id]);
        $row = $statement->fetchAll();
        
        if ($row) {
            $category =  (isset($_POST['category']) ? sanitize($_POST['category']) : $row[0]['category']);
        } else {
            echo js_alert('Something went wrong, please try again');
            redirect(PROOT . 'blog/category');
        }
    }

    // ADD CATEGORY
    if (isset($_POST['submit'])) {
        if (!empty($category)) {
            $check = $conn->query("SELECT * FROM tein_category WHERE category = '".$category."'")->rowCount();
            if (isset($_GET['status']) && $_GET['status'] == 'edit') {
                $check = $conn->query("SELECT * FROM tein_category WHERE category = '" . $category . "' AND id != " . $id . "")->rowCount();
            }
            if ($check > 0) {
                $message = $category . ' already exists.';
            } else {
                $category_url = php_url_slug($category);
                $q = "
                    INSERT INTO tein_category (category, category_url) 
                    VALUES (?, ?)
                ";
                if (isset($_GET['status']) && $_GET['status'] == 'edit') {
                    $q = "
                        UPDATE tein_category 
                        SET category = ?, category_url = ?
                        WHERE id = " . $id . "
                    ";
                }
                $statement = $conn->prepare($q);
                $result = $statement->execute([$category, $category_url]);
                if (isset($result)) {
                    $_SESSION['flash_success'] = ucwords($category) . ' successfully ' . ((isset($_GET['status']) && $_GET['status'] == 'edit') ? 'updated' : 'added') . '!';        
                    redirect(PROOT . 'blog/category');
                } else {
                    echo js_alert('Something went wrong, please try again');
                    redirect(PROOT . 'blog/category');
                }
            }
        } else {
            $message = 'Category name required.';
        }
    }

    // DELETE A Category
    if ((isset($_GET['type']) && $_GET['type'] == 'category') && (isset($_GET['status']) && $_GET['status'] == 'delete')) {
        $delete = sanitize((int)$_GET['id']);
        $result = $Category->deleteCategory($conn, $delete);
        if ($result) {
            $_SESSION['flash_success'] = 'Category deleted!';            
            redirect(PROOT . 'blog/category');
        } else {
            echo js_alert('Something went wrong, please try again');
            redirect(PROOT . 'blog/category');
        }
    }  



    /*
    * NEWS
    * 
     */
    $news_title = (isset($_POST['news_title']) ? sanitize($_POST['news_title']) : '');
    $news_category = (isset($_POST['news_category']) ? sanitize($_POST['news_category']) : '');
    $news_content = (isset($_POST['news_content']) ? $_POST['news_content'] : '');
    $news_media = '';
    $news_url = php_url_slug($news_title);
    $news_created_by = (int)$admin_id;

    // news edit
    if ((isset($_GET['type']) && $_GET['type'] == 'add') && (isset($_GET['status']) && $_GET['status'] == 'edit')) {
        $id = sanitize((int)$_GET['id']);

        $sql = "
            SELECT * FROM tein_news 
            WHERE id = ? 
            LIMIT 1
        ";
        $statement = $conn->prepare($sql);
        $statement->execute([$id]);
        $row = $statement->fetchAll();
        
        if ($row) {
            $news_title = (isset($_POST['news_title']) ? sanitize($_POST['news_title']) : $row[0]['news_title']);
            $news_category = (isset($_POST['news_category']) ? sanitize($_POST['news_category']) : $row[0]['news_category']);
            $news_content = (isset($_POST['news_content']) ? $_POST['news_content'] : $row[0]['news_content']);
            $news_media = (($row[0]['news_media'] != '') ? $row['news_media'] : '');
        } else {
            echo js_alert('Something went wrong, please try again');
           redirect(PROOT . 'blog/add');
        }
    }

    if (isset($_POST['submitCategory'])) {
        // UPLOAD PASSPORT PICTURE TO uploadedprofile IF FIELD IS NOT EMPTY
        if ($_POST['uploaded_news_media'] == '') {
            if (!empty($_FILES)) {

                $image_test = explode(".", $_FILES["news_media"]["name"]);
                $image_extension = end($image_test);
                $image_name = md5(microtime()).'.'.$image_extension;

                $news_media = 'dist/media/news/'.$image_name;
                move_uploaded_file($_FILES["news_media"]["tmp_name"], BASEURL . $news_media);
                
                if ($_POST['uploaded_image'] != '') {
                    unlink($_POST['uploaded_image']);
                }
            } else {
                $message = '<div class="alert alert-danger">Passport Picture Can not be Empty</div>';
            }
        } else {
            $news_media = $_POST['uploaded_news_media'];
        }

        $query = "
            INSERT INTO `tein_news`(`news_title`, `news_url`, `news_content`, `news_media`, `news_category`, `news_created_by`) 
            VALUES (?, ?, ?, ?, ?, ?)
        ";
        if (isset($_GET['status']) && $_GET['status'] == 'edit') {
            $query = "
                UPDATE tein_news 
                SET news_title = ?, news_url = ?,  news_content = ?,  news_media = ?,  news_category = ?, news_created_by = ?
                WHERE id = " . $id . "
            ";
        }
        $statement = $conn->prepare($query);
        $result = $statement->execute([$news_title, $news_url, $news_content, $news_media, $news_category, $news_created_by]);
        if (isset($result)) {
            $_SESSION['flash_success'] = ucwords($news_title) . ' successfully ' . ((isset($_GET['status']) && $_GET['status'] == 'edit') ? 'updated' : 'added') . '!';        
            redirect(PROOT . 'blog/all');
        } else {
            echo js_alert('Something went wrong, please try again');
            redirect(PROOT . 'blog/all');
        }
    }
?> 

    <?= $flash; ?>
    <style>
        .tox .tox-dialog {
/*            background-color: rgb(51, 51, 51);*/
        }
        .tox .tox-dialog input {
            color: #000 !important;
        }
    </style>
    <div class="container-fluid">
        <main style="background-color: rgb(51, 51, 51);">
            <div class="row justify-content-center">
                <div class="col-md-4">

                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3" style="margin-top: 34px;">
                        <h2 class="text-white" style="font-weight: 600; font-size: 20px; line-height: 28px;">TEIN . News Dashboard</h2>
                        <a href="<?= PROOT; ?>blog/<?= ((!isset($_GET['type'])) ? 'add' : 'all'); ?>" class="btn btn-sm btn-outline-secondary" style="background: #333333;"><?= ((!isset($_GET['type'])) ? ' + Add' : ' * All'); ?> News</a>
                    </div>

                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center p-3 my-3 text-white bg-purple rounded shadow-sm text-white user-banner">
                        <div class="btn-group me-2">

                            <img class="me-3" src="<?= PROOT; ?>dist/media/logo/logo.png" alt="" width="48" height="38">
                            <div class="lh-1">
                                <h1 class="h6 mb-0 text-white lh-1" style="font-size: 16px; white-space: nowrap; text-overflow: ellipsis; font-weight: 700;"><?= strtoupper($admin_data['admin_fullname']); ?></h1>
                                <span style="font-size: 12px; line-height: 16px;"><?= $admin_data['admin_email'] ?></span><br>   
                                <span style="align-items: center; flex-direction: row;">😎 singed in.</span>
                            </div>
                        </div>
                        <div class="btn-toolbar mb-2 mb-md-0">
                            <div class="btn-group me-2">
                                <button type="button" class="text-white" style="background-color: transparent; border: none;">...</button>
                            </div>
                            <a href="<?= PROOT; ?>blog" class="btn btn-sm btn-outline-secondary">
                                Menu
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div>
                        <div class="text-white w-100 h-100" style="z-index: 5; padding: 4px 0px; margin-bottom: 20px; transition: all 0.2s ease-in-out; background: #3B3B3B; border-radius: 4px; box-shadow: 0px 1.6px 3.6px rgb(0 0 0 / 25%), 0px 0px 2.9px rgb(0 0 0 / 22%);">

                            <?php if (isset($_GET['type'])): ?>
                            <?php if ($_GET['type'] == 'all'): ?>
                                <div class="container-fluid mt-4">
                                    <table class="table table text-white table-bordered my-4">
                                        <thead>
                                            <tr style="color: #A7A7A7; font-weight: 700;">
                                                <th></th>
                                                <th>Heading</th>
                                                <th>Category</th>
                                                <th>Views</th>
                                                <th>Date</th>
                                                <th>Added by</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>                                            
                                            <?php 
                                                echo $News->allNews($conn);
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php elseif ($_GET['type'] == 'id'): ?>
                                single view
                            <?php elseif ($_GET['type'] == 'category' || (isset($_GET['status']) && $_GET['status'] == 'edit')): ?>
                                <div class="container-fluid mt-4">
                                    <div>
                                        <code><?= $message; ?></code>
                                        <form method="POST" action="<?= ((isset($_GET['status']) && $_GET['status'] == 'edit') ? '?edit=' . (int)$_GET['id'] : ''); ?>">
                                            <div class="mb-3">
                                                <div>
                                                    <label for="category" class="form-label">Category</label>
                                                    <input type="text" class="form-control form-control-sm" id="category" name="category" placeholder="Category name" value="<?= $category; ?>" required>
                                                </div>
                                            </div>
                                            <div class="mt-2 mb-2">
                                                <button type="submit" class="btn btn-sm btn-outline-secondary" name="submit" id="submit"><?= (isset($_GET['status']) && $_GET['status'] == 'edit') ? 'Update': 'Add'; ?> Category</button>
                                                <?php if ((isset($_GET['type']) && $_GET['type'] == 'category') && (isset($_GET['status']) && $_GET['status'] == 'edit')): ?>
                                                    <a href="<?= PROOT; ?>blog/category">Cancel</a>
                                                <?php endif ?>
                                            </div>
                                        </form>
                                    </div>

                                    <table class="table table-sm text-white table-bordered my-4" style="width: auto; margin: 0 auto;">
                                        <thead>
                                            <tr style="color: #A7A7A7; font-weight: 700;">
                                                <th></th>
                                                <th>Category</th>
                                                <th></th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>                                            
                                            <?php 
                                                echo $Category->allCategory($conn);
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php elseif ($_GET['type'] == 'add'): ?>
                                <!-- ADD NEWS -->
                                <div class="container-fluid mt-4">
                                    <?= $message; ?>
                                    <form method="POST" enctype="multipart/form-data" action="<?= ((isset($_GET['status']) && $_GET['status'] == 'edit') ? '?edit=1&id=' . (int)$_GET['id'] : ''); ?>">
                                        <div class="mb-3">
                                            <label for="news_title">Heading</label>
                                            <input type="text" class="form-control form-control-sm" name="news_title" id="news_title" value="<?= $news_title; ?>" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="news_category">Category</label>
                                            <select type="text" class="form-control form-control-sm" name="news_category" id="news_category" required>
                                               <option value="" <?= (($news_category == '') ? 'selected' : ''); ?>>...</option>
                                                <?php foreach ($Category->listCategory($conn) as $category_row): ?>
                                                    <option value="<?= $category_row['id']; ?>" <?= (($news_category == $category_row['id']) ? 'selected' : ''); ?>><?= ucwords($category_row['category']); ?></option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label for="news_content" class="form-label">Content</label>
                                            <textarea name="news_content" id="news_content" rows="9" class="form-control form-control-sm" required><?= $news_content; ?></textarea>
                                            <div class="form-text text-white">Type in news details.</div>
                                        </div>

                                        <?php if ($news_media != ''): ?>
                                        <div class="mb-3">
                                            <label>Product Image</label><br>
                                            <img src="<?= $news_media; ?>" class="img-fluid img-thumbnail" style="width: 200px; height: 200px; object-fit: cover;">
                                            <a href="<?= PROOT; ?>add.member?dpp=1&mid=<?= $edit_id; ?>&pp=<?= $news_media; ?>" class="badge bg-danger">Change Image</a>
                                        </div>
                                        <?php else: ?>
                                        <div class="mb-3">
                                            <div>
                                                <label for="news_media" class="form-label">Featured news image</label>
                                                <input type="file" class="form-control form-control-sm" id="news_media" name="news_media" required>
                                                <span id="upload_file"></span>
                                            </div>
                                        </div>
                                        <?php endif; ?>
                                        <input type="hidden" name="uploaded_news_media" id="uploaded_news_media" value="<?= $news_media; ?>">

                                        <div class="mt-2 mb-3">
                                            <button type="submit" class="btn btn-sm btn-outline-secondary" name="submitCategory" id="submitCategory"><?= (isset($_GET['edit']))? 'Update': 'Create'; ?> News</button>
                                            <?php if (isset($_GET['edit'])): ?>
                                                <br><br>
                                                <a href="<?= PROOT; ?>members" class="button text-secondary">Cancel</a>
                                            <?php endif ?>
                                        </div>
                                    </form>
                                </div>

                            <?php endif; ?>
                            <?php else: ?>
                                <ul class="list-group">
                                    <a href="<?= PROOT; ?>index" class="list-group-item d-flex justify-content-between align-items-center bg-transparent text-white border-0">
                                        <span class="menu-item"><i class="bi bi-house"></i> Home</span>
                                        <span class=""><i class="bi bi-arrow-right"></i></span>
                                    </a>
                                    <hr aria-hidden="true" class="menu-hr">
                                    <a href="<?= PROOT; ?>blog/category" class="list-group-item d-flex justify-content-between align-items-center bg-transparent text-white border-0">
                                        <span class="menu-item"><i class="bi bi-tag"></i> Categories</span>
                                        <span class=""><i class="bi bi-arrow-right"></i></span>
                                    </a>
                                    <hr aria-hidden="true" class="menu-hr">
                                    <a href="<?= PROOT; ?>blog/add" class="list-group-item d-flex justify-content-between align-items-center bg-transparent text-white border-0">
                                        <span class="menu-item"><i class="bi bi-building-add"></i> Add news</span>
                                        <span class=""><i class="bi bi-arrow-right"></i></span>
                                    </a>
                                    <hr aria-hidden="true" class="menu-hr">
                                    <a href="<?= PROOT; ?>blog/all" class="list-group-item d-flex justify-content-between align-items-center bg-transparent text-white border-0">
                                        <span class="menu-item"><i class="bi bi-eye-fill"></i> View all news</span>
                                        <span class=""><i class="bi bi-arrow-right"></i></span>
                                    </a>
                                    <hr aria-hidden="true" class="menu-hr">
                                    <a href="<?= PROOT; ?>blog" class="list-group-item d-flex justify-content-between align-items-center bg-transparent text-white border-0">
                                        <span class="menu-item"><i class="bi bi-arrow-clockwise"></i> Refresh</span>
                                        <span class=""><i class="bi bi-arrow-right"></i></span>
                                    </a>
                                    <hr aria-hidden="true" class="menu-hr">
                                    <a href="<?= PROOT; ?>index" class="list-group-item d-flex justify-content-between align-items-center bg-transparent text-white border-0">
                                        <span class="menu-item"><i class="bi bi-arrow-90deg-left"></i> Main Menu</span>
                                        <span class=""><i class="bi bi-arrow-right"></i></span>
                                    </a>
                                </ul>
                            <?php endif; ?>
                        </div>
                    </div>

                </div>
            </div>
        </main>
    </div>

<?php include ("includes/footer.php"); ?>
    <script src="https://cdn.tiny.cloud/1/87lq0a69wq228bimapgxuc63s4akao59p3y5jhz37x50zpjk/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script type="text/javascript">
        tinymce.init({ 
            selector: 'textarea',
            plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
            setup: function (editor) {
                editor.on('change', function (e) {
                    editor.save();
                });
            }
        });
    </script>