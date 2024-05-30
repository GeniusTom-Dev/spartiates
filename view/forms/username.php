<a href="/home" class="absolute left-5 top-4 md:top-5 w-12 md:w-16 h-12 md:h-16">
    <img class="p-2 bg-customBlue rounded-xl" src="/assets/images/home.svg" alt="Home">
</a>
<div class="w-full flex flex-col justify-center items-center">
    <form class="flex flex-col space-y-14 px-5 py-3 w-full sm:w-4/5 md:w-3/4 lg:w-2/3 xl:w-1/2 bg-white rounded sm:h-auto md:h-auto lg:h-auto xl:h-auto" id="form" method="post">
        <input type="hidden" name="action" value="addSessionPlayer">
        <label for="username"><span class="text-lg sm:text-xl md:text-2xl lg:text-3xl xl:text-4xl">Choisissez un pseudo :</span>
            <input class="rounded-xl w-full text-lg sm:text-xl md:text-2xl lg:text-3xl xl:text-4xl border-gray-300" maxlength="32" minlength="2" type="text" id="username" name="username" required pattern=".*\S.*">
        </label>

        <label for="familyName"><span class="text-lg sm:text-xl md:text-2xl lg:text-3xl xl:text-4xl">Nom :</span>
            <input class="rounded-xl w-full text-lg sm:text-xl md:text-2xl lg:text-3xl xl:text-4xl border-gray-300" maxlength="32" minlength="3" type="text" id="familyName" name="familyName" required>
        </label>

        <label for="firstName"><span class="text-lg sm:text-xl md:text-2xl lg:text-3xl xl:text-4xl">Prénom :</span>
            <input class="rounded-xl w-full text-lg sm:text-xl md:text-2xl lg:text-3xl xl:text-4xl border-gray-300" maxlength="32" minlength="3" type="text" id="firstName" name="firstName" required>
        </label>

        <label for="phoneNumber"><span class="text-lg sm:text-xl md:text-2xl lg:text-3xl xl:text-4xl">Numéro de téléphone :</span>
            <input class="rounded-xl w-full text-lg sm:text-xl md:text-2xl lg:text-3xl xl:text-4xl border-gray-300" type="tel" id="phone" name="phone" pattern="\d{10}" inputmode="numeric" minlength="10" maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);" />
        </label>

        <label for="email"><span class="text-lg sm:text-xl md:text-2xl lg:text-3xl xl:text-4xl">Entrez votre mail :</span>
            <input class="rounded-xl w-full text-lg sm:text-xl md:text-2xl lg:text-3xl xl:text-4xl border-gray-300" maxlength="32" type="email" id="email" name="email" required>
        </label>

        <div class="w-full flex flex-row items-center space-x-4">
            <input type="checkbox" class="w-5 h-5 sm:w-6 sm:h-6 md:w-7 md:h-7 lg:w-8 lg:h-8 xl:w-9 xl:h-9" id="conditionsValidation" required />
            <p class="text-sm sm:text-base md:text-lg lg:text-xl xl:text-2xl">J'accepte les conditions générales d'utilisation</p>
        </div>

        <input type="submit" value="JOUER" class="text-lg sm:text-xl md:text-2xl lg:text-3xl xl:text-4xl shadow-inner bg-customBlue hover:bg-sky-300 rounded-xl w-2/3 md:w-2/5 xl:w-1/5 text-center px-2 py-2" id="playButton"/>
    </form>
</div>