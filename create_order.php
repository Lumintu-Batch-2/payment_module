<?php
/**
 * Include test library if you are using composer
 * Example: Psysh (debugging library similar to pry in Ruby)
 */

// PHP Error Display
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$item_data = $_POST['item_detail'];
$customer_data = $_POST['customer_detail'];
require_once dirname(__FILE__) . '/vendor/autoload.php';

use \PHPMailer\PHPMailer\Exception;
use \PHPMailer\PHPMailer\PHPMailer;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
$dotenv->required('MIDTRANS_SERVER_KEY')->notEmpty();
$dotenv->required('IS_PRODUCTION')->notEmpty();

require_once dirname(__FILE__) . '/vendor/midtrans/midtrans-php/Midtrans.php';
require_once dirname(__FILE__) . '/vendor/midtrans/midtrans-php/tests/MT_Tests.php';
require_once dirname(__FILE__) . '/vendor/midtrans/midtrans-php/tests/utility/MtFixture.php';

// Set your Merchant Server Key
\Midtrans\Config::$serverKey = $_ENV['MIDTRANS_SERVER_KEY'];
// Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
\Midtrans\Config::$isProduction = filter_var($_ENV['IS_PRODUCTION'], FILTER_VALIDATE_BOOLEAN);
// Set sanitization on (default)
\Midtrans\Config::$isSanitized = true;
// Set 3DS transaction for credit card to true
\Midtrans\Config::$is3ds = true;


require dirname(__FILE__) . '/model/Invoices.php';

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
        'email' => $customer_data['email'],
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

$mail = new PHPMailer(true);

$mail->SMTPDebug = 0;                      //Enable verbose debug output
$mail->isSMTP();                                            //Send using SMTP
$mail->Host       = 'in-v3.mailjet.com';                     //Set the SMTP server to send through
$mail->SMTPAuth   = true;                                   //Enable SMTP authentication
$mail->Username   = 'f052c8ac3350d05e7fc2edacab7dd80b';                     //SMTP username
$mail->Password   = '52ad616d3b5dced32f1e6909a82cf9f0';                               //SMTP password
$mail->SMTPSecure = 'tls';            //Enable implicit TLS encryption
$mail->Port       = 587;  

$mail->setFrom('admin@oembah.xyz', 'Lumintu Logic');
$mail->addReplyTo('admin@oembah.xyz', 'Information');
$mail->addAddress($customer_data['email'], $customer_data['first_name'] . " " . $customer_data['last_name']);

$mail->isHTML(true);                                  //Set email format to HTML
$mail->Subject = 'Menunggu Pembayaran untuk order_id = ' . $order_id;
$mail->Body    = file_get_contents('templates/email_confirm.html');
// $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

$key = array('{price}', '{url_bayar}');
$val = array($params['transaction_details']['gross_amount'], "https://app.midtrans.com/snap/v2/vtweb/" . $token);

$mail->Body = str_replace($key, $val, $mail->Body);

if($mail->send()) {
    print_r('Message has been sent');
}

print_r($token);