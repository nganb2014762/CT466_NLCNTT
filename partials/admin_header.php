<!-- Topbar -->
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
        <div class="sidebar-brand-icon">
            <i class="fa-solid fa-shop ml-5" style="font-size: 44px; color: #0b6e4f; "></i>
        </div>        
    </a>
    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">

        <li class="nav-item dropdown px-2 py-2">
            <a class="nav-link text-uppercase text-dark" href="list_category.php">Danh mục</a>
        </li>
        <li class="nav-item px-2 py-2">
            <a class="nav-link text-uppercase text-dark" href="list_products.php">Sản phẩm</a>
        </li>

        <li class="nav-item px-2 py-2">
            <a class="nav-link text-uppercase  text-dark" href="list_wishlist.php">Yêu thích</a>
        </li>
        <li class="nav-item px-2 py-2">
            <a class="nav-link text-uppercase text-dark" href="list_comment.php">Đánh giá</a>
        </li>
        <li class="nav-item px-2 py-2">
            <a class="nav-link text-uppercase text-dark" href="list_orders.php">Đơn hàng</a>
        </li>
        <li class="nav-item px-2 py-2 dropdown">
            <a class="nav-link dropdown-toggle text-uppercase text-dark" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                
                Tài khoản
            </a>
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="list_customers.php">                
                    Khách hàng
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="list_staffs.php">                
                    Nhân viên
                </a>
            </div>
        </li>


        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
        <li class="nav-item dropdown no-arrow d-sm-none">
            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
            </a>
            <!-- Dropdown - Messages -->
            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                aria-labelledby="searchDropdown">
                <form class="form-inline mr-auto w-100 navbar-search">
                    <div class="input-group">
                        <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                            aria-label="Search" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button">
                                <i class="fas fa-search fa-sm"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </li>


        <!-- Nav Item - Messages -->
        <li class="nav-item dropdown no-arrow mx-1">
            <a class="nav-link dropdown-toggle" href="message.php" id="messagesDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-envelope fa-fw" style="color: #0b6e4f;"></i>
                <!-- Counter - Messages -->
                <?php
                $select_messages = $pdo->prepare("SELECT * FROM `message`");
                $select_messages->execute();
                $number_of_messages = $select_messages->rowCount();
                ?>
                <span class="badge badge-danger badge-counter">
                    <?= htmlspecialchars($number_of_messages); ?>
                </span>
            </a>
            <!-- Dropdown - Messages -->
            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                aria-labelledby="messagesDropdown">
                <h6 class="dropdown-header" style="background-color: #0b6e4f;">
                    Message Center
                </h6>
                <a class="dropdown-item text-center small text-dark"  href="message.php">Read More Messages</a>



        <li class="nav-item dropdown no-arrow">
            <?php
            require_once __DIR__ . '../../partials/connect.php';

            if (isset($_SESSION['admin_id'])) {
                $admin_id = $_SESSION['admin_id'];

                $select_profile = $pdo->prepare("SELECT * FROM `user` WHERE id = ?");
                $select_profile->execute([$admin_id]);
                $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
                echo '
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="mr-2 d-none d-lg-inline text-gray-600 small"> ' . htmlspecialchars($fetch_profile['name']) . '</span>
                    <img class="img-profile rounded-circle w-100" src="../img/account/user0.png' . htmlspecialchars($fetch_profile['image']) . ' ">
                </a>';
            }
            ?>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="profile.php">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-blac"></i>
                    Profile
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="admin_logout.php" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-black"></i>
                    Logout
                </a>
            </div>
        </li>

    </ul>

</nav>
<!-- End of Topbar -->