<?php
?>
<a href="/home" class="absolute left-5 top-5 w-20 h-20">
    <img class="p-2 bg-customBlue rounded-xl" src="/assets/images/home.svg" alt="Home">
</a>

<div class="flex justify-center items-center min-h-screen">
    <form class="mt-5 rounded-md shadow-xl flex flex-col justify-center space-y-6 py-16 px-14 bg-white w-full max-w-2xl md:w-[95vw] sm:w-[90vw]"
          id="verificationForm" method="post">
        <input type="hidden" name="action" value="logIn">

        <h1 class="text-center text-[5vh]">Connexion</h1>

        <p class="text-[2vh] text-gray-500 text-center">Veuillez vous connecter pour accéder à l'administration.</p>

        <label class="text-[2.5vh] mb-5 text-left" for="login">Nom d'utilisateur :</label>
        <input name="login" id="login" type="text" placeholder="ex. Jane Doe" class="w-full p-3 border rounded-md text-[2.5vh] mb-16 mt-5 h-[8vh]" min="3" max="20"/>

        <label class="text-[2.5vh] mb-5 text-left" for="password">Mot de passe :</label>
        <input name="password" id="password" type="password" placeholder="Mot de passe" class="w-full p-3 border rounded-md text-[2.5vh] mb-5 mt-5 h-[8vh]"/>

        <div class="text-red-700" id="res"></div>
        <input class="bg-customBlue text-white rounded-xl px-4 py-3 text-[2.5vh] cursor-pointer hover:bg-sky-300" type="submit" name="submit" value="Se connecter"/>
    </form>
</div>
