<script src="/assets/socket.js"></script>

<div class="w-full lg:w-2/3 h-full flex flex-col">
    <div class="w-full h-[12vh] flex justify-center items-center text-center">
        <h2 id="question">Lorem ipsum dolor sit amet. C’est juste un texte exemple pour visualiser les choses ?</h2>
    </div>
    <div class="w-full h-[28vh]">
        <div class="w-full h-[8vh] flex items-center justify-around">
            <div class="w-16 h-16 rounded-full shadow-inner bg-customBlue border-2 flex justify-center items-center cursor-pointer" id="targetA">A</div>
            <div class="w-16 h-16 rounded-full shadow-inner bg-customBlue border-2 flex justify-center items-center cursor-pointer" id="targetB">B</div>
            <div class="w-16 h-16 rounded-full shadow-inner bg-customBlue border-2 flex justify-center items-center cursor-pointer" id="targetC">C</div>
        </div>

        <div class="w-full h-[20vh] flex justify-center flex-wrap-reverse relative" id="container">
            <img src="/assets/images/default_spartiates.png" alt="default spartiates" id="spartiates" class="h-2/3 absolute bottom-0 left-1/2 -translate-x-1/2 z-20">
            <img src="/assets/images/puck.png" alt="puck" id="puck" class="absolute bottom-[10%] left-1/2 z-10 -translate-x-1/2">
        </div>
    </div>
    <div class="w-full h-[20vh]">
        <button class="w-full h-1/3 shadow-inner bg-customBlue border-2 flex justify-center items-center cursor-pointer my-2" id="answerA"></button>
        <button class="w-full h-1/3 shadow-inner bg-customBlue border-x-2 flex justify-center items-center cursor-pointer my-2" id="answerB"></button>
        <button class="w-full h-1/3 shadow-inner bg-customBlue border-2 flex justify-center items-center cursor-pointer my-2" id="answerC"></button>
    </div>
</div>

<div class="absolute w-full h-full z-50 top-0 bg-customBlueDark opacity-95 flex flex-col items-center justify-center space-y-5 text-white"
     id="endGame" style="display: none">
    <span>
        <label class="text-5xl">Felicitation </label>
        <label class="text-5xl" id="username"></label>
        <label class="text-5xl">!</label>
    </span>
    <span>
        <label class="text-5xl">Score : </label>
        <label class="text-5xl" id="scoreEnd"></label>
    </span>
    <span>
        <label class="text-5xl">Classement : #</label>
        <label class="text-5xl" id="rank"></label>
    </span>
    <a href="/home" class="p-5 bg-customBlue opacity-100 rounded-xl text-4xl">
        Retour à l'accueil
    </a>
</div>