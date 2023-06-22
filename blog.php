<?php 
    require_once ("db_connection/conn.php");
    if (!admin_is_logged_in()) {
        admn_login_redirect();
    }
    include ("includes/header.php");
    $Category = new Category;

    $message = '';
    $category = (isset($_POST['category']) ? sanitize($_POST['category']) : '');

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

?> 

    <?= $flash; ?>
    <div class="container-fluid">
        <main style="background-color: rgb(51, 51, 51);">
            <div class="row justify-content-center">
                <div class="col-md-4">

                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3" style="margin-top: 34px;">
                        <h2 class="text-white" style="font-weight: 600; font-size: 20px; line-height: 28px;">TEIN . News Dashboard</h2>
                        <a href="add.member" class="btn btn-sm btn-outline-secondary" style="background: #333333;"> + Add News</a>
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

                    <div>
                        <?php if (isset($_GET['type'])): ?>
                        <?php if ($_GET['type'] == 'all'): ?>
                            all post
                        <?php elseif ($_GET['type'] == 'id'): ?>
                            single view
                        <?php elseif ($_GET['type'] == 'category' || (isset($_GET['status']) && $_GET['status'] == 'edit')): ?>
                            <div class="text-white w-100 h-100" style="z-index: 5; padding: 4px 0px; margin-bottom: 20px; transition: all 0.2s ease-in-out; background: #3B3B3B; border-radius: 4px; box-shadow: 0px 1.6px 3.6px rgb(0 0 0 / 25%), 0px 0px 2.9px rgb(0 0 0 / 22%);">
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
                            </div>
                        <?php elseif ($_GET['type'] == 'add'): ?>
                            add
                        <?php endif; ?>
                        <?php else: ?>
                            <div class="text-white w-100 h-100" style="z-index: 5; padding: 4px 0px; margin-bottom: 20px; transition: all 0.2s ease-in-out; background: #3B3B3B; border-radius: 4px; box-shadow: 0px 1.6px 3.6px rgb(0 0 0 / 25%), 0px 0px 2.9px rgb(0 0 0 / 22%);">
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
                                        <span class="menu-item"><i class="bi bi-arrow-90deg-left"></i> Go back</span>
                                        <span class=""><i class="bi bi-arrow-right"></i></span>
                                    </a>
                                </ul>
                            </div>
                        <?php endif; ?>
                    </div>

                </div>
            </div>
        </main>
    </div>

<?php include ("includes/footer.php"); ?>
