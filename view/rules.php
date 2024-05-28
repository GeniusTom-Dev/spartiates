<a href="/home" class="absolute left-4 md:left-5 top-4 md:top-5 w-12 md:w-16 h-12 md:h-16">
    <img class="p-2 bg-customBlue rounded-xl" src="/assets/images/home.svg" alt="Home">
</a>

<div class="w-full p-4">
    <h1 class="titlePage text-center text-3xl md:text-4xl lg:text-5xl mb-4">
        <span class="text-black">Les</span> règles du jeu
    </h1>

    <div class="relative bg-white w-full max-w-2xl mx-auto mb-6 h-1/2">
        <iframe class="w-full h-[30vh] sm:h-[40vh] md:h-[50vh] lg:h-[60vh]" src="https://www.youtube.com/embed/hNQlOJoj2Vc?si=A2k1BD8d1LjhS9Wu"
                title="YouTube video player"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                allowfullscreen></iframe>
    </div>

    <div id="default-carousel" class="bg-customBlue my-6 px-5 py-9 pb-14 relative h-[50vh] sm:h-[40vh] md:h-[50vh] lg:h-[60vh] xl:h-[60vh] 2xl:h-[60vh] rounded-lg w-full sm:w-[90%] md:w-[80%] lg:w-[70%] mx-auto" data-carousel="static">
        <!-- Carousel wrapper -->
        <div class="overflow-hidden relative h-full rounded-lg w-full">
            <!-- Item 1 -->
            <div class="carousel-item hidden duration-700 ease-in-out h-full overflow-y-auto" data-carousel-item>
            <span class="block w-full text-3xl font-semibold text-gray-800 text-center">
                <?php echo file_get_contents('view/rules/game.php') ?>
            </span>
            </div>
            <!-- Item 2 -->
            <div class="carousel-item hidden duration-700 ease-in-out h-full overflow-y-auto" data-carousel-item>
            <span class="block w-full text-3xl font-semibold text-gray-800 text-center">
                <?php echo file_get_contents('view/rules/surface.php') ?>
            </span>
            </div>
            <!-- Item 3 -->
            <div class="carousel-item hidden duration-700 ease-in-out h-full overflow-y-auto" data-carousel-item>
            <span class="block w-full text-3xl font-semibold text-gray-800 text-center">
                <?php echo file_get_contents('view/rules/equipments.php') ?>
            </span>
            </div>
            <!-- Item 4 -->
            <div class="carousel-item hidden duration-700 ease-in-out h-full overflow-y-auto" data-carousel-item>
            <span class="block w-full text-3xl font-semibold text-gray-800 text-center">
                <?php echo file_get_contents('view/rules/offSide.php') ?>
            </span>
            </div>
        </div>
        <!-- Slider indicators -->
        <div class="flex absolute bottom-5 left-1/2 z-30 space-x-3 -translate-x-1/2">
            <button type="button" class="indicator w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 1" data-carousel-slide-to="0"></button>
            <button type="button" class="indicator w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 2" data-carousel-slide-to="1"></button>
            <button type="button" class="indicator w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 3" data-carousel-slide-to="2"></button>
            <button type="button" class="indicator w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 4" data-carousel-slide-to="3"></button>
        </div>
        <!-- Slider controls -->
        <button type="button" class="carousel-prev flex absolute top-0 left-0 z-30 justify-center items-end px-4 h-full cursor-pointer group focus:outline-none" data-carousel-prev>
            <span class="inline-flex justify-center items-center w-8 h-8 rounded-full sm:w-10 sm:h-10 bg-gray-800/30 group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white group-focus:ring-gray-800/70 group-focus:outline-none mb-2">
                <svg class="w-5 h-5 sm:w-6 sm:h-6 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                <span class="hidden">Previous</span>
            </span>
        </button>
        <button type="button" class="carousel-next flex absolute top-0 right-0 z-30 justify-center items-end px-4 h-full cursor-pointer group focus:outline-none" data-carousel-next>
        <span class="inline-flex justify-center items-center w-8 h-8 rounded-full sm:w-10 sm:h-10 bg-gray-800/30 group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white group-focus:ring-gray-800/70 group-focus:outline-none mb-2">
            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
            <span class="hidden">Next</span>
        </span>
        </button>
    </div>
</div>
