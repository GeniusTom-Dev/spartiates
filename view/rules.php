<a href="/home" class="absolute left-5 top-5 w-20 h-20">
    <img class="p-2 w-sm h-sm bg-customBlue rounded-xl" src="/assets/images/home.svg" alt="Delete">
</a>

<div class="m-10 ">
    <h1 class="titlePage text-center">
        <span class="text-black">Les</span> règles du jeu
    </h1>
    <div class="w-full flex justify-center items-center py-10">
        <iframe width="840" height="472,5" src="https://www.youtube.com/embed/hNQlOJoj2Vc?si=A2k1BD8d1LjhS9Wu"
                title="YouTube video player"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                allowfullscreen></iframe>
    </div>
    <div id="default-carousel" class="relative" data-carousel="static">
        <!-- Carousel wrapper -->
        <div class="overflow-hidden relative h-[50vh] rounded-lg w-4/5 left-[10%]">
            <!-- Item 1 -->
            <div class="overflow-auto hidden duration-700 ease-in-out" data-carousel-item>
                <span class="w-full absolute top-0 left-1/2 text-3xl font-semibold text-gray-800 -translate-x-1/2 text-center">
                    <?php echo file_get_contents('view/rules/game.php') ?>
                </span>
            </div>
            <!-- Item 2 -->
            <div class="overflow-auto hidden duration-700 ease-in-out" data-carousel-item>
                <span class="w-full absolute top-0 left-1/2 text-3xl font-semibold text-gray-800 -translate-x-1/2 text-center">
                    <?php echo file_get_contents('view/rules/surface.php') ?>
                </span>
            </div>
            <!-- Item 3 -->
            <div class="overflow-auto hidden duration-700 ease-in-out" data-carousel-item>
                <span class="w-full absolute top-0 left-1/2 text-3xl font-semibold text-gray-800 -translate-x-1/2 text-center">
                    <?php echo file_get_contents('view/rules/equipments.php') ?>
                </span>
            </div>
            <!-- Item 4 -->
            <div class="overflow-auto hidden duration-700 ease-in-out" data-carousel-item>
                <span class="w-full absolute top-0 left-1/2 text-3xl font-semibold text-gray-800 -translate-x-1/2 text-center">
                    <?php echo file_get_contents('view/rules/offSide.php') ?>
                </span>
            </div>
        </div>
        <!-- Slider indicators -->
        <div class="flex absolute bottom-5 left-1/2 z-30 space-x-3 -translate-x-1/2">
            <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 1"
                    data-carousel-slide-to="0"></button>
            <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 2"
                    data-carousel-slide-to="1"></button>
            <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 3"
                    data-carousel-slide-to="2"></button>
            <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 3"
                    data-carousel-slide-to="2"></button>
        </div>
        <!-- Slider controls -->
        <button type="button"
                class="flex absolute top-0 left-0 z-30 justify-center items-center px-4 h-full cursor-pointer group focus:outline-none"
                data-carousel-prev>
        <span class="inline-flex justify-center items-center w-8 h-8 rounded-full sm:w-10 sm:h-10  bg-gray-800/30 group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white group-focus:ring-gray-800/70 group-focus:outline-none">
            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                 xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round"
                                                          stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            <span class="hidden">Previous</span>
        </span>
        </button>
        <button type="button"
                class="flex absolute top-0 right-0 z-30 justify-center items-center px-4 h-full cursor-pointer group focus:outline-none"
                data-carousel-next>
        <span class="inline-flex justify-center items-center w-8 h-8 rounded-full sm:w-10 sm:h-10 bg-gray-800/30 group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white group-focus:ring-gray-800/70 group-focus:outline-none">
            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                 xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round"
                                                          stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            <span class="hidden">Next</span>
        </span>
        </button>
    </div>
</div>