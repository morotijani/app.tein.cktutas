<?php 

// USER NAVIGATION

?>
                <nav class="navbar navbar-expand-lg navbar-light">
                    <a href="<?= PROOT; ?>index" class="navbar-brand order-1 order-lg-2"><img src="<?= PROOT; ?>media/logo-1.png" alt="Logo" width="150" height="60"></a>
                    <button class="navbar-toggler order-2" type="button" data-toggle="collapse" data-target=".navbar-collapse" aria-controls="navbarMenu" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse order-3 order-lg-1" id="navbarMenu">
                        <ul class="navbar-nav mr-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="<?= PROOT; ?>index">
                                    Home
                                </a>
                            </li>
                            <?= get_all_categories(); ?>
                        </ul>
                    </div>

                    <div class="collapse navbar-collapse order-4 order-lg-3" id="navbarMenu2">
                        <ul class="navbar-nav ml-auto">
                            
                            <?php if (!user_is_logged_in()): ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="<?= PROOT; ?>signin">Log In</a>
                                </li>
                            <?php else: ?>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#!" id="navbarDropdown-11" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Hi <?= $user_data['first']; ?>!</a>
                                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown-11">
                                        <li><a class="dropdown-item" href="<?= PROOT; ?>profile">Profile</a></li>
                                        <li><a class="dropdown-item" href="<?= PROOT; ?>youraddress">Address</a></li>
                                        <li><a class="dropdown-item" href="<?= PROOT; ?>yourorders">Orders</a></li>
                                        <li><a class="dropdown-item" href="<?= PROOT; ?>yourpassword">Passwords</a></li>
                                        <li><a class="dropdown-item" href="<?= PROOT; ?>signout">Sign out</a></li>
                                    </ul>
                                </li>
                            <?php endif; ?>
                            <li class="nav-item">
                                <a data-toggle="modal" data-target="#search" class="nav-link"><i class="icon-search"></i></a>
                            </li>
                            <li class="nav-item cart">
                                <a data-toggle="modal" data-target="#cart" class="nav-link"><span>Cart</span><span><?= count_cart(); ?></span></a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
    </header>