<?php

require_once "./controllers/get_request.php";
require_once "./controllers/post_request.php";

session_start();

if (isset($_POST['login'])) {
    $arr = array(
        "email" => $_POST['email'],
        "password" => $_POST['password']
    );

    $login = json_decode(post_request("https://account.lumintulogic.com/api/login.php", json_encode($arr)));
    $access_token = $login->{'data'}->{'accessToken'};
    $expiry = $login->{'data'}->{'expiry'};

    if ($login->{'success'}) {
        $userData = json_decode(http_request_with_auth("https://account.lumintulogic.com/api/user.php", $access_token));
        $_SESSION['user_data'] = $userData;
        var_dump($_SESSION['user_data']);
        // die;
        $_SESSION['expiry'] = $expiry;
        setcookie('X-LUMINTU-REFRESHTOKEN', $access_token, strtotime($expiry));

        header('location: ./view/welcome_page.php');
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>

</head>

<body>
    <form action="" method="POST">
        <label for="email">Email: </label>
        <input type="text" name="email" id="email">
        <br>
        <label for="password">Password: </label>
        <input type="text" name="password" id="password">
        <br>
        <button type="submit" id="login" name="login">Login</button>
    </form>

</body>

</html>