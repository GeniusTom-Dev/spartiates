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
        <div id="res" class="text-red-600"></div>

        <label class="text-[2.5vh] mb-5 text-left" for="confirmPassword">Confirmation mot de passe :</label>
        <input name="confirmPassword" id="confirmPassword" type="password" placeholder="Mot de passe"
               class="w-full p-3 border rounded-md text-[2.5vh] mb-5 mt-5 h-[8vh]"/>

        <div class="text-red-700" id="res"></div>
        <input id="validateButton" class="bg-customBlue text-white rounded-xl px-4 py-3 text-[2.5vh] cursor-pointer hover:bg-sky-300"
               type="submit" name="submit" value="Valider"/>
    </form>
</div>

<script>
    function validatePassword(password) {
        // At least 8 characters
        if(password.length < 8) {
            return false;
        }

        // At least 1 uppercase letter
        if(!/[A-Z]/.test(password)) {
            return false;
        }

        // At least 1 lowercase letter
        if(!/[a-z]/.test(password)) {
            return false;
        }

        // At least 1 digit
        if(!/[0-9]/.test(password)) {
            return false;
        }

        // At least 1 special character
        return /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/.test(password);

    }

    document.getElementById("validateButton").addEventListener("click", function(event) {
        var password = document.getElementById("newPassword").value;
        var confirmPassword = document.getElementById("confirmPassword").value;

        if(!validatePassword(password)) {
            document.getElementById("res").innerHTML = "<p>Le mot de passe doit contenir au moins 8 caractères avec :</p><ul><li>Au moins 1 majuscule</li><li>Au moins 1 minuscule</li><li>Au moins 1 chiffre</li><li>Au moins un caractère spécial [!@#$%^&*()_+\-=\[\]{};':\"\\|,.<>\/?]</li></ul>";
            event.preventDefault();
        } else if(password !== confirmPassword) {
            document.getElementById("res").innerHTML = "Les mots de passe ne correspondent pas.";
            event.preventDefault();
        }
    });
</script>
