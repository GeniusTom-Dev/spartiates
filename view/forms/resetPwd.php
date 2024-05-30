<a href="/home" class="absolute left-5 top-4 md:top-5 w-12 md:w-16 h-12 md:h-16">
    <img class="p-2 bg-customBlue rounded-xl" src="/assets/images/home.svg" alt="Home">
</a>

<div class="flex justify-center items-center min-h-screen">
    <form class="mt-5 rounded-md shadow-xl flex flex-col justify-center space-y-6 py-16 px-14 bg-white w-full max-w-2xl md:w-[95vw] sm:w-[90vw]"
          id="resetPasswordForm" method="post">
        <input type="hidden" name="action" value="reset">
        <input type="hidden" name="token" value="<?php echo htmlspecialchars($_GET['token']); ?>">

        <h1 class="text-center text-[5vh]">Mise à jour mot de passe</h1>

        <label class="text-[2.5vh] mb-5 text-left" for="newPassword">Nouveau mot de passe :</label>
        <input name="newPassword" id="newPassword" type="password" placeholder="Mot de passe"
               class="w-full p-3 border rounded-md text-[2.5vh] mb-16 mt-5 h-[8vh]" min="3" max="20"/>

        <label class="text-[2.5vh] mb-5 text-left" for="confirmPassword">Confirmation mot de passe :</label>
        <input name="confirmPassword" id="confirmPassword" type="password" placeholder="Mot de passe"
               class="w-full p-3 border rounded-md text-[2.5vh] mb-5 mt-5 h-[8vh]"/>

        <div class="text-red-700" id="res"></div>
        <input class="bg-customBlue text-white rounded-xl px-4 py-3 text-[2.5vh] cursor-pointer hover:bg-sky-300"
               type="submit" name="submit" value="Valider"/>
    </form>
</div>
