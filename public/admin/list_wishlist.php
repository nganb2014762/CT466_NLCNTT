<?php
session_start();
include_once __DIR__ . "../../../partials/admin_boostrap.php";
require_once __DIR__ . '../../../partials/connect.php';
$admin_id = $_SESSION['admin_id'];
if (!isset($admin_id)) {
    header('location:login.php');
}
;


if (isset($message)) {
    foreach ($message as $message) {
        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
            ' . htmlspecialchars($message) . '
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
             </div>';
    }
}


if (isset($_GET['delete'])) {

    $delete_id = $_GET['delete'];
    $delete_wishlist = $pdo->prepare("DELETE FROM `wishlist` WHERE id = ?");
    $delete_wishlist->execute([$delete_id]);
    header('location: list_wishlist.php');
}

?>

<title>List wishlist</title>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php
                include_once __DIR__ . "../../../partials/admin_header.php";
                ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Danh sách sản phẩm được yêu thích</h1>
                    </div>


                    <div class="table-responsive">
                        <form id="product-form" action="" method="POST" enctype="multipart/form-data"
                            class="text_center form-horizontal">
                            <table class="table text-center" style="border-collapse: collapse;">
                                <thead>
                                    <tr>
                                        <th scope="col" style="background-color: #0b6e4f; border: 1px solid #0b6e4f;">
                                            STT</th>
                                        <th scope="col" style="background-color: #0b6e4f; border: 1px solid #0b6e4f;">
                                            User ID</th>
                                        <th scope="col" style="background-color: #0b6e4f; border: 1px solid #0b6e4f;">
                                            Pid</th>
                                        <th scope="col" style="background-color: #0b6e4f; border: 1px solid #0b6e4f;">
                                            Image</th>
                                        <th scope="col" style="background-color: #0b6e4f; border: 1px solid #0b6e4f;">
                                            Name</th>
                                        <th scope="col" style="background-color: #0b6e4f; border: 1px solid #0b6e4f;">
                                            Price</th>
                                        <th scope="col" style="background-color: #0b6e4f; border: 1px solid #0b6e4f;">
                                            Delete</th>
                                    </tr>
                                </thead>
                                <tbody class="table-group-divider">
                                    <?php
                                    $i = 1;
                                    $select_wishlist = $pdo->prepare("SELECT * FROM wishlist");
                                    $select_wishlist->execute();
                                    if ($select_wishlist->rowCount() > 0) {
                                        while ($fetch_wishlist = $select_wishlist->fetch(PDO::FETCH_ASSOC)) {
                                            ?>
                                            <tr>
                                                <td class="pt-4" style="border: 1px solid #0b6e4f;">
                                                    <b><?= htmlspecialchars($i++); ?></b>
                                                </td>
                                                <td class="pt-4" style="border: 1px solid #0b6e4f;">
                                                    <?= htmlspecialchars($fetch_wishlist['user_id']); ?>
                                                </td>
                                                <td class="pt-4" style="border: 1px solid #0b6e4f;">
                                                    <?= htmlspecialchars($fetch_wishlist['pid']); ?>
                                                </td>
                                                <td class="pt-4" style="border: 1px solid #0b6e4f;">
                                                    <img src="uploaded_img/<?= htmlspecialchars($fetch_wishlist['image']); ?>"
                                                        alt="" style="width:100px; height:120px" />
                                                </td>
                                                <td class="pt-4" style="border: 1px solid #0b6e4f;">
                                                    <?= htmlspecialchars($fetch_wishlist['name']); ?>
                                                </td>
                                                <td class="pt-4" style="border: 1px solid #0b6e4f;">
                                                    <?= htmlspecialchars($fetch_wishlist['price']); ?>
                                                </td>
                                                <td class="pt-4" style="border: 1px solid #0b6e4f;">
                                                    <a class="btn btn-danger"
                                                        data-id="<?= htmlspecialchars($fetch_wishlist['id']); ?>"
                                                        data-toggle="modal" data-target="#deleteConfirmationModal">Delete</a>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    } else {
                                        echo "<tr><td colspan='7'>Không có dữ liệu.</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>

                        </form>
                    </div>
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="logout.php">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" role="dialog"
        aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteConfirmationModalLabel">Xác nhận xóa</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Bạn có chắc chắn muốn xóa dòng này?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                    <a id="deleteLink" href="" class="btn btn-danger">Xóa</a>
                </div>
            </div>
        </div>
    </div>


    <script>
        // JavaScript code to handle delete from modal
        $(document).ready(function () {
            $('#deleteConfirmationModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var Id = button.data('id');

                // Set the delete button link with productId
                var deleteLink = 'list_wishlist.php?delete=' + Id;
                $('#deleteLink').attr('href', deleteLink);
            });
        });
    </script>
    <?php
    include_once __DIR__ . '../../../partials/admin_footer.php';