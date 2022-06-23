<?php
/**
 * Include test library if you are using composer
 * Example: Psysh (debugging library similar to pry in Ruby)
 */

$item_data = $_POST['item_detail'];
$customer_data = $_POST['customer_detail'];
require_once dirname(__FILE__) . '/vendor/autoload.php';
// require_once("../../autoload.php");

require_once dirname(__FILE__) . '/vendor/midtrans/midtrans-php/Midtrans.php';
require_once dirname(__FILE__) . '/vendor/midtrans/midtrans-php/tests/MT_Tests.php';
require_once dirname(__FILE__) . '/vendor/midtrans/midtrans-php/tests/utility/MtFixture.php';

// Set your Merchant Server Key
\Midtrans\Config::$serverKey = 'SB-Mid-server-WLKYaqPo6P-yHb7yTbVmWuJq';
// Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
\Midtrans\Config::$isProduction = false;
// Set sanitization on (default)
\Midtrans\Config::$isSanitized = true;
// Set 3DS transaction for credit card to true
\Midtrans\Config::$is3ds = true;


// require_once('../model/Invoices.php');
require dirname(__FILE__) . '/model/Invoices.php';
// print_r(dirname(__DIR__) . '/model/Invoices.php');
// die;
$objInv = new \Invoices;
$objInv->set_first_name($customer_data['first_name']);
$objInv->set_last_name($customer_data['last_name']);
$objInv->set_email($customer_data['email']);
$objInv->set_phone($customer_data['phone']);
$objInv->set_status("pending");
$objInv->set_date_created(date('Y-m-d H:i:s'));
$objInv->set_transaction_id("");
$objInv->set_user_id($customer_data['user_id']);
$objInv->set_item_id($item_data['id']);
$objInv->set_amount($item_data['price']);
$oid = $objInv->create_invoice();

 
$params = array(
    'transaction_details' => array(
        'order_id' => $oid,
        'gross_amount' => (int) $item_data['price'],
    ),
    "item_details" => array(
        array(
            "id" => $item_data['id'],
            "price" => (int) $item_data['price'],
            "quantity" => (int) $item_data['quantity'],
            "name" => $item_data['name']
        )
    ),
    'customer_details' => array(
        'first_name' => $customer_data['first_name'],
        'last_name' => $customer_data['last_name'],
        // 'email' => $customer_data['email'],
         'email' => "imuttaqien17@gmail.com",
        'phone' => $customer_data['phone'],
    ),
);

$snapToken = \Midtrans\Snap::createTransaction($params);
$token = \Midtrans\Snap::getSnapToken($params);

$objInv->set_transaction_id($token);
$objInv->set_order_id($oid);
$objInv->update_snap_token();

$order_id=$params['transaction_details']['order_id'];
$transaction_id=$snapToken->token;

print_r($token);