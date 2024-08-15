<?php
ob_start();

include 'header.php';
include '../functions.php'; //one upon the web file the function file exist

extract($_GET);
if($_SERVER['REQUEST_METHOD']=='GET' && @$action=='del'){
    $cart=$_SESSION['cart'];
    unset($cart[$id]);//unset used to removing
    $_SESSION['cart']=$cart;
    //remove the item from the table
}
if($_SERVER['REQUEST_METHOD']=='GET' && @$action=='empty'){
    $_SESSION['cart']=array();//make the session cart into blank and empty the cart
    
}
?>

<style>
            table {
                width: 100%;
                border-collapse: collapse;
            }
            th, td {
                border: 1px solid #dddddd;
                text-align: left;
                padding: 8px;
            }
            th {
                background-color: #f2f2f2;
            }
        </style>
    <div class="container-fluid contact py-5">
    <div class="container py-5">
        <div class="p-5 bg-light rounded">
            <div class="row g-4">
                <div class="col-12">
                    
                    <a href="cart.php?action=empty">Empty Cart</a>
                    <table border="1" class="table table-striped" width="100%" style="border: 1px solid #055160">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Product Image</th>
                                <th>Product Name</th>
                                <th>Price</th>
                                <th>Qty</th>
                                <th>Amount</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            
                            $total = 0;
                            foreach($_SESSION['cart'] as $key=>$value){//seperate key and value of session values
                                ?>
                            
                            <tr>
                                <td></td>
                                <td><?=$value['item_image']?></td>
                                <td><?= $value['item_name']?></td>
                                <td><?= $value['unit_price']?></td>
                                <td><?= $value['qty']?></td>
                                <td ><?php $amt=$value['unit_price'] * $value['qty'];
                                $total+= $amt; echo number_format($amt,2); ?></td>
                                <td><a href="cart.php?id=<?=$key ?>&action=del">Remove</a></td>
                            </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td></td>
                                <td>Total</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td style="text-align: right"><?= number_format($total,2)?></td>
                            </tr>
                        </tfoot>
                    </table>
                    <a href="checkout.php"><strong>CheckOut</strong></a>
                </div>
                    
            </div>
                
        </div>
            
    </div>
            </div>

<?php
include 'footer.php';
ob_end_flush();
?>
