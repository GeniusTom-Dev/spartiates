<div class="w-full h-full flex flex-col justify-center items-center">
    <a class="bg-white w-full md:h-[10vh] lg:w-1/3 md:w-5/6 py-8 md:py-6 drop-shadow-xl text-lg my-4 mx-1 rounded-lg flex justify-center items-center hover:transition ease-in-out delay-150"
       href="<?php echo !empty($_SESSION['code']) ? '/play' : '/sessionCode' ?>"><span class="text-5xl lg:text-3xl">JOUER</span></a>
    <a class="bg-white w-full md:h-[10vh] lg:w-1/3 md:w-5/6 py-8 md:py-6 drop-shadow-xl text-lg my-4 mx-1 rounded-lg flex justify-center items-center hover:transition ease-in-out delay-150"
       href='/rules'><span class="text-5xl lg:text-3xl">LES RÈGLES</span></a>
    <a class="bg-customBlue w-full md:h-[7vh] lg:w-1/3 md:w-5/6 py-8 md:py-6 drop-shadow-xl text-lg my-4 mx-1 rounded-lg flex justify-center items-center hover:bg-sky-300 transition ease-in-out delay-150"
       href='/users'><span class="text-5xl lg:text-3xl">ADMIN</span></a>
</div>
