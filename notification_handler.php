<?php

require_once 'vendor/autoload.php';
require_once dirname(__FILE__) . '/vendor/midtrans/midtrans-php/Midtrans.php';

// PHP Error Display
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use \PHPMailer\PHPMailer\PHPMailer;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
$dotenv->required('MIDTRANS_SERVER_KEY')->notEmpty();
$dotenv->required('IS_PRODUCTION')->notEmpty();

\Midtrans\Config::$isProduction = filter_var($_ENV['IS_PRODUCTION'], FILTER_VALIDATE_BOOLEAN);
\Midtrans\Config::$serverKey = $_ENV['MIDTRANS_SERVER_KEY'];

$notif = new \Midtrans\Notification();

$transaction_status = $notif->transaction_status;
$payment_type = $notif->payment_type;
$order_id = $notif->order_id;
$payment_date = $notif->transaction_time;
$amount = $notif->gross_amount;

$message = 'ok';

$mail = new PHPMailer(true);

// Mail Configuration
$mail->SMTPDebug = 0;
$mail->isSMTP();
$mail->Host       = 'in-v3.mailjet.com';
$mail->SMTPAuth   = true;
$mail->Username   = $_ENV['MAILTRAP_USERNAME'];
$mail->Password   = $_ENV['MAILTRAP_PASSWORD'];
$mail->SMTPSecure = 'tls';
$mail->Port       = 587;  

require dirname(__FILE__) . '/model/Payments.php';
$objPay = new Payments;

$objPay->set_order_id($order_id);
$objPay->set_amount($amount);
$objPay->set_payment_date($payment_date);
$objPay->set_payment_type($payment_type);
$objPay->set_status($transaction_status);
$check = $objPay->payment_check();

(!$check) ? $objPay->create_payment() : $objPay->update_payment_status();
$payment = $objPay->get_total_amount();
$total_payment_amount = $payment['amount'];

require dirname(__FILE__) . '/model/Invoices.php';
$objInv = new Invoices;
$objInv->set_order_id($order_id);
$invoice = $objInv->get_invoice();
$invoice_amount = $invoice['amount'];

$mail->setFrom($_ENV['MAILTRAP_EMAIL'], 'Lumintu Logic');
$mail->addReplyTo($_ENV['MAILTRAP_EMAIL'], '<no-reply>');
$mail->addAddress($invoice['email'], $invoice['first_name'] . " " . $invoice['last_name']);


if ($transaction_status == 'capture') {
    // For credit card transaction, we need to check whether transaction is challenge by FDS or not
    if ($type == 'credit_card') {
        if ($fraud == 'challenge') {
            // TODO set payment status in merchant's database to 'Challenge by FDS'
            // TODO merchant should decide whether this transaction is authorized or not in MAP
            $message = "Transaction order_id: " . $order_id . " is challenged by FDS";
        } else {
            // TODO set payment status in merchant's database to 'Success'
            $message = "Transaction order_id: " . $order_id . " successfully captured using " . $type;
        }
    }
    if($total_payment_amount == $invoice_amount) {
        $objInv->set_status('paid');
        $objInv->update_status();

        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Pembayaran berhasil untuk order_id = ' . $order_id;
        $mail->Body    = file_get_contents('templates/email_success.html');

        $key = array('{order_id}', '{product_id}', '{price}', '{status}', '{payment_method}');
        $val = array($order_id, $invoice['item_id'], $amount, $transaction_status, $payment_type);

        $mail->Body = str_replace($key, $val, $mail->Body);
        $mail->send();
    }
} elseif ($transaction_status == 'settlement') {
    // TODO set payment status in merchant's database to 'Settlement'
    if($total_payment_amount == $invoice_amount) {
        $objInv->set_status('paid');
        $objInv->update_status();

        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Pembayaran berhasil untuk order_id = ' . $order_id;
        $mail->Body    = file_get_contents('templates/email_success.html');

        $key = array('{order_id}', '{product_id}', '{price}', '{status}', '{payment_method}');
        $val = array($order_id, $invoice['item_id'], $amount, $transaction_status, $payment_type);

        $mail->Body = str_replace($key, $val, $mail->Body);
        $mail->send();
    }
    $message = "Transaction order_id: " . $order_id . " successfully transfered using " . $type . " Pada tanggal " . $tanggal . "Dibayar dengan uang ". $matauang;
} elseif ($transaction_status == 'pending') {
    // TODO set payment status in merchant's database to 'Pending'
    $message = "Waiting customer to finish transaction order_id: " . $order_id . " using " . $type;
} elseif ($transaction_status == 'deny') {
    // TODO set payment status in merchant's database to 'Denied'
    $objInv->set_status('unpaid');
    $objInv->update_status();

    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Pembayaran gagal untuk order_id = ' . $order_id;
    $mail->Body    = file_get_contents('templates/email_failed.html');

    $key = array('{order_id}', '{product_id}', '{price}', '{status}', '{payment_method}');
    $val = array($order_id, $invoice['item_id'], $amount, $transaction_status, $payment_type);

    $mail->Body = str_replace($key, $val, $mail->Body);
    $mail->send();

    $message = "Payment using " . $type . " for transaction order_id: " . $order_id . " is denied.";
} elseif ($transaction_status == 'expire') {
    // TODO set payment status in merchant's database to 'expire'
    $objInv->set_status('unpaid');
    $objInv->update_status();

    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Pembayaran gagal untuk order_id = ' . $order_id;
    $mail->Body    = file_get_contents('templates/email_failed.html');

    $key = array('{order_id}', '{product_id}', '{price}', '{status}', '{payment_method}');
    $val = array($order_id, $invoice['item_id'], $amount, $transaction_status, $payment_type);

    $mail->Body = str_replace($key, $val, $mail->Body);
    $mail->send();

    $message = "Payment using " . $type . " for transaction order_id: " . $order_id . " is expired.";
} elseif ($transaction_status == 'cancel') {
    // TODO set payment status in merchant's database to 'Denied'
    $objInv->set_status('unpaid');
    $objInv->update_status();

    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Pembayaran gagal untuk order_id = ' . $order_id;
    $mail->Body    = file_get_contents('templates/email_failed.html');

    $key = array('{order_id}', '{product_id}', '{price}', '{status}', '{payment_method}');
    $val = array($order_id, $invoice['item_id'], $amount, $transaction_status, $payment_type);

    $mail->Body = str_replace($key, $val, $mail->Body);
    $mail->send();

    $message = "Payment using " . $type . " for transaction order_id: " . $order_id . " is canceled.";
}

// $filename = $order_id . ".txt";
// $dirpath = 'log';
// is_dir($dirpath) || mkdir($dirpath, 0777, true);


// json_decode( file_put_contents($dirpath . "/" . $filename, $message));