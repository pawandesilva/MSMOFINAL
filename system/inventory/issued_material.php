<?php
include_once '../init.php'; 

$db= dbConn();
$issue_qty = 100;
$material = 1;
while ($issue_qty > 0){//while work recursively to FIFI
    
    $sql="SELECT * FROM raw_material_stock WHERE MaterialId=1 AND (Amount - COALESCE(IssuedAmount, 0)) > 0 ORDER BY DATE ASC LIMIT 1";
    $result =$db->query($sql);
    
    if($result->num_rows > 0){
        $row = $result->fetch_assoc();
        
        //calculate the remaining amount
        $remaining_qty =$row['Amount'] - ($row['IssuedAmount'] ?? 0); //if the issued qty is null change it to 0
        //if the issued qty is less than the remaining qty
        if($issue_qty <= $remaining_qty){// check the issued qty is less than remaining amount
            $i_qty =$issue_qty;
            $s_id =$row['LotNo'];
            $sql ="UPDATE raw_material_stock SET IssuedAmount = COALESCE(IssuedAmount , 0) + $i_qty WHERE LotNo =$s_id ";
            $db->query($sql);//run the query
            $issue_qty =0;
        }else{
            $i_qty = $remaining_qty;
            $s_id =$row['LotNo'];
              $sql ="UPDATE raw_material_stock SET IssuedAmount = COALESCE(IssuedAmount , 0) + $i_qty WHERE LotNo =$s_id ";
              $db->query($sql);
              $issue_qty -= $i_qty;//decrement from issued qty
              
              
              
        }
            
        
    }else{
        break;
    }
}
?>