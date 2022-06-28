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
<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="./assets/logo/logo.ico" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://unpkg.com/flowbite@1.4.3/dist/flowbite.min.css" />
    <link href="https://account.lumintulogic.com/assets/css/loader.css" rel="stylesheet" /> <!-- File Loader CSS -->
    <link href="https://account.lumintulogic.com/assets/css/style.css" rel="stylesheet" /> <!-- File Style CSS -->
    <title>Login | Lumintu Learning</title>
    <meta property="og:locale" content="id_ID" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="Lumintu Logic" />
    <meta property="og:description" content="We Are Lumintu’s Stack " />
    <meta property="og:url" content="https://lms.lumintulogic.com/" />
    <meta property="og:site_name" content="Lumintu Learning" />
    <meta property="og:image" content="https://account.lumintulogic.com/assets/img/logo.png" />
    
    <!-- File Custom CSS -->
    <link href="https://account.lumintulogic.com/assets/css/custom-auth.css" rel="stylesheet" />

</head>

<body style="background-image: url('https://account.lumintulogic.com/assets/img/background.jpg')">
    <div class="overlay">
        <div class="loading">
            <div id="loader">
                <div id="shadow"></div>
                <div id="box"></div>
            </div>
            <h4>Loading...</h4>
        </div>
    </div>
    <div class="container px-8 max-w-md mx-auto sm:max-w-xl md:max-w-5xl lg:flex lg:max-w-full lg:p-0">
        <div class="lg:p-16 lg:mt-8 lg:flex-1">
            <h2 class="text-4xl font-bold text-white tracking-wider lg:pt-5 pt-24">
                Lumintu Learning
            </h2>
            <h3 class="text-2xl font-semibold text-white tracking-wider mt-3">
                Masuk
            </h3>            
            <form method="post">
                <div>
                    <input type="hidden" name="token" value="b934d30eb4d281920696c9f6e873a9d5">
                </div>
                <div class="mt-5">
                    <div class="mt-4">
                        <label class="block text-white" for="email">Email<label>
                        <input type="email" placeholder="alamat email" name="email" class="w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-blue-600 text-black" required>
                    </div>

                    <div class="mt-4">
                        <label class="block text-white">Kata sandi<label>
                        <input type="password" placeholder="kata sandi" name="password" class="w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-blue-600 text-black" required>
                    </div>
                    <div class="flex">
                        <button class="w-full px-6 py-2 mt-4 text-white bg-[#b6833b] rounded-full hover:bg-[#c5985f]" name="login">Masuk</button>
                    </div>
                    <div class="flex items-center justify-between mt-6">
                        <div class="flex items-center">
                            <!-- TODO: Kerjakan Remember Session Login -->
                            <!-- <input id="remember-me" name="remember-me" type="checkbox"
                                class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                            <label for="remember-me" class="ml-2 block text-sm text-white"> Remember me </label> -->
                        </div>
                        <div class="text-sm">
                            <a href="https://account.lumintulogic.com/forgot-password.php" class="font-medium text-white hover:underline"> Lupa kata sandi ? </a>
                        </div>
                    </div>
                    <div class="mt-6 text-white place-items-end">
                        Belum punya akun?
                        <a class="text-white font-bold underline" href="https://account.lumintulogic.com/register.php">
                            Daftar
                        </a>
                    </div>
                </div>
            </form>
        </div>
        <div class="hidden lg:flex lg:w-1/2 my-auto p-36">
            <img src="https://account.lumintulogic.com/assets/img/login.png" class="animate-bounce lg:mt-10 lg:h-full lg:w-80 lg:object-scale-down lg:object-top">
        </div>
    </div>

    <script src="https://unpkg.com/flowbite@1.4.2/dist/flowbite.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://account.lumintulogic.com/assets/js/scripts.js"></script>

</body>

</html>