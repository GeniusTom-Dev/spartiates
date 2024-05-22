<a href="/home" class="absolute left-5 top-5 w-20 h-20">
    <img class="p-2 bg-customBlue rounded-xl" src="/assets/images/home.svg" alt="Delete">
</a>
<div class="h-[40vh] w-full flex flex-col justify-center items-center">
    <form class="flex flex-col items-center space-y-5 w-1/2" id="verificationForm" method="post">
        <input type="hidden" name="action" value="checkSessionCode">
        <label for="code"><span class="text-3xl">Entrez le code :</span>
            <input class="rounded-xl w-full" type="number" id="code" name="code" inputmode="numeric" pattern="[0-9]*"
                   min="0" step="1" required>
        </label>
        <div class="text-red-700" id="res"></div>
        <input type="submit" value="Vérifier"
               class="text-3xl border-2 border-black rounded-xl h-[5vh] w-2/3 md:w-3/5 xl:w-1/6"/>
    </form>
</div>