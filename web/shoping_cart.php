<?php
ob_start();
session_start();
include '../functions.php';

extract($_POST);

if($_SERVER['REQUEST_METHOD']=='POST' && $operate == 'add_cart'){//check whether clicked ther operate button 
    $db= dbConn();
     $sql="SELECT * FROM item_stock INNER JOIN items ON (items.id = item_stock.item_id) WHERE item_stock.id='$id'";
    $result=$db->query($sql);
    //cart[1]=array("stock)id"=>'1',"item_id"=>'1',"qty"=>'2',"price"=>'300');
    $row = $result->fetch_assoc();
    if(isset($_SESSION['cart']) && isset($_SESSION['cart'][$id])){//check session cart is created and id is there
        $current_qty = $_SESSION['cart'][$id]['qty']+=1;//
    }else{
        $current_qty =1;//make current quenty at 1 at first time purchasing
        
    }
    //use session variable  cart and make arrays of purchasing products
     $_SESSION['cart'][$id]= array('stock_id'=>$row['id'],'item_id'=>$row['item_id'],'item_name'=>$row['item_name'],'unit_price'=>$row['unit_price'],'item_image'=>$row['item_image'] , 'qty'=>$current_qty);
     print_r($_SESSION['cart']);

     header('Location:product.php');//redirrect tp product page
}
ob_end_flush();
