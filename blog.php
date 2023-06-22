<?php 
    require_once ("db_connection/conn.php");
    if (!admin_is_logged_in()) {
        admn_login_redirect();
    }
    include ("includes/header.php");

?> 


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

                            <img class="me-3" src="dist/media/logo/logo.png" alt="" width="48" height="38">
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
                            <a href="auth/logout" class="btn btn-sm btn-outline-secondary">
                                Sign out
                            </a>
                        </div>
                    </div>

                    <div>
                        <?php if (isset($_GET['type'])): ?>
                        <?php if ($_GET['type'] == 'all'): ?>
                            all post
                        <?php elseif ($_GET['type'] == 'id'): ?>
                            single view
                        <?php elseif ($_GET['type'] == 'category'): ?>
                            category
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
