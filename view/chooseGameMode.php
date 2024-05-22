<a href="/home" class="absolute left-5 top-5 w-20 h-20">
    <img class="p-2 bg-customBlue rounded-xl" src="/assets/images/home.svg" alt="Delete">
</a>
<div class="flex flex-col space-y-5">
    <h1 class="text-3xl text-black text-center">Choisissez votre mode de Jeu</h1>

    <div id="chooseDefense"
         class="chooseButton cursor-pointer flex flex-col items-center justify-center w-full p-6 bg-white border border-gray-200 rounded-lg shadow-md"
         data-action="chooseAttack">
        <p class="text-3xl font-medium text-gray-800">Attaque</p>
    </div>
    <div id="chooseAttack"
         class="chooseButton cursor-pointer flex flex-col items-center justify-center w-full p-6 bg-white border border-gray-200 rounded-lg shadow-md"
         data-action="chooseDefense">
        <p class="text-3xl font-medium text-gray-800">Défense</p>
    </div>


</div>