<?php

session_start();
include '../functions.php';

extract($_POST);

if($_SERVER['REQUEST_METHOD']=='POST' && $operate == 'add_cart'){
    
    $db= dbConn();
     $sql="SELECT * FROM item_stock INNER JOIN items ON (items.id = item_stock.item_id) WHERE item_stock.id='$id'";
    $result=$db->query($sql);
    //cart[1]=array("stock)id"=>'1',"item_id"=>'1',"qty"=>'2',"price"=>'300');
    $row = $result->fetch_assoc();
    if(isset($_SESSION['cart']) && isset($_SESSION['cart'][$id])){
        $current_qty = $_SESSION['cart'][$id]['qty']+=1;
    }else{
        $current_qty =1;
        
    }
    //use session variable  cart and make arrays of purchasing products
     $_SESSION['cart'][$id]= array('stock_id'=>$row['id'],'item_id'=>$row['item_id'],'item_name'=>['item_name'],'unit_price'=>$row['unit_price'],'qty'=>$current_qty);
     //print_r($_SESSION['cart']);
    header('Location:product.php');//redirrect tp product page
}

