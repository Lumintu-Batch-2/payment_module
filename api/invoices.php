<?php

    require_once('../model/Invoices.php');
    header('Content-Type: application/json');

    $objInv = new Invoices;
    $arr = array();

    switch($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            if(isset($_GET['id'])) {
                // Get invoice by user_id
                $objInv->set_user_id($_GET['id']);
                $user_invoices = $objInv->get_invoices_user();
                $arr['error'] = false;
                if(!empty($user_invoices)) {
                    $arr['data'] = $user_invoices;
                } else {
                    $arr['data'] = null;
                }
                print_r(json_encode($arr));
                break;
            }

            // Get all invoices
            $invoices = $objInv->get_all_invoices();
            $arr['error'] = false;
            if(!empty($invoices)) {
                $arr['data'] = $invoices;
            } else {
                $arr['data'] = null;
            }
            print_r(json_encode($arr));

            break;
        default:
            http_response_code(405);
            print_r(json_encode(array(
                "error" => true,
                "msg" => "Method not allowed!"
            )));
            break;
    };
