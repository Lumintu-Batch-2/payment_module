
<!-- component -->
<!-- This is an example component -->
<div class="max-w-2xl mx-auto">

    <!-- Modal toggle -->
    <!-- <button class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" >
    Toggle modal
    </button> -->

    <!-- Main modal -->
    <div id="default-modal" data-modal-show="false" aria-hidden="true" class="hidden overflow-x-hidden overflow-y-auto fixed h-modal md:h-full top-4 left-0 right-0 md:inset-0 z-50 justify-center items-center">
        <div class="relative w-full max-w-2xl px-4 h-full md:h-auto">
            <!-- Modal content -->
            <div class="bg-white rounded-lg shadow relative">
                <!-- Modal header -->
                <div class="flex items-start justify-between p-5 border-b rounded-t ">
                    <h3 id="itemTitle" class="text-gray-900 text-3xl lg:text-2xl font-bold">
                        GradIT
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-toggle="default-modal">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>  
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-6 space-y-6">
                    <p id="itemDesc" class="text-base leading-relaxed ">
                        Raih impian menjadi web developer profesional
                    </p>
                    <p class=" leading-relaxed text-xl">
                        Benefit Langganan :
                        <ul class="list-disc ml-6">
                            <li id="benefitClass">Akses kelas GradIT</li>
                            <li>Diskusi bersama mentor</li>
                            <li>Ujian</li>
                            <li>Tugas</li>
                        </ul>
                    </p>
                </div>
                <!-- Modal footer -->
                <div class="grid grid-cols-2 gap-2">
                    <div class="p-6 space-y-1">
                        <p class="text-xl font-semibold ">
                            Harga langganan
                        </p>
                        <p id="priceValue" class="text-xl font-bold">
                            Rp. 999.999
                        </p>
                        
                    </div>
                    <div class="flex space-x-2 items-center p-6 rounded-b mx-auto mr-0">
                        <input type="hidden" name="" id="itemId">
                        <input type="hidden" name="" id="itemPrice">
                        <button type="button" class="text-white bg-[#C27D2B] hover:bg-[#c27619] focus:ring-4 focus:ring-[#b06e1e] font-medium rounded-lg text-sm px-5 py-2.5 text-center " onclick="createOrder()">Buat pesanan</button>
                    </div>
                </div>
                
            </div>
        </div>  
    </div>

</div>

<script src="https://unpkg.com/flowbite@1.4.4/dist/flowbite.js"></script>
