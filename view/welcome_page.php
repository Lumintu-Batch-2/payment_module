<?php
require_once "../templates/header.php";

$url = "http://192.168.18.99/payment_module/api/items.php";
// $urlf = 'https://lessons.lumintulogic.com/api/modul/read_modul_rows.php';
$datajs = file_get_contents($url);
$json = json_decode($datajs, TRUE);
// var_dump($json);
$indata = $json['data'];

// var_dump($indata);

?>
<body>
<!-- Navbar -->
<nav class="bg-[#263238] px-5 py-3 md:flex md:items-center md:justify-between">
    <div class="flex justify-between items-center">
        <a href="#" class="flex items-center">
            <img src="../assets/logo/logo_lumintu.png" class="ml-4 h-6 sm:h-9" alt="Lumintu Logo" />
        </a>
        <span class="text-3xl text-white cursor-pointer mx-2 my-auto md:hidden block">
            <ion-icon name="menu-outline" onclick="Menu(this)"></ion-icon>
        </span>
    </div>

    <ul class="md:flex md:items-center z-[1] md:z-auto md:static absolute bg-[#263238] w-full 
        left-0 md:w-auto md:py-0 py-0 md:pl-0 py-4 pl-7 md:opacity-100 opacity-0 right-[-400px] transition-all 
        ease-out duration-500">
        <button type="button" class="text-white bg-[#C27D2B] rounded-full 
        text-sm px-5 py-1 text-center md:mr-3 sm:mr-0 mx-auto">Profile</button>
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
    <!-- <div class="flex flex-wrap -m-8 p-8">
        <div class="p-4 md:w-1/3" id="bantu1">
            <div class="h-full rounded-xl bg-white overflow-hidden drop-shadow-xl">
                <a href="#">
                    <img 
                    class="lg:h-48 md:h-36 w-full object-center scale-100 transition-all duration-400 hover:scale-90"
                    src="../assets/ilustrasi/gambar1.svg"
                    alt="blog">
                </a>
                <div class="p-6">
                    <h1 class="title-font text-center text-2xl font-bold text-[#263238] mb-3">Gard IT</h1>
                    <p class="leading-relaxed mb-3">Platform Pembelajaran untuk Sarjana & Fresh Graduate. Kursus Full Stack Developer.</p>
                </div>
                <div class="p-6 text-center">
                    <button type="button" class="text-white bg-[#C27D2B] rounded-full 
                    text-sm px-5 py-2 text-center md:mr-3 sm:mr-0 mx-auto">Ayo gabung sekarang</button>
                </div>
            </div>
        </div> -->
    </div>
</div>
<!-- end kelas yang telah diambil -->

<!-- rekomendasi kelas -->
<div class="bg-white p-2">
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
            <?php foreach ($indata as $pack) : ?>
                <div class="max-w-xl bg-white rounded-lg border border-gray-200 shadow-2xl dark:bg-gray-800 dark:border-gray-700">
                    
                    <img class="rounded-t-lg px-5 py-2" src="../assets/ilustrasi/gambar1.svg" alt="">
                    
                        <div class="p-5" >
                            
                            <a href="#">
                                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white text-center"><?= $pack["name"]; ?></h5>
                            </a>
                            <p class="mb-3 font-normal text-gray-700 dark:text-gray-400 mb-14"><?= $pack["description"]; ?></p>
                            <div class="p-6 text-center">
                                <button type="button" data-modal-toggle="default-modal" class="text-white bg-[#C27D2B] rounded-full 
                                text-sm px-5 py-2 text-center md:mr-3 sm:mr-0 mx-auto">Ayo gabung sekarang</button>
                            </div>
                        
                        </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <?php include "../templates/modal.php"; ?>
<!-- end rekomendasi kelas -->


<!-- footer -->
<footer class="p-4 bg-[#263238] shadow md:flex md:items-center md:justify-between md:p-6">
      <span class="text-sm text-white sm:text-center">© 2022 <a href="https://flowbite.com"
          class="hover:underline">LumintuLogic™</a>. All Rights Reserved.
      </span>
      <br>
      <a href="https://flowbite.com" class="flex items-center mb-6 sm:mb-0 mt-2">
        <img src="../assets/logo/logo_lumintu.png" class="mr-3 h-8" alt="GradIT Logo">
    </a>
</footer>
<!-- end footer -->

</body




<?php require_once "../templates/footer.php" ?>