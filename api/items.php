<?php

    require_once('../model/Items.php');

    header('Content-Type: application/json');

    if($_SERVER['REQUEST_METHOD'] !== 'GET') {
        http_response_code(405);
        print_r(json_encode(array(
            "error" => true,
            "msg" => "Method not allowed!"
        )));
        exit();
    }

    $item = new Items();
    $arr = array();
     try {

        $items = $item->get_all_items();
        $arr['error'] = false;
        $arr['data'] = $items;
        
     } catch (Exception $e) {
        $arr['error'] = true;
        $arr['msg'] = "Can't get items";
        $arr['data'] = null;
     }


     print_r(json_encode($arr));