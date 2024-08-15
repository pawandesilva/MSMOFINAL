<?php
ob_start();

include 'header.php';
include '../functions.php';
?>

<div class="container-fluid contact py-5 mt-5">
    <div class="container py-5">
        <div class="p-5 bg-light rounded">
            <div class="row g-4">
                <?php
                $db = dbConn();
                $sql = "SELECT item_stock.id ,items.item_name ,item_stock.qty , item_stock.unit_price ,item_category.category_name,items.description ,items.item_image FROM item_stock INNER JOIN items ON (items.id=item_stock.item_id) INNER JOIN item_category ON (item_category.id = items.item_category) GROUP BY items.id,item_stock.unit_price;";
                $result = $db->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        ?>
                        <div class="col-md-6 col-lg-3">
                            <div class="rounded position-relative fruite-item">
                                <div class="fruite-img">

                                    <img src="../uploads/<?= $row['item_image'] ?>" class="img-fluid w-100 rounded-top" alt="">
                                </div>
                                <div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;"><?= $row['category_name'] ?></div>
                                <div class="p-3 border border-secondary border-top-0 rounded-bottom">
                                    <h4><?= $row['item_name'] ?></h4>
                                    <p><?= $row['description'] ?></p>
                                    <div class="d-flex justify-content-between flex-lg-wrap">
                                        <p class="text-dark fs-5 fw-bold mb-0"><?= $row['unit_price'] ?></p>
                                        <form method="post" action ="shoping_cart.php">
                                            <input type="hidden" name="id" value="<?= $row['id'] ?> ">

                                            <input type="hidden" value="add_cart" name="operate">
                                            <button type="submit"  class="btn border border-secondary rounded-pill px-3 text-primary">
                                                add to cart
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                }
                ?>
            </div>
        </div>
    </div>
</div>

<?php
include 'footer.php';
ob_end_flush();
?>
  