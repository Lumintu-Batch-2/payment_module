<?php

    session_start();

    if(!isset($_SESSION['user_data'])) {
        header("location: ../login.php");
    }

    require_once "../templates/header.php";
    require_once('../model/Items.php');
    require_once('../controllers/get_request.php');

    // PHP Error Display
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

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

    // var_dump($indata);
    // get all item
    $url1 = "http://localhost/payment_module/api/items.php?id=" . $user_id;
    $datajs = http_request($url1);
    $json = json_decode($datajs, TRUE);
    // var_dump($json);
    $data_item = $json['data'];

?>
<body>
<!-- Navbar -->
<nav class="sticky top-0  z-[50] bg-[#263238] px-5 py-3 md:flex md:items-center md:justify-between">
    <div class="flex justify-between items-center">
        <a href="welcome_page.php" class="flex items-center">
            <img src="../assets/logo/logo_lumintu.png" class="ml-4 h-6 sm:h-9" alt="Lumintu Logo" />
        </a>
        <span class="text-3xl text-white cursor-pointer mx-2 my-auto md:hidden block">
            <ion-icon name="menu-outline" onclick="Menu(this)"></ion-icon>
        </span>
    </div>

    <ul class="md:flex md:items-center z-[1] md:z-auto md:static absolute bg-[#263238] w-full 
        left-0 md:w-auto md:py-0 py-0 md:pl-0 py-4 pl-7 md:opacity-100 opacity-0 right-[-400px] transition-all 
        ease-out duration-500">
        <a href="invoice.php" class="text-white text-md px-5 py-1 text-center md:mr-3 sm:mr-0 mx-auto hover:text-[#C27D2B] ">Invoice</a>
        <a href="#" class="text-white bg-[#C27D2B] rounded-full text-sm px-5 py-1 text-center md:mr-3 sm:mr-0 mx-auto">Profile</a>
    </ul>
</nav>
<!-- end navbar -->

<!-- hero section -->
<div class="bg-gradient-to-r from-[#CEB27C] to-[#C27D2B] p-2">
    <div class="text-center w-full mx-auto py-12 px-4 md:py-28 md:px-8">
        <h2 class="font-bold text-white text-4xl">
            Lumintu Learning
        </h2>
        <p class="font-regular text-white sm:text-base mt-4 p-2">
            Gali potensi kamu bersama mentor yang ahli dibidangnya, 
            akan dibantu hingga kamu paham
        </p>
    </div>
</div>
<!-- end hero section -->

<!-- kelas yang telah diambil -->
<div class="bg-[#D7D7D7] w-full p-4">
    <div class="text-center w-full p-4 ">
        <h3 class="font-semibold text-[#263238] md:text-3xl">
            Kelas yang telah kamu ambil
        </h3>
    </div>
    <div>
    <?php if(empty($data_item['items_user'])) { ?>
            <div class="flex flex-col mx-auto w-full">
                <div class="text-center">
                    <a href="#">
                        <img 
                        class="h-60 w-full object-center p-4"
                        src="../assets/ilustrasi/gambar5.svg"
                        alt="error">
                    </a>
                </div>
                <div class="text-center w-full px-4 mb-8 p-4">
                    <h3 class="font-medium text-[#263238] sm:text-xl">
                        Oops kamu belum memiliki kelas
                    </h3>
                </div>
            </div>
        <?php } else {?>
            <div class=" mx-auto lg:max-w-7xl mt-3 ">
                <div class="max-w-7xl mx-auto px-5 mb-3">
                    <div class="mt-6 grid grid-cols-1 gap-y-10 gap-x-6 sm:grid-cols-2 lg:grid-cols-3 xl:gap-x-8">
                        <?php foreach ($data_item['items_user'] as $pack) : ?>
                            <div class="max-w-xl p-4 bg-white rounded-lg border border-gray-200 shadow-xl">                    
                                <img class="lg:h-48 md:h-36 w-full object-center scale-100 transition-all duration-400 hover:scale-90" src="../assets/ilustrasi/gambar<?=$pack['item_id'];?>.svg" alt="">
                                <div class="p-5" >
                                    <a href="#">
                                        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 text-center"><?= $pack["name"]; ?></h5>
                                    </a>
                                    <p class="mb-3 font-normal text-gray-700 mb-14"><?= $pack["description"]; ?></p>
                                    <div class="p-6 text-center">
                                        <a href="#" class="text-white bg-[#C27D2B] rounded-full 
                                        text-sm px-5 py-2 text-center md:mr-3 sm:mr-0 mx-auto">Ayo belajar</a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>    
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
<!-- end kelas yang telah diambil -->

<!-- rekomendasi kelas -->
<div class="bg-white p-2 mb-16">
    <div class="text-center w-full p-4 mb-8">
        <h3 class="font-semibold text-[#263238] sm:text-3xl">
            Ayo tentukan kelas kamu sekarang
        </h3>
        <p class="font-medium text-[#263238] text-lg">
            Pilih kelas sesuai dengan minat kamu
        </p>
    </div>
    <!-- component card -->
    
    <div class=" mx-auto lg:max-w-7xl mt-3 ">
        <div class="max-w-7xl mx-auto px-5 mb-3">
            <div class="mt-6 grid grid-cols-1 gap-y-10 gap-x-6 sm:grid-cols-2 lg:grid-cols-3 xl:gap-x-8">
                <?php foreach ($data_item['not_taken'] as $pack) : ?>
                    <div class="max-w-xl p-4 bg-white rounded-lg border border-gray-200 shadow-xl">
                        <img class="lg:h-48 md:h-36 w-full object-center scale-100 transition-all duration-400 hover:scale-90" src="../assets/ilustrasi/gambar<?=$pack['item_id'];?>.svg" alt="">
                        <div class="p-5" >
                            
                            <a href="#">
                                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 text-center"><?= $pack["name"]; ?></h5>
                            </a>
                            <p class="mb-3 font-normal text-gray-700 mb-14"><?= $pack["description"]; ?></p>
                            <div class="p-6 text-center">
                                <button type="button" data-modal-toggle="default-modal" class="text-white bg-[#C27D2B] rounded-full 
                                text-sm px-5 py-2 text-center md:mr-3 sm:mr-0 mx-auto" data-name="<?= $pack["name"]; ?>" data-price="<?= $pack["price"]; ?>" data-desc="<?= $pack["description"]; ?>" id="modal<?= $pack["item_id"]; ?>" onclick="openModal(<?= $pack['item_id']; ?>)">Ayo gabung sekarang</button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <?php include "../templates/modal.php"; ?>
</div>
<!-- end rekomendasi kelas -->

<!-- Loading animation -->
<div id="loader" class="loading-container hidden">
    <div class="lds-ring">
        <div></div>
        <div></div>
        <div></div>
        <div></div>
    </div>
</div>


<!-- footer -->
<footer class="p-4 bg-[#263238] sm:p-6">
    <div class="md:flex md:justify-between">
        <div class="mb-6 md:mb-0">
            <a href="#" class="flex items-center mb-6 sm:mb-0 mt-2">
                <img src="../assets/logo/logo_lumintu.png" class="mr-3 h-16" alt="GradIT Logo">
            </a>
        </div>
        <div class="grid grid-cols-2 gap-8 sm:gap-6 sm:grid-cols-3">
            <div>
                <h2 class="mb-2 text-sm font-semibold text-white uppercase">Lumintu Learning</h2>
                <ul class="text-gray-400">
                    <li>
                        <a href="#" class="hover:underline">Grad IT</a>
                    </li>
                    <li>
                        <a href="#" class="hover:underline">Codecation</a>
                    </li>
                    <li>
                        <a href="#" class="hover:underline">ProKidz</a>
                    </li>
                    <li>
                        <a href="#" class="hover:underline">In Career </a>
                    </li>
            </div>
            <div>
                <h2 class="mb-2 text-sm font-semibold text-white uppercase">LumintuLogic</h2>
                <ul class="text-gray-400">
                    <li>
                        <a href="#" class="hover:underline ">About us</a>
                    </li>
                    <li>
                        <a href="#" class="hover:underline">Blog</a>
                    </li>
                    <li>
                        <a href="#" class="hover:underline">Privacy</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <hr class="my-6 border-gray-200 sm:mx-auto lg:my-8" />
    <div class="sm:flex sm:items-center sm:justify-between">
        <span class="text-sm text-gray-500 sm:text-center">© 2022 <a href="#" class="hover:underline">LumintuLogic™</a>. All Rights Reserved.
        </span>
        <div class="flex mt-4 space-x-6 sm:justify-center sm:mt-0">
            <a href="#" class="text-gray-500 hover:text-gray-900">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" /></svg>
            </a>
            <a href="#" class="text-gray-500 hover:text-gray-900">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd" /></svg>
            </a>
            <a href="#" class="text-gray-500 hover:text-gray-900">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" /></svg>
            </a>
            <a href="#" class="text-gray-500 hover:text-gray-900">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd" /></svg>
            </a>
            <a href="#" class="text-gray-500 hover:text-gray-900">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10c5.51 0 10-4.48 10-10S17.51 2 12 2zm6.605 4.61a8.502 8.502 0 011.93 5.314c-.281-.054-3.101-.629-5.943-.271-.065-.141-.12-.293-.184-.445a25.416 25.416 0 00-.564-1.236c3.145-1.28 4.577-3.124 4.761-3.362zM12 3.475c2.17 0 4.154.813 5.662 2.148-.152.216-1.443 1.941-4.48 3.08-1.399-2.57-2.95-4.675-3.189-5A8.687 8.687 0 0112 3.475zm-3.633.803a53.896 53.896 0 013.167 4.935c-3.992 1.063-7.517 1.04-7.896 1.04a8.581 8.581 0 014.729-5.975zM3.453 12.01v-.26c.37.01 4.512.065 8.775-1.215.25.477.477.965.694 1.453-.109.033-.228.065-.336.098-4.404 1.42-6.747 5.303-6.942 5.629a8.522 8.522 0 01-2.19-5.705zM12 20.547a8.482 8.482 0 01-5.239-1.8c.152-.315 1.888-3.656 6.703-5.337.022-.01.033-.01.054-.022a35.318 35.318 0 011.823 6.475 8.4 8.4 0 01-3.341.684zm4.761-1.465c-.086-.52-.542-3.015-1.659-6.084 2.679-.423 5.022.271 5.314.369a8.468 8.468 0 01-3.655 5.715z" clip-rule="evenodd" /></svg>
            </a>
        </div>
    </div>
</footer>
<!-- end footer -->

</body>




<?php require_once "../templates/footer.php" ?>
<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>

<script>

    let numberWithDot = (x) => { return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."); }

    function openModal(id) {

        let itemId = id;
        let itemName = $('#modal' + id).data('name');
        let itemPrice = $('#modal' + id).data('price');
        let itemDesc = $('#modal' + id).data('desc');

        $('#itemTitle').html(itemName);
        $('#itemDesc').html(itemDesc);
        $('#itemId').val(itemId);
        $('#priceValue').html('Rp ' + numberWithDot(itemPrice));
        $('#itemPrice').val(itemPrice);
        $('#benefitClass').html('Akses kelas ' + itemName);
    }

    let createOrder = () => {
        
        const URL_PAYMENT = "https://app.sandbox.midtrans.com/snap/v2/vtweb/";

        // Item Data
        let itemId = $('#itemId').val();
        let itemName = $('#itemTitle').html();
        let itemPrice = $('#itemPrice').val();
        let itemQty = 1;


        let itemData = {
            "id": itemId,
            "price": itemPrice,
            "name": itemName,
            "quantity": 1
        }

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


        $.ajax({
            url: '../create_order.php',
            type: 'post',
            data: {
                "item_detail": itemData,
                "customer_detail": userData
            },
            xhr: function() {
                const xhr = new window.XMLHttpRequest();
                
                xhr.upload.addEventListener('progress', (event) => {
                    $('#loader').removeClass('hidden');
                }, false)
                return xhr;
            },
            success: function(res) {
                $('#loader').addClass('hidden');
                alert('Pesanan behasil dibuat, silahkan cek halaman invoice untuk melakukan pembayaran');
                // location.replace(URL_PAYMENT + res);
            }
        })
    }
    

</script>