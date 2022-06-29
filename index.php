<?php

    session_start();
    require_once "./model/Items.php";

    if(isset($_SESSION['user_data'])) {
        header("location: view/welcome_page.php");
    }

    $objItem = new Items;
    $items = $objItem->get_all_items();


?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="./assets/logo/logo.ico" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://unpkg.com/flowbite@1.4.3/dist/flowbite.min.css" />
    <!-- <link href="./assets/css/style.css" rel="stylesheet" /> -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital@0;1&display=swap" 
    rel="stylesheet"/> <!-- Poppins Font -->
    <title>Lumintu Learning</title>
    <meta property="og:locale" content="id_ID" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="Lumintu Logic" />
    <meta property="og:description" content="We Are Lumintu’s Stack " />
    <meta property="og:url" content="https://lms.lumintulogic.com/" />
    <meta property="og:site_name" content="Lumintu Learning" />
    <meta property="og:image" content="https://account.lumintulogic.com/assets/img/logo.png" />
    <link href="https://cdn.jsdelivr.net/npm/daisyui@2.17.0/dist/full.css" rel="stylesheet" type="text/css" />
</head>

<!-- <link href="https://cdn.jsdelivr.net/npm/daisyui@2.17.0/dist/full.css" rel="stylesheet" type="text/css" />
<script src="https://cdn.tailwindcss.com"></script> -->

<body  class="h-screen bg-cover bg-no-repeat bg-fixed" style="background-image: url('./assets/ilustrasi/gambar6.png')">
    <!-- Navbar -->
    <nav class="sticky top-0 z-30 bg-transparent px-5 py-3 md:flex md:items-center md:justify-between">
        <div class="flex justify-between items-center">
            <a href="#" class="flex items-center">
                <img src="./assets/logo/logo_lumintu.png" class="ml-4 h-6 sm:h-9" alt="Lumintu Logo" />
            </a>
            <span class="text-3xl text-white cursor-pointer mx-2 my-auto md:hidden block">
                <ion-icon name="menu-outline" onclick="Menu(this)"></ion-icon>
            </span>
        </div>

        <ul class="md:flex md:items-center z-[0] md:z-auto md:static absolute bg-transparent w-full 
            left-0 md:w-auto md:py-0 py-0 md:pl-0 py-4 pl-7 md:opacity-100 opacity-0 right-[-400px] transition-all 
            ease-out duration-500">
            <a href="login.php" class="text-white text-md px-5 py-1 text-center md:mr-3 sm:mr-0 mx-auto hover:text-[#C27D2B] ">Login</a>
            <a href="https://account.lumintulogic.com/register.php" class="text-white bg-[#C27D2B] rounded-full text-sm px-5 py-2 text-center md:mr-3 sm:mr-0 mx-auto">Daftar</a>
        </ul>
    </nav>
    <!-- end navbar -->

    <!-- konten -->
    <div class="container px-8 max-w-md mx-auto sm:max-w-xl md:max-w-5xl lg:flex lg:max-w-full lg:p-0">
        <div class="lg:p-16 lg:mt-8 lg:flex-1">
            <div class="space-y-1">
                    <h1 class="text-3xl lg:text-5xl text-white">NEVER STOP EXPLORING THE WORLD</h1>
                    
                    <p class="text-[#CEB27C] md:text-2xl w-3/4">Choose your course according to your criteria, needs, and your passion</p>

                    <div class="py-6 ">
                        <a href="login.php" class="text-white bg-[#C27D2B] rounded-full 
                        text-sm px-5 py-2 text-center md:mr-3 sm:mr-0 mx-auto">Ayo gabung sekarang</a>
                    </div>
            </div>
        </div>
            <!-- carousel start -->
            <div class="lg:flex lg:w-1/2 my-auto">
                <div class="carousel carousel-center max-w-md p-4 space-x-4 bg-transparent rounded-box">
                    <div class="carousel-item">
                        <?php for($i = 0; $i < count($items); $i++) : ?>
                            <button  type="button" data-modal-toggle="default-modal" data-name="<?= $items[$i]["name"]; ?>" data-price="<?= $items[$i]["price"]; ?>" data-desc="<?= $items[$i]["description"]; ?>" id="modal<?= $items[$i]["item_id"]; ?>" onclick="openModal(<?= $items[$i]['item_id']; ?>)">
                                <img  src="./assets/ilustrasi/course<?= $items[$i]['item_id']; ?>.png" class="rounded-box" />
                            </button>
                        <?php endfor ?>                     
                    </div>
                </div>
            </div>

            <!-- Main modal -->
            <div id="default-modal" data-modal-show="true" aria-hidden="true" class="hidden overflow-x-hidden overflow-y-auto fixed h-modal md:h-full top-4 left-0 right-0 md:inset-0 z-50 justify-center items-center">
                <div class="relative w-full max-w-sm px-4 h-full md:h-auto">
                    <!-- Modal content -->
                    <div class="flex items-start justify-between p-5 rounded-t ">
                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="default-modal">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>  
                        </button>
                    </div>
                    <div class="bg-white rounded-lg shadow relative ">
                        
                        <!-- Modal body -->
                        <div class="p-6 ">
                            <img id="imgCourse" src="./assets/ilustrasi/course1.png" alt="" class="w-full">
                        </div>
                        <div class="p-6 text-[#263238]">
                            <p id="descCourse">Deskripsi jhsdcbhc hbcwehc ajied uhc7e baceu danmci</p>
                        </div>

                        <!-- Modal footer -->               
                        <div class="flex space-x-1 object-center p-4 border-t border-gray-200 rounded-b ">
                            <a href="login.php" class="text-white mx-auto bg-[#C27D2B] hover:bg-[#c27619] focus:ring-4 focus:ring-[#b06e1e] font-medium rounded-lg text-sm px-4 py-2.5 text-center dark:bg-[#C27D2B] dark:hover:bg-[#c27619] dark:focus:ring-[#b06e1e]">Get started</a>
                        </div>
                        
                    </div>
                </div>  
            </div>

            <!-- carousel end -->
    </div>       

</body>

    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/flowbite@1.4.2/dist/flowbite.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script> <!-- icons -->
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script> <!-- icons -->

    <script>
        let openModal = (id) => {

            console.log(id);

            let itemId = id;
            let itemName = $('#modal' + id).data('name');
            let itemPrice = $('#modal' + id).data('price');
            let itemDesc = $('#modal' + id).data('desc');

            $("#imgCourse").attr("src", "./assets/ilustrasi/course" + id + ".png");
            $("#descCourse").html(itemDesc);
        }
    </script>

    
  </body>
</html>