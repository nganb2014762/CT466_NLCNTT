<?php
ob_start();
include_once __DIR__ . '../../partials/boostrap.php';
include_once __DIR__ . '../../partials/header.php';
require_once __DIR__ . '../../partials/connect.php';

if (isset($_POST['add_to_wishlist'])) {
   $pid = $_POST['pid'];
   $p_name = $_POST['p_name'];
   $p_price = $_POST['p_price'];
   $p_image = $_POST['p_image'];

   $check_wishlist_numbers = $pdo->prepare("SELECT * FROM `wishlist` WHERE name = :p_name AND user_id = :user_id");
   $check_wishlist_numbers->execute([':p_name' => $p_name, ':user_id' => $user_id]);
   if ($check_wishlist_numbers->rowCount() > 0) {
      $message[] = 'already added to wishlist!';
   } else {
      $insert_wishlist = $pdo->prepare("INSERT INTO `wishlist`(user_id, pid, name, price, image) VALUES(?,?,?,?,?)");
      $insert_wishlist->execute([$user_id, $pid, $p_name, $p_price, $p_image]);
      $message[] = 'added to wishlist!';
   }
}
;

if (isset($_POST['add_to_cart'])) {
   $pid = $_POST['pid'];
   $p_name = $_POST['p_name'];
   $p_price = $_POST['p_price'];
   $p_image = $_POST['p_image'];
   $p_qty = $_POST['p_qty'];

   $check_cart_numbers = $pdo->prepare("SELECT * FROM `cart` WHERE name = ? AND user_id = ?");
   $check_cart_numbers->execute([$p_name, $user_id]);

   if ($check_cart_numbers->rowCount() > 0) {
      $update_qty = $pdo->prepare("UPDATE `cart` SET quantity = quantity + ? WHERE name = ? AND user_id = ?");
      $update_qty->execute([$p_qty, $p_name, $user_id]);
      $message[] = 'Quantity updated in cart!';
   } else {
      $insert_cart = $pdo->prepare("INSERT INTO `cart`(user_id, pid, name, price, quantity, image) VALUES(?,?,?,?,?,?)");
      $insert_cart->execute([$user_id, $pid, $p_name, $p_price, $p_qty, $p_image]);
      $message[] = 'added to cart!';
   }
}
;

if (isset($_POST['send'])) {
   if (isset($_SESSION['user_id'])) {
      $user_id = $_SESSION['user_id'];
      $comment = $_POST['comment'];
      $pid = $_GET['pid'];
      $image = null;

      if (isset($_GET['pid'])) {
         $pid = $_GET['pid'];
         try {
            if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
               $image_name = $_FILES['image']['name'];
               $temp_image_path = $_FILES['image']['tmp_name'];
               $uploads_directory = 'admin/uploaded_img/reviews/';

               $image = $uploads_directory . $image_name;

               move_uploaded_file($temp_image_path, $image);

               $insert_comment = $pdo->prepare("INSERT INTO `reviews` (user_id, pid, comment, image) VALUES (?, ?, ?, ?)");
               $insert_comment->execute([$user_id, $pid, $comment, $image_name]);
            } else {
               $insert_comment = $pdo->prepare("INSERT INTO `reviews` (user_id, pid, comment) VALUES (?, ?, ?)");
               $insert_comment->execute([$user_id, $pid, $comment]);
            }


            header('Location:view_page.php?pid=' . $pid);
            exit();
         } catch (PDOException $e) {
            $message[] = "Lỗi khi thực hiện truy vấn: " . $e->getMessage();
         }
      } else {
         $message[] = "Không tìm thấy sản phẩm!";
      }
   } else {
      $_SESSION['comment'] = 'Bạn cần đăng nhập để đánh giá sản phẩm.';
   }
}
;
?>

<title>Features Product</title>
</head>

<body>
   <!-- quick-view -->
   <section id="quick-view" class="pt-5">
      <div class="container">
         <div class="title text-center mt-5 pt-5">
            <h2 class="position-relative d-inline-block">Details</h2>
         </div>
         <?php
         if (isset($message)) {
            foreach ($message as $message) {
               echo '<div class="alert alert-warning alert-dismissible fade show col-6 offset-3" role="alert" tabindex="-1">
                            ' . htmlspecialchars($message) . '
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                          </div>';
            }
         }
         ;
         ?>
         <div class="container align-text-center">
            <div class="row">
               <?php
               $pid = $_GET['pid'];
               $select_products = $pdo->prepare("SELECT products.*, category.name as category_name FROM `products` 
               JOIN category ON products.category_id = category.id WHERE products.id = ?");
               $select_products->execute([$pid]);
               if ($select_products->rowCount() > 0) {
                  while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
                     ?>
                     <div class="col-lg-4 mt-5 offset-1">
                        <div class="card mb-3">
                           <img class="card-img img-fluid"
                              src="admin/uploaded_img/<?= htmlspecialchars($fetch_products['image']); ?>" alt="Card image cap"
                              id="product-detail">
                        </div>
                        <div class="row">
                           <!--Start Controls-->
                           <div class="col-1 align-self-center">
                              <a href="#multi-item-example" role="button" data-bs-slide="prev">
                                 <i class="text-dark fas fa-chevron-left"></i>
                                 <span class="sr-only">Previous</span>
                              </a>
                           </div>
                           <!--End Controls-->
                           <!--Start Carousel Wrapper-->
                           <div id="multi-item-example" class="col-10 carousel slide carousel-multi-item pointer-event"
                              data-bs-ride="carousel">
                              <!--Start Slides-->
                              <div class="carousel-inner product-links-wap" role="listbox">

                                 <!--First slide-->
                                 <div class="">
                                    <div class="row">
                                       <div class="col-4">
                                          <a href="#">
                                             <img class="card-img img-fluid"
                                                src="admin/uploaded_img/<?= htmlspecialchars($fetch_products['image']); ?>"
                                                alt="Product Image 1">
                                          </a>
                                       </div>
                                       <div class="col-4">
                                          <a href="#">
                                             <img class="card-img img-fluid"
                                                src="admin/uploaded_img/<?= htmlspecialchars($fetch_products['image']); ?>"
                                                alt="Product Image 2">
                                          </a>
                                       </div>
                                       <div class="col-4">
                                          <a href="#">
                                             <img class="card-img img-fluid"
                                                src="admin/uploaded_img/<?= htmlspecialchars($fetch_products['image']); ?>"
                                                alt="Product Image 3">
                                          </a>
                                       </div>
                                    </div>
                                 </div>

                                 
                                 <!--/.First slide-->

                                 
                              </div>
                              <!--End Slides-->
                           </div>
                           <!--End Carousel Wrapper-->
                           <!--Start Controls-->
                           <div class="col-1 align-self-center">
                              <a href="#multi-item-example" role="button" data-bs-slide="next">
                                 <i class="text-dark fas fa-chevron-right"></i>
                                 <span class="sr-only">Next</span>
                              </a>
                           </div>
                           <!--End Controls-->
                        </div>
                     </div>
                     <!-- col end -->
                     <div class="col-lg-6 mt-5" >
                        <div class="card" style="background-color:antiquewhite">
                           <div class="card-body">
                              <form action="" method="POST" onsubmit="return addToCart();" onsubmit="return addToWishlist();">
                                 <div class="row">
                                    <div class="col-11">
                                       <h2 class="card-text text-capitalize fw-bold">
                                          <?= htmlspecialchars($fetch_products['name']); ?>
                                       </h2>
                                    </div>
                                    <div class="col-1 text-end">
                                       <?php
                                       // Kiểm tra xem sản phẩm có trong danh sách yêu thích hay không
                                       $check_wishlist = $pdo->prepare("SELECT * FROM `wishlist` WHERE pid = ? AND user_id = ?");
                                       $check_wishlist->execute([$fetch_products['id'], $user_id]);
                                       if ($check_wishlist->rowCount() > 0) {
                                          // Nếu sản phẩm đã có trong danh sách yêu thích, thêm lớp "text-danger" để đổi màu icon thành đỏ
                                          echo '<button class="text-capitalize border-0 " type="submit" name="delete_wishlist" style="background-color:antiquewhite">
                                                   <i class="fa-solid fa-heart fa-lg text-danger heart" ></i>
                                                 </button>';
                                       } else {
                                          // Nếu sản phẩm chưa có trong danh sách yêu thích, giữ màu icon là mặc định
                                          echo '<button class="text-capitalize border-0 " type="submit" name="add_to_wishlist" style="background-color:antiquewhite">
                                                   <i class="fa-regular fa-heart fa-lg text-dark heart"></i>
                                                 </button>';
                                       }
                                       ?>
                                    </div>
                                 </div>
                                 <p class="h3">$
                                    <?= htmlspecialchars($fetch_products['price']); ?>
                                 </p>
                                 <p class="">
                                    <i class="fa fa-star text-warning"></i>
                                    <i class="fa fa-star text-warning"></i>
                                    <i class="fa fa-star text-warning"></i>
                                    <i class="fa fa-star text-warning"></i>
                                    <i class="fa fa-star text-secondary"></i>
                                    <span class="list-inline-item text-dark">Rating 4.9 | 22 Comments</span>
                                 </p>
                                 <ul class="list-inline m-0">
                                    <li class="list-inline-item">
                                       <h6>Category:</h6>
                                    </li>
                                    <li class="list-inline-item">
                                       <p class="text-muted text-capitalize">
                                          <?= htmlspecialchars($fetch_products['category_name']); ?>
                                       </p>
                                    </li>
                                 </ul>
                                 <h6>Description:</h6>
                                 <p class="text-capitalize">
                                    <?= htmlspecialchars($fetch_products['details']); ?>
                                 </p>

                                 <ul class="list-inline">
                                    <li class="list-inline-item text-right h6">
                                       Quantity:
                                    </li>
                                    <input type="number" min="1" max="<?= htmlspecialchars($fetch_products['quantity']); ?>"
                                       value="1" name="p_qty" class="qty" style="width: 100px;" />
                                    <button class="buy-btn text-capitalize" type="submit" name="add_to_cart">
                                       Add To Cart</button>
                                 </ul>


                                 <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
                                 <input type="hidden" name="p_name" value="<?= $fetch_products['name']; ?>">
                                 <input type="hidden" name="p_price" value="<?= $fetch_products['price']; ?>">
                                 <input type="hidden" name="p_image" value="<?= $fetch_products['image']; ?>">
                              </form>
                           </div>
                        </div>
                     </div>
                     <?php
                  }
               } else {
                  echo '<p class="empty text-capitalize">no products added yet!</p>';
               }
               ?>
            </div>
         </div>
   </section>
   <!-- end of quick-view -->


   <!-- Reviews -->
   <section id="reviews" class="">
      <div class="container">
         <div class="title text-center mt-5 pt-5">
            <h2 class="position-relative d-inline-block">Reviews</h2>
         </div>

         <div class="container pt-5">
            <div class="row d-flex">

               <div class="col-7">
                  <div class="card border-2">
                     <div class="card-body p-2">
                        <?php
                        $loggedIn = isset($_SESSION['user_id']);

                        if ($loggedIn) {
                           if (isset($_GET['pid'])) {
                              $pid = $_GET['pid'];

                              $select_comment = $pdo->prepare('SELECT reviews.comment, reviews.image, reviews.review_time, user.name FROM `reviews` 
                                    INNER JOIN `user` ON user.id = reviews.user_id 
                                    WHERE reviews.pid = ?');
                              $select_comment->execute([$pid]);

                              if ($select_comment && $select_comment->rowCount() > 0) {
                                 while ($fetch_comments = $select_comment->fetch(PDO::FETCH_ASSOC)) {
                                    ?>

                                    <div class="row">
                                       <div class="col-2">
                                          <img src="img/account/u3.jpg" alt="Review Avatar" class="img-fluid rounded-circle"
                                             width="100" height="100">
                                       </div>

                                       <div class="col-10">
                                          <h6 class="text-capitalize">
                                             <?= htmlspecialchars($fetch_comments['name']); ?>
                                          </h6>
                                          <p class="text-muted"><small>
                                                <?= date("M j, Y", strtotime($fetch_comments['review_time'])); ?>
                                             </small></p>
                                          <p class="text-capitalize">
                                             <?= htmlspecialchars($fetch_comments['comment']); ?>
                                          </p>
                                          <?php if (!empty($fetch_comments['image'])) { ?>
                                             <img src="admin/uploaded_img/reviews/<?= htmlspecialchars($fetch_comments['image']); ?>"
                                                alt="Review Image" class="img-fluid mt-2" style="max-height: 150px;">
                                          <?php } ?>
                                       </div>
                                    </div>
                                    <hr>
                                    <?php
                                 }
                              } else {
                                 echo '<div class="alert alert-warning" role="alert">No reviews yet!</div>';
                              }
                           } else {
                              echo '<div class="alert alert-warning" role="alert">No product selected!</div>';
                           }
                        } else {
                           echo '<div class="alert alert-warning" role="alert">Login to leave a review!</div>';
                        }
                        ?>
                     </div>
                  </div>
               </div>

               <div class="col-5">
                  <div class="card">
                     <div class="card-body">
                        <h5 class="text-center text-capitalize">Enter a review</h5>
                        <form action="" method="POST" enctype="multipart/form-data">
                           <textarea class="form-control mt-2" name="comment" placeholder="Write your review"
                              rows="6"></textarea>
                           <div class="mb-3 mt-2">
                              <label for="image" class="form-label">Upload Image (optional)</label>
                              <input type="file" class="form-control" name="image" id="image">
                           </div>
                           <div class="d-grid gap-2">
                              <button class="btn btn-primary" type="submit" name="send">Send</button>
                           </div>
                        </form>
                     </div>
                  </div>
               </div>

            </div>
         </div>
      </div>
   </section>
   <!-- end of Reviews -->
   <?php
   include_once __DIR__ . '../../partials/footer.php';
   ?>
   </div>
   </div>
   <!-- end of container -->
</body>

</html>