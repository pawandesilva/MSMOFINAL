<?php
ob_start();
session_start(); //session_start() creates a session or resumes the current one based on a session identifier passed via a GET or POST request, or passed via a cookie.
include_once '../init.php';
$link = "Production Management";
$breadcrumb_item = "Production";
$breadcrumb_item_active = "add_item";
?>


<div class="tab-content" id="add_item">
    <!-- add item Tab -->
    <div class="row">
        <div class="col-12">
            <a href="" class="btn btn-success mb-2"><i class="fas fa-plus-circle"></i> New Item</a>
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Add Product</h3>
                </div>
                <div class="tab-pane fade show active" id="add-item" role="tabpanel" aria-labelledby="add-item-tab">
                    <div class="card-body">
                        <?php
                        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                            extract($_POST);

                            $item_name = dataClean($item_name);
                            $description = dataClean($description);

                            $message = array();
                            //required validation----------------------------

                            if (empty($item_name)) {
                                $message['item_name'] = "The item name should not be empty..!";
                            }
                            if (empty($category)) {
                                $message['category'] = "The item category should not be empty..!";
                            }

                            if (!empty($_FILES['item_image']['name'])) {
                                $file = $_FILES['item_image'];
                                $location = "../../uploads";
                                $uploadResult = uploadFile($file, $location);
                                if ($uploadResult['upload']) {
                                    $item_image = $uploadResult['file'];
                                } else {
                                    $error = $uploadResult['error_file'];

                                    $message['item_image'] = "<br>Image Upload failed:$error";
                                }
                            } else {
                                $message['item_image'] = "Please Upload the product image..!";
                            }


                            if (empty($message)) {
                                $db = dbConn();
                                echo $sql = "INSERT INTO `items`(`item_name`, `item_category`,  `description`,`item_image`) VALUES ('$item_name','$category','$description','$item_image')";
                                $db->query($sql);
                                header("Location:manage.php");
                            }
                        }
                        ?>

                        <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" role="form" enctype="multipart/form-data" novalidate >
                            <div class="form-group ">
                                <label for="item_name">Item Name</label>
                                <input type="text" name="item_name" class="form-control " id="item_name"  placeholder="Item Name" required>
                                <span class="text-danger"><?= @$message['item_name'] ?></span>
                            </div>
                            <div class="form-group">
                                <?php
                                $db = dbConn();
                                $sql = "SELECT * FROM item_category";
                                $result = $db->query($sql);
                                ?>
                                <label for="category">Item Category</label><br><!-- comment -->
                                <select name="category" id="category" class=" col-12 height-control form-control-lg ">
                                    <option value=" ">--</option>
                                    <?php
                                    while ($row = $result->fetch_assoc()) {
                                        ?>
                                        <option value="<?= $row['id'] ?>"<?= @$id == $row['id'] ? 'selected' : '' ?>><?= $row['category_name'] ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                                <span class="text-danger"><?= @$message['category'] ?></span>

                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea name="description" class="form-control" id="description"></textarea>

                            </div>

                            <div>
                                <!-- Image upload button-->
                                <label for="item_image">Upload Image</label><br>
                                <input type="file" id="item_image" name="item_image" accept="image/*" class="form-group mt-3 mb-5">
                                <span class="text-danger"><?= @$message['item_image'] ?></span>
                            </div>



                            <input type="submit" value="Add Product" class="btn btn-primary" >


                        </form>
                    </div>

                </div>    
            </div>   
        </div> 
    </div>
</div>
<?php
$content = ob_get_clean();
include '../layouts.php'; //lay out file in out 2 steps behind
?>