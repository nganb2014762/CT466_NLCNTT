<?php
include_once __DIR__ . '../../partials/boostrap.php';
include_once __DIR__ . '../../partials/header.php';
require_once __DIR__ . '../../partials/connect.php';

// Kiểm tra xem người dùng đã nhấn vào nút phân loại nào và lấy id của danh mục tương ứng
if (isset($_GET['category_id'])) {
    $category_id = $_GET['category_id'];
    $select_products = $pdo->prepare("SELECT * FROM `products` WHERE category_id = :category_id");
    $select_products->execute([':category_id' => $category_id]);
} else {
    // Nếu không có nút nào được nhấn, hiển thị tất cả sản phẩm
    $select_products = $pdo->prepare("SELECT * FROM `products`");
    $select_products->execute();
}
?>

?>
<title>Watch</title>
</head>

<body>

    <!-- slide -->

    <header id="header" data-bs-ride="carousel" style="padding-top: 84px;">
        <div id="carouselExampleIndicators" class="carousel slide" data-bs-interval="500">
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

            <?php
            if (isset($message)) {
                foreach ($message as $msg) {
                    echo '<div class="alert alert-warning alert-dismissible fade show col-6 offset-3" role="alert" tabindex="-1">
                            ' . htmlspecialchars($msg) . '
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                          </div>';
                }
            }
            ?>
            <div class="row g-0 justify-content-center">
                <div class="d-flex flex-wrap justify-content-center mt-3 filter-button-group">
                    <button type="button" class="btn m-2 text-dark"><a class="text-decoration-none text-dark"
                            href="index.php">All</a></button>
                    <?php
                    $select_categorys = $pdo->prepare("SELECT * FROM `category`");
                    $select_categorys->execute();
                    if ($select_categorys->rowCount() > 0) {
                        while ($fetch_categorys = $select_categorys->fetch(PDO::FETCH_ASSOC)) {
                            ?>
                            <button type="button" class="btn m-2"><a class="text-decoration-none text-dark"
                                    href="index.php?category_id=<?= htmlspecialchars($fetch_categorys['id']); ?>">
                                    <?= htmlspecialchars($fetch_categorys['name']); ?>
                                </a>
                            </button>
                            <?php
                        }
                    } else {
                        echo '<p>No categories added yet!</p>';
                    }
                    ?>
                </div>
            </div>

            <div class="row g-0 container">
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-4 mt-3">
                    <?php
                    if ($select_products->rowCount() > 0) {
                        while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
                            ?>
                            <div class="col">
                                <div class="card shadow rounded h-100 view-card"
                                    data-product-id="<?= htmlspecialchars($fetch_products['id']); ?>">
                                    <div class="collection-img position-relative">
                                        <img class="rounded-top p-0 card-img-top custom-image-size"
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

                                        <p class="">
                                            <i class="fa fa-star text-danger"></i>
                                            <i class="fa fa-star text-danger"></i>
                                            <i class="fa fa-star text-danger"></i>
                                            <i class="fa fa-star text-danger"></i>
                                            <i class="fa fa-star text-danger"></i>
                                            <span class="list-inline-item text-dark">Rating 4.9</span>
                                        </p>

                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="d-block h5 " style="position: relative; color: #222;">
                                                <span style="text-decoration: line-through;">
                                                    $<?= htmlspecialchars($fetch_products['price'] + ($fetch_products['price'] * 0.15)); ?>
                                                </span>
                                            </span>
                                            <span class="fw-bold d-block h5">
                                                $<?= htmlspecialchars($fetch_products['price']); ?>
                                            </span>
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
                    } else {
                        echo '<p class="empty">No products found!</p>';
                    }
                    ?>
                </div>
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

    <section id="blogs" class="my-5">
        <div class="container">
            <div class="title text-center">
                <h2 class="position-relative d-inline-block mb-3">Famous Brand</h2>
                <div class="row g-3 mt-3">
                    <div class="col-md-4 col-lg-2 ">
                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRCXD4yQVYXXe6PEW15V5YzBjkZLBYegkvvD6l6bhFKU_4m02F2DMkob5ezxuOssqIFk5Q&usqp=CAU"
                            alt="" class="custom-image-style">
                    </div>
                    <div class="col-md-4 col-lg-2 ">
                        <img src="https://thumuadonghohieu.com/wp-content/uploads/2018/07/Logo-Dong-ho-Blancpain.jpg"
                            alt="" class="custom-image-style">
                    </div>
                    <div class="col-md-4 col-lg-2">
                        <img src="https://thumuadonghohieu.com/wp-content/uploads/2018/07/Logo-Dong-ho-Longines.jpg"
                            alt="" class="custom-image-style">
                    </div>
                    <div class="col-md-4 col-lg-2">
                        <img src="https://thumuadonghohieu.com/wp-content/uploads/2018/07/Logo-Dong-ho-Patek-Philippe-Nam-1920-Den-nam-1996.jpg"
                            alt="" class="custom-image-style">
                    </div>
                    <div class="col-md-4 col-lg-2">
                        <img src="https://thumuadonghohieu.com/wp-content/uploads/2018/07/Logo-Dong-ho-Breitling.jpg"
                            alt="" class="custom-image-style">
                    </div>
                    <div class="col-md-4 col-lg-2">
                        <img src="https://thumuadonghohieu.com/wp-content/uploads/2018/07/Logo-Dong-ho-IWC.jpg" alt=""
                            class="custom-image-style">
                    </div>
                    <div class="col-md-4 col-lg-2">
                        <img src="https://thumuadonghohieu.com/wp-content/uploads/2018/07/Logo-Dong-ho-Vacheron-Constantin.jpg"
                            alt="" class="custom-image-style">
                    </div>

                    <div class="col-md-4 col-lg-2">
                        <img src="https://thumuadonghohieu.com/wp-content/uploads/2018/07/Logo-Dong-ho-Hublot-Lich-su-va-Y-nghia.jpg"
                            alt="" class="custom-image-style">
                    </div>
                    <div class="col-md-4 col-lg-2">
                        <img src="https://thumuadonghohieu.com/wp-content/uploads/2018/07/Logo-Dong-ho-A-Lange-and-Sohne-nam-1948-Den-nay.jpg"
                            alt="" class="custom-image-style">
                    </div>
                    <div class="col-md-4 col-lg-2">
                        <img src="https://thumuadonghohieu.com/wp-content/uploads/2018/07/Logo-Dong-ho-IWC.jpg" alt=""
                            class="custom-image-style">
                    </div>
                    <div class="col-md-4 col-lg-2">
                        <img src="https://benhviendongho.com/wp-content/uploads/2020/10/Logo_breguets.jpg" alt=""
                            class="custom-image-style">
                    </div>
                    <div class="col-md-4 col-lg-2">
                        <img src="https://donghochat8668.com/wp-content/uploads/2023/04/logo-dong-ho-blancpain.webp"
                            alt="" class="custom-image-style">
                    </div>
                    <div class="col-md-4 col-lg-2">
                        <img src="https://thumuadonghohieu.com/wp-content/uploads/2018/07/Logo-Dong-ho-Vacheron-Constantin.jpg"
                            alt="" class="custom-image-style">
                    </div>

                    <div class="col-md-4 col-lg-2">
                        <img src="https://thumuadonghohieu.com/wp-content/uploads/2018/07/Logo-Dong-ho-Hublot-Lich-su-va-Y-nghia.jpg"
                            alt="" class="custom-image-style">
                    </div>
                    <div class="col-md-4 col-lg-2">
                        <img src="https://thumuadonghohieu.com/wp-content/uploads/2018/07/Logo-Dong-ho-Patek-Philippe-Nam-1920-Den-nam-1996.jpg"
                            alt="" class="custom-image-style">
                    </div>
                    <div class="col-md-4 col-lg-2">
                        <img src="https://thumuadonghohieu.com/wp-content/uploads/2018/07/Logo-Dong-ho-Breitling.jpg"
                            alt="" class="custom-image-style">
                    </div>
                    <div class="col-md-4 col-lg-2">
                        <img src="https://thumuadonghohieu.com/wp-content/uploads/2018/07/Logo-Dong-ho-IWC.jpg" alt=""
                            class="custom-image-style">
                    </div>
                    <div class="col-md-4 col-lg-2 ">
                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRCXD4yQVYXXe6PEW15V5YzBjkZLBYegkvvD6l6bhFKU_4m02F2DMkob5ezxuOssqIFk5Q&usqp=CAU"
                            alt="" class="custom-image-style">
                    </div>
                    <div class="col-md-4 col-lg-2 ">
                        <img src="https://thumuadonghohieu.com/wp-content/uploads/2018/07/Logo-Dong-ho-Blancpain.jpg"
                            alt="" class="custom-image-style">
                    </div>
                    <div class="col-md-4 col-lg-2">
                        <img src="https://thumuadonghohieu.com/wp-content/uploads/2018/07/Logo-Dong-ho-Longines.jpg"
                            alt="" class="custom-image-style">
                    </div>
                    <div class="col-md-4 col-lg-2">
                        <img src="https://thumuadonghohieu.com/wp-content/uploads/2018/07/Logo-Dong-ho-Vacheron-Constantin.jpg"
                            alt="" class="custom-image-style">
                    </div>

                    <div class="col-md-4 col-lg-2">
                        <img src="https://thumuadonghohieu.com/wp-content/uploads/2018/07/Logo-Dong-ho-Hublot-Lich-su-va-Y-nghia.jpg"
                            alt="" class="custom-image-style">
                    </div>
                    <div class="col-md-4 col-lg-2">
                        <img src="https://thumuadonghohieu.com/wp-content/uploads/2018/07/Logo-Dong-ho-Patek-Philippe-Nam-1920-Den-nam-1996.jpg"
                            alt="" class="custom-image-style">
                    </div>
                    <div class="col-md-4 col-lg-2 ">
                        <img src="https://thumuadonghohieu.com/wp-content/uploads/2018/07/Logo-Dong-ho-Blancpain.jpg"
                            alt="" class="custom-image-style">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <button onclick="topFunction()" id="myBtn" title="Quay lại đầu trang"><i class="fa-solid fa-arrow-up"></i></button>

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

        window.onload = function () {
            var modal = document.getElementById("myModal");
            var span = document.getElementsByClassName("close")[0];

            // Kích hoạt modal khi trang được tải
            modal.style.display = "block";

            // Đóng modal khi người dùng nhấp vào nút đóng
            span.onclick = function () {
                modal.style.display = "none";
            }

            // Đóng modal khi người dùng nhấp vào bất kỳ nơi nào bên ngoài modal
            window.onclick = function (event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            }
        }

    </script>

</body>
<div id="myModal" class="modal"
    style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 50%; max-width: 500px; height: auto; max-height: 100%;">
    <div class="modal-content"
        style="background-color: #fefefe; margin: auto; border: 1px solid #888; overflow-y: auto; position: relative;">
        <span class="close"
            style="color: black; font-size: 30px; position: absolute; top: 0px; right: 0; margin: 0px; cursor: pointer;">X</span>
        <img src="https://cdnphoto.dantri.com.vn/_uZ_bW6TZL5nH8TFyRkXXnHEyl4=/thumb_w/960/2021/02/06/dangquangdocx-1612593330945.png"
            alt="Popup Image">
    </div>
</div>

</html>



<?php

include_once __DIR__ . '/../partials/footer.php';