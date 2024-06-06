<a href="/home" class="absolute left-5 top-4 md:top-5 w-12 md:w-16 h-12 md:h-16">
    <img class="p-2 bg-customBlue rounded-xl" src="../../assets/images/icon/home.svg" alt="Home">
</a>
<div class="h-[40vh] w-full flex flex-col justify-center items-center">
    <form class="flex flex-col items-center space-y-5 w-4/5 sm:w-3/5 md:w-2/5 lg:w-1/3 xl:w-1/4" id="verificationForm" method="post">
        <input type="hidden" name="action" value="checkSessionCode">
        <label for="code" class="w-full">
            <span class="text-2xl md:text-3xl lg:text-4xl">Code de la session :</span>
            <input class="rounded-xl w-full mt-2 p-2 text-lg md:text-xl lg:text-2xl border-gray-300" type="text" id="code" name="code" inputmode="numeric" pattern="\d{5}" minlength="5" maxlength="5" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 5);" required value="<?= $_GET['code'] ?? '' ?>">
        </label>
        <div class="text-red-700 text-sm md:text-base lg:text-lg" id="res"></div>
        <input type="submit" value="Vérifier" class="bg-customBlue hover:bg-sky-300 text-xl md:text-2xl lg:text-3xl px-5 py-3 rounded-xl h-[8vh] w-1/2 sm:w-1/3 md:w-1/2 lg:w-1/3 xl:w-1/2"/>
    </form>
</div>
