<div class="w-full h-full flex flex-col justify-center items-center">
    <a class="bg-white w-full md:h-[8vh] lg:w-1/3 md:w-5/6 py-6 md:py-4 drop-shadow-xl text-lg my-3 mx-1 rounded-lg flex justify-center items-center hover:transition ease-in-out delay-150"
       href="<?php echo !empty($_SESSION['code']) ? '/play' : '/sessionCode' ?>"><span class="text-3xl md:text-2xl lg:text-xl">JOUER</span></a>
    <a class="bg-white w-full md:h-[8vh] lg:w-1/3 md:w-5/6 py-6 md:py-4 drop-shadow-xl text-lg my-3 mx-1 rounded-lg flex justify-center items-center hover:transition ease-in-out delay-150"
       href='/rules'><span class="text-3xl md:text-2xl lg:text-xl">LES RÈGLES</span></a>
    <a class="bg-customBlue w-full md:h-[6vh] lg:w-1/3 md:w-5/6 py-6 md:py-4 drop-shadow-xl text-lg my-3 mx-1 rounded-lg flex justify-center items-center hover:bg-sky-300 transition ease-in-out delay-150"
       href='/users'><span class="text-3xl md:text-2xl lg:text-xl">ADMIN</span></a>
</div>