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

    switch($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            try {
                if(isset($_GET['id'])) {
                    $uid = $_GET['id'];
                    $user_items = $item->get_items_user($uid);
                    $not_taken_items = $item->get_not_taken_items($uid);
                    $arr['error'] = false;

                    if(!empty($user_items)) {
                        $arr['data']['items_user'] = $user_items;
                    } else {
                        $arr['data']['items_user'] = null;
                    }

                    if(!empty($not_taken_items)) {
                        $arr['data']['not_taken'] = $not_taken_items;   
                    } else {
                        $arr['data']['not_taken'] = null;
                    }

                    print_r(json_encode($arr));
                    break;
                }

                $items = $item->get_all_items();
                $arr['error'] = false;
                if(!empty($items)) {
                    $arr['data'] = $items;
                } else {
                    $arr['msg'] = 'Item not found!';
                    $arr['data'] = null;
                }

                print_r(json_encode($arr));
                break;
                
            } catch (Exception $e) {
                $arr['error'] = true;
                $arr['msg'] = "Can't get items";
                $arr['data'] = null;
                print_r(json_encode($arr));
                break;
            }    

        default:
            http_response_code(405);
            print_r(json_encode(array(
                "error" => true,
                "msg" => "Method not allowed!"
            )));
            exit();
    }

 
     

