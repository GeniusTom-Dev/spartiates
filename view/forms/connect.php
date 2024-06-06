<?php
?>
<a href="/home" class="absolute left-5 top-4 md:top-5 w-12 md:w-16 h-12 md:h-16">
    <img class="p-2 bg-customBlue rounded-xl" src="../../assets/images/icon/home.svg" alt="Home">
</a>

<div class="inline-flex">
        <form class="mt-2 mb-0 rounded-md shadow-xl flex flex-col justify-center space-y-6 py-8 px-14 bg-white w-full max-w-2xl md:w-[95vw] sm:w-[90vw]" id="verificationForm" method="post">
       <input type="hidden" name="action" value="logIn">

        <h1 class="text-center text-[3vh]">Connexion</h1>

        <p class="text-[2vh] text-gray-500 text-center">Veuillez vous connecter pour accéder à l'administration.</p>

        <label class="text-[2.5vh] mb-5 text-left" for="login">Nom d'utilisateur :</label>
        <input name="login" id="login" type="text" placeholder="ex. Jane Doe" class="w-full p-3 border rounded-md text-[2.5vh] mb-16 mt-5 h-[7vh]" min="3" max="20"/>

        <label class="text-[2.5vh] mb-5 text-left" for="password">Mot de passe :</label>
        <input name="password" id="password" type="password" placeholder="Mot de passe" class="w-full p-3 border rounded-md text-[2.5vh] mb-5 mt-5 h-[7vh]"/>
        <a href="/connect" id="forgot-password" class="text-[2vh] text-right hover:underline cursor-pointer">Mot de passe oublié ?</a>

        <p id="email-sent-message" class="text-[2.5vh] text-center hidden">Un e-mail vous a été envoyé</p>

        <div class="text-red-700" id="res"></div>
        <input id="connectButton" class="bg-customBlue text-white rounded-xl px-4 py-3 text-[2.5vh] cursor-pointer hover:bg-sky-300" type="submit" name="submit" value="Se connecter"/>

    </form>
</div>

<script>
    document.getElementById('forgot-password').addEventListener('click', function(event) {
        event.preventDefault();
        $.ajax({
            type: "POST",
            url: "/index.php",
            data: {
                action: "sendResetEmail",
            },
            dataType: 'json',
            success: function (data) {
                if (data.success) {
                    const emailSentMessage = document.getElementById('email-sent-message');
                    emailSentMessage.classList.remove('hidden');
                    setTimeout(() => {
                        emailSentMessage.classList.add('hidden');
                    }, 10000);
                } else {
                    alert('Impossible d\'envoyer l\'email. Veuillez réessayer plus tard.');
                }
            },
            error: function (xhr, status, error) {
                console.error('Error:', error);
            }
        });
    });

    let connectButton = document.getElementById("connectButton");
    connectButton.addEventListener('click', function(event) {
        $.ajax({
            type: "POST",
            url: "/index.php",
            data: {
                action: "logIn",
                login : document.getElementById("login").value,
                password : document.getElementById("password").value
            },
            dataType: 'json',
            success: function (data) {
                if (data.success === false) {
                    connectButton.disabled = true;
                    connectButton.value = 'Réessayez dans 3 secondes...';
                    document.getElementById("res").style.display = 'block'
                    setTimeout(() => {
                        connectButton.disabled = false;
                        connectButton.value = 'Se connecter';
                    }, 3000);
                }
            },
        });
    });
</script>
