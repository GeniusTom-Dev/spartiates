<div class="w-full flex flex-col justify-center items-center h-[40vh]">
    <a class="button" href="<?php echo !empty($_SESSION['code']) ? '/play' : '/sessionCode' ?>"><span>JOUER</span></a>
    <a class="button" href='/rules'><span>LES REGLES</span></a>
    <a class="blueButton" href='/users'><span>ADMIN</span></a>
</div>
