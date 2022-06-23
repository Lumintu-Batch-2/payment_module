<?php

    session_start();

    require_once('../model/Items.php');
    require_once('../controllers/get_request.php');

    $objItem = new Items();
    $items = $objItem->get_all_items();

    $user_id = $_SESSION['user_data']->{'user'}->{'user_id'}; 
    $user_first_name = $_SESSION['user_data']->{'user'}->{'user_first_name'}; 
    $user_last_name = $_SESSION['user_data']->{'user'}->{'user_last_name'}; 
    $user_email = $_SESSION['user_data']->{'user'}->{'user_email'}; 
    $user_phone = $_SESSION['user_data']->{'user'}->{'user_phone'};

    echo "<input type='hidden' id='userId' value='" . $user_id . "'>";
    echo "<input type='hidden' id='userFirstName' value='" . $user_first_name . "'>";
    echo "<input type='hidden' id='userLastName' value='" . $user_last_name . "'>";
    echo "<input type='hidden' id='userEmail' value='" . $user_email . "'>";
    echo "<input type='hidden' id='userPhone' value='" . $user_phone . "'>";


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index</title>

    <!-- Jquery -->
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>

</head>
<body>
    <?php for($i = 0; $i < count($items); $i++) { ?>
        <div class="">
            <p><?= $items[$i]['name']; ?></p>
            <p><?= $items[$i]['desc']; ?></p>
            <p><?= $items[$i]['price']; ?></p>
            <input type="hidden" id="title<?=$items[$i]['item_id']?>" value="<?=$items[$i]['name']?>">
            <input type="hidden" id="price<?=$items[$i]['item_id']?>" value="<?=$items[$i]['price']?>">
            <button onclick="createOrder(<?= $items[$i]['item_id']; ?>)">Order</button>
        </div>
    <?php  } ?>

    <script>
        let createOrder = (id) => {

            const URL_PAYMENT = "https://app.sandbox.midtrans.com/snap/v2/vtweb/";

            // Item Data
            let itemId =  id;
            let itemName = $('#title' + id).val();
            let itemPrice = $('#price' + id).val();
            let itemQty = 1;

            let itemData = {
                "id": itemId,
                "price": itemPrice,
                "name": itemName,
                "quantity": 1
            }

            // console.log(itemData);

            // User Data
            let userId = $('#userId').val();
            let userFirstName = $('#userFirstName').val();
            let userLastName = $('#userLastName').val();
            let userEmail = $('#userEmail').val();
            let userPhone = $('#userPhone').val();

            let userData = {
                "user_id": userId,
                "first_name": userFirstName,
                "last_name": userLastName,
                "email": userEmail,
                "phone": userPhone
            }

            // console.log(userData);

            $.ajax({
                url: '../create_order.php',
                type: 'post',
                data: {
                    "item_detail": itemData,
                    "customer_detail": userData
                },
                success: function(res) {
                    location.replace(URL_PAYMENT + res);
                }
            })

        }
    </script>
</body>
</html>
