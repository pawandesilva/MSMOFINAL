<?php
session_start();
ob_start();
include '../functions.php';
include 'customer_layout.php';
if (!isset($_SESSION['USERID'])) {
    header("Location:login.php"); //if not log send to login page
}
?>
<style>
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f4f4f4;
        color: #333;
        margin: 0;
        padding: 0;
    }
    .form-container {
        max-width: 600px;
        margin: 50px auto;
        padding: 20px;
        background-color: #ffffff;
        border-radius: 15px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    h3 {
        color: #2c5f2d;
        font-size: 1.5em;
        margin-bottom: 20px;
        border-bottom: 2px solid #2c5f2d;
        padding-bottom: 5px;
    }
    label {
        font-weight: bold;
        display: block;
        margin-bottom: 5px;
        color: #2c5f2d;
    }
    input[type="text"], textarea {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: 2px solid #88b04b;
        border-radius: 10px;
        background-color: #f9f9f9;
        font-size: 1em;
        color: #333;
    }
    input[type="checkbox"] {
        margin-right: 10px;
        transform: scale(1.5);
    }
    textarea {
        resize: vertical;
        height: 100px;
    }
    button {
        background-color: #88b04b;
        color: white;
        padding: 15px 30px;
        border: none;
        border-radius: 10px;
        font-size: 1em;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }
    button:hover {
        background-color: #6e8c36;
    }
    .icon {
        margin-right: 5px;
        vertical-align: middle;
    }
</style>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    extract($_POST);
    $delivery_name = dataClean($delivery_name);
    $delivery_address = dataClean($delivery_address);
    $delivery_phone = dataClean($delivery_phone);
    $billing_name = dataClean($billing_name);
    $billing_address = dataClean($billing_address);
    $billing_phone = dataClean($billing_phone);

    $message = array();
    //Required validation-----------------------------------------------
    if (empty($delivery_name)) {
        $message['delivery_name'] = "The delivery name should not be blank...!";
    }
    if (empty($delivery_address)) {
        $message['delivery_address'] = "The delivery address is required";
    }
    if (empty($delivery_phone)) {
        $message['delivery_phone'] = "The delivery phone should not be blank...!";
    }
    if (!isset($billing_name)) {
        $message['billing_name'] = "The billing name is required";
    }
    if (empty($billing_address)) {
        $message['billing_address'] = "The billing address is required";
    }
    if (empty($billing_phone)) {
        $message['billing_phone'] = "The billing phone is required";
    }
    if (empty($message)) {
        $db = dbConn();
        $userid = $_SESSION['USERID'];
        $sql = "SELECT CustomerId FROM customers WHERE UserId=$userid";
        $result = $db->query($sql);
        $row = $result->fetch_assoc();
        $customerid = $row['CustomerId'];
        
        $order_date = date('Y-m-d');
        $sql2 = "SELECT id FROM orders ORDER BY id DESC LIMIT 1";
        $result2 = $db->query($sql2);
        $row2 = $result2->fetch_assoc();
        $order_id= $row2['id'];
        $order_id2=$order_id + 1;
        
        
        $order_number = 'O'.date('Y') . date('m') . date('d') . $order_id2;
        
        

        $sql = "INSERT INTO `orders`( `order_date`, `customer_id`, `delivery_name`, `delivery_address`, `delivery_phone`, `billing_name`, `billing_address`, `billing_phone`, `order_number` )"
                . " VALUES ('$order_date','$customerid ','$delivery_name','$delivery_address','$delivery_phone','$billing_name','$billing_address','$billing_phone','$order_number')";
        $db->query($sql);

        $order_id = $db->insert_id; //take last inserted id primary key

        $cart = $_SESSION['cart']; //assing the session cart to $cart variable

        foreach ($cart as $key => $value) {
            $stock_id = $value['stock_id'];
            $item_id = $value['item_id'];
            $unit_price = $value['unit_price'];
            $qty = $value['qty'];
            $sql = "INSERT INTO `order_items`(`order_id`, `item_id`, `stock_id`, `unit_price`, `qty`) VALUES "
                    . "('$order_id','$item_id','$stock_id','$unit_price','$qty')";
            $db->query($sql);
            $_SESSION['ONO']= $order_number;
            $msg = "<h1>SUCCESS</h1>";
            $msg = "<h1>Congratulations!!</h1>";
            $msg = "<p>Your Order has been successfully created.</p>";
        }
        header("Location:order_success.php");
    }
}
    ?>
    <div class="container-fluid contact py-5 mt-5">
        <div class="container py-5">
            <div class="p-5 bg-light rounded">
                <div class="row g-4">
                    <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" role="form"  novalidate>
                    <div class="text-center mx-auto mt-4" style="max-width: 700px;">
                        <h1 class="text-center underlined-heading " style="color: #935116">Delivery Details</h1>

                    </div>

                    <label for="delivery_name">Name:</label>
                    <input type="text" id="delivery_name" name="delivery_name" required><br>
                    <label for="delivery_address">Address:</label>
                    <textarea id="delivery_address" name="delivery_address" required></textarea><br>
                    <label for="delivery_phone">Phone:</label>
                    <input type="text" id="delivery_phone" name="delivery_phone" required><br>


                    <div class="text-center mx-auto mt-4" style="max-width: 700px;">
                        <h1 class="text-center underlined-heading " style="color: #935116">Billing Details</h1>

                    </div>
                    <input type="checkbox" id="same_as_delivery" name="same_as_delivery">
                    <label for="same_as_delivery">Same as Delivery Details</label><br>
                    <label for="billing_name">Name:</label>
                    <input type="text" id="billing_name" name="billing_name" required><br>
                    <label for="billing_address">Address:</label>
                    <textarea id="billing_address" name="billing_address" required></textarea><br>
                    <label for="billing_phone">Phone:</label>
                    <input type="text" id="billing_phone" name="billing_phone" required><br>
                    <button type="submit">Checkout</button>
                </form>
            </div></div></div></div>

<script>
    // Script to copy delivery details to billing details
    document.getElementById('same_as_delivery').addEventListener('change', function () {
        if (this.checked) {
            document.getElementById('billing_name').value = document.getElementById('delivery_name').value;
            document.getElementById('billing_address').value = document.getElementById('delivery_address').value;
            document.getElementById('billing_phone').value = document.getElementById('delivery_phone').value;
        } else {
            document.getElementById('billing_name').value = '';
            document.getElementById('billing_address').value = '';
            document.getElementById('billing_phone').value = '';
        }
    });
</script>
<?php
    ob_end_flush();
?>

