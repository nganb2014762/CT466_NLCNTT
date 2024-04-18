<?php
include_once __DIR__ . '../../partials/boostrap.php';
include_once __DIR__ . '../../partials/header.php';
require_once __DIR__ . '../../partials/connect.php';

if (isset($_POST['add_to_wishlist'])) {

    $pid = $_POST['pid'];
    $p_name = $_POST['p_name'];
    $p_price = $_POST['p_price'];
    $p_image = $_POST['p_image'];
    $check_wishlist_numbers = $pdo->prepare("SELECT * FROM `wishlist` WHERE name = ? AND user_id = ?");
    $check_wishlist_numbers->execute([$p_name, $user_id]);

    $check_cart_numbers = $pdo->prepare("SELECT * FROM `cart` WHERE name = ? AND user_id = ?");
    $check_cart_numbers->execute([$p_name, $user_id]);

    if ($check_wishlist_numbers->rowCount() > 0) {
        $message[] = 'already added to wishlist!';
    } elseif ($check_cart_numbers->rowCount() > 0) {
        $message[] = 'already added to cart!';
    } else {
        $insert_wishlist = $pdo->prepare("INSERT INTO `wishlist`(user_id, pid, name, price, image) VALUES(?,?,?,?,?)");
        $insert_wishlist->execute([$user_id, $pid, $p_name, $p_price, $p_image]);
        $message[] = 'added to wishlist!';
    }

}
;

?>
<title>Watch</title>
</head>

<body>

    <!-- slide -->

    <header id="header" data-bs-ride="carousel" style="padding-top: 84px;">
        <div id="carouselExampleIndicators" class="carousel slide">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"
                    aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"
                    aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"
                    aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="img/poster/p1.jpg" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="img/poster/p2.jpg" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="img/poster/p3.png" class="d-block w-100" alt="...">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
                data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
                data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </header>

    <!-- end of slide -->

    <!-- shop -->
    <section id="collection" class="pt-5">
        <div class="container">
            <div class="title text-center">
                <h2 class="position-relative d-inline-block">New Collection</h2>
            </div>

            <div class="row g-0 container">
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-4 mt-3">
                    <?php
                    $select_products = $pdo->prepare("SELECT * FROM `products` LIMIT 8");
                    $select_products->execute();
                    if ($select_products->rowCount() > 0) {
                        while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
                            ?>
                            <div class="col">
                                <div class="card shadow rounded h-100 view-card"
                                    data-product-id="<?= htmlspecialchars($fetch_products['id']); ?>">
                                    <div class="collection-img position-relative">
                                        <img class="rounded-top p-0 card-img-top"
                                            src="admin/uploaded_img/<?= $fetch_products['image']; ?>" alt="">
                                    </div>

                                    <div class="card-body" style="background-color: #A78A7F; border-radius: 5px;">
                                        <div class="row">
                                            <div class="col-12">
                                                <p class="card-text text-capitalize text-truncate fw-bold">
                                                    <?= htmlspecialchars($fetch_products['name']); ?>
                                                </p>
                                            </div>
                                        </div>

                                        <p class="text-truncate text-capitalize">
                                            <?= htmlspecialchars($fetch_products['details']); ?>
                                        </p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="fw-bold d-block h5">
                                                $<?= htmlspecialchars($fetch_products['price']); ?>
                                            </span>
                                            <div class="btn-group">

                                            </div>
                                            <!-- <div class="btn-group">
                                                <button class="text-capitalize border-0 bg-white" type="submit"
                                                    name="add_to_wishlist">
                                                    <i class="fa-regular fa-heart fa-lg text-dark heart"></i>
                                                </button>
                                            </div> -->
                                        </div>
                                        <input type="hidden" name="pid" value="<?= htmlspecialchars($fetch_products['id']); ?>">
                                        <input type="hidden" name="p_name"
                                            value="<?= htmlspecialchars($fetch_products['name']); ?>">
                                        <input type="hidden" name="p_price"
                                            value="<?= htmlspecialchars($fetch_products['price']); ?>">
                                        <input type="hidden" name="p_image"
                                            value="<?= htmlspecialchars($fetch_products['image']); ?>">
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                    <?php
                    } else {
                        echo '<p class="empty">no products added yet!</p>';
                    }
                    ?>
            </div>
        </div>
    </section>
    <!-- end of shop -->

    <!-- offer -->
    <section id="offers" class="py-3 my-2">
        <iframe width="1290" height="500" src="https://www.youtube.com/embed/z_znOUp0ztQ?si=n7qbFAEmJaMTwUO2"
            title="YouTube video player" frameborder="0"
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
            referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>

    </section>
    <!-- end of offer -->

    <!-- about us -->
    <section id="about" class="my-5 py-5">
        <div class="container">
            <div class="title text-center">
                <h2 class="position-relative d-inline-block ms-4">About Us</h2>
                <hr class="mx-auto">
            </div>
            <div class="row gy-lg-5 align-items-center mt-1">
                <div class="col-lg-6 order-lg-1 text-center text-lg-start">
                   
                    <p class="lead text-muted px-6" >At WATCH, we take pride in being the trusted destination for
                        enthusiasts and aficionados of the world of time. With a mission to make every moment special,
                        we offer a diverse and stunning collection of wristwatches from leading brands worldwide.
                        <br>
                        
                        At WATCH, we are more than just a place to shop; we are a destination for time
                        enthusiasts. Our mission is to provide customers with the best online shopping experience,
                        delivering quality products and exceptional customer service.

                        <br>
                        With an unwavering passion, we strive to become the premier destination for time enthusiasts
                        worldwide. We are committed to offering the widest selection, the best value, and the finest
                        customer service to satisfy every customer.

                        <br>
                        Our team is not just staff; they are time enthusiasts dedicated to our mission. We take pride in
                        having a team of professionally trained and experienced experts who are always ready to assist
                        and advise you in selecting the perfect timepiece</p>
                    <button class="btn mx-4 my-4"><a href="about.php" class="text-decoration-none text-dark">Read
                            more</a></button>
                </div>

                <div class="col-lg-4 order-lg-0 pt-3 pb-3">
                    <img src="img/poster/p4.png" alt="" class="img-fluid" style="height: 600px;">
                    <!-- Thay đổi giá trị 200px để điều chỉnh chiều cao mong muốn -->
                </div>

            </div>
        </div>
    </section>
    <!-- end of about us -->

    <!-- blogs -->
    <section id="blogs" class="my-5">
        <div class="container">
            <div class="title text-center">
                <h2 class="position-relative d-inline-block mb-3">An Extraordinary Commitment To Quality</h2>
                <p>No matter what item you choose, you’ll find these things to be true:</p>
            </div>
            <div class="row g-3">
                <div class="card border-0 col-md-6 col-lg-4 bg-transparent my-3">
                    <img src="../img/poster/durable.webp" alt="">
                    <div class="card-body px-0">
                        <h4 class="card-title">DURABLE. <br> NOT DISPOSABLE.</h4>
                        <p class="card-text mt-3 text-muted"></p>
                    </div>
                </div>

                <div class="card border-0 col-md-6 col-lg-4 bg-transparent my-3">
                    <img src="../img/poster/assets_7acommunity.webp" alt="">
                    <div class="card-body px-0">
                        <h4 class="card-title">COMMUNITY POWERED <br> SUPPLY CHAIN.</h4>
                        <p class="card-text mt-3 text-muted"></p>
                    </div>
                </div>

                <div class="card border-0 col-md-6 col-lg-4 bg-transparent my-3">
                    <img src="../img/poster/made.webp" alt="">
                    <div class="card-body px-0">
                        <h4 class="card-title">MADE RIGHT. <br> RIGHT HERE.</h4>
                        <p class="card-text mt-3 text-muted"></p>
                    </div>
                </div>
            </div>

            <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-end">
                    <li class="page-item btn">
                        <a class="text-decoration-none text-dark" href="blog.php">Read more</a>
                    </li>
                </ul>
            </nav>
        </div>
    </section>
    <!-- end of blogs -->

    <button onclick="topFunction()" id="myBtn" title="Quay lại đầu trang"><i class="fa-solid fa-arrow-up"></i></button>
    <script>
        function addToWishllist() {
            var loggedIn = <?= htmlspecialchars(isset($_SESSION['user_id']) ? 'true' : 'false'); ?>;

            if (!loggedIn) {
                alert('You need to log in to add products to your wishlist.');
                window.location.href = 'login.php';
                return false;
            }
            return true;
        }
    </script>

    <script>
        window.onscroll = function () { scrollFunction() };

        function scrollFunction() {
            if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
                document.getElementById("myBtn").style.display = "block";
            } else {
                document.getElementById("myBtn").style.display = "none";
            }
        }

        function topFunction() {
            document.body.scrollTop = 0;
            document.documentElement.scrollTop = 0;
        }
    </script>

    <script>
        // Bắt sự kiện nhấp vào thẻ card và chuyển hướng đến trang view_page.php
        document.querySelectorAll('.view-card').forEach(card => {
            card.addEventListener('click', function () {
                const productId = this.getAttribute('data-product-id');
                window.location.href = `view_page.php?pid=${productId}`;
            });
        });
    </script>

</body>

</html>



<?php

include_once __DIR__ . '/../partials/footer.php';