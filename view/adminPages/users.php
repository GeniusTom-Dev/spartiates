<script src="/assets/socket.js"></script>

<a href="/home" class="absolute left-5 top-5 w-20 h-20">
    <img class="p-2 bg-customBlue rounded-xl" src="/assets/images/home.svg" alt="Delete">
</a>
<a class="absolute right-5 top-5 w-16 h-16">
    <img class="p-2 bg-customBlue rounded-xl actionButton cursor-pointer" src="/assets/images/deconnect.svg"
         data-action="deconnect" alt="deconnect">
</a>
<div class="w-full">
    <h1 class="titlePage">
        <span class="text-black">La</span> page users
    </h1>
    <div class="w-full flex justify-center items-center text-4xl"><h2 class="bg-customBlue p-5 rounded-xl"
                                                                      id="code"></h2>
    </div>
    <div class="px-5 lg:w-full flex flex-row justify-center items-center">
        <a class="bg-white lg:w-1/3 w-full w-full h-[8vh] py-8 py-6 drop-shadow-xl text-4xl lg:text-xl my-4 mx-1 rounded-lg flex justify-center items-center cursor-pointer buttonWS"
           data-action="startWS">Demarrer</a>
        <a class="bg-white lg:w-1/3 w-full w-full h-[8vh] py-8 py-6 drop-shadow-xl text-4xl lg:text-xl my-4 mx-1 rounded-lg flex justify-center items-center cursor-pointer buttonWS"
           data-action="stopWS">Stop</a>
        <!--    <a class="sessionAction" data-action="reset">Reinitialiser</a>-->
    </div>

    <div class="px-5 lg:w-full flex flex-row justify-center items-center">
        <a class="bg-customBlue lg:w-1/3 w-full w-full h-[8vh] py-8 py-6 drop-shadow-xl text-4xl lg:text-xl my-4 mx-1 rounded-lg flex justify-center items-center cursor-pointer"
           href='/spartiates'>Sportifs</a>
        <a class="bg-customBlue lg:w-1/3 w-full w-full h-[8vh] py-8 py-6 drop-shadow-xl text-4xl lg:text-xl my-4 mx-1 rounded-lg flex justify-center items-center cursor-pointer"
           href='/questions'>Questions</a>
    </div>

    <div class="container mx-auto px-4 py-8">
        <h1 class="text-4xl font-bold text-center mb-4">Classement</h1>
        <table class="w-full table-auto border-collapse">
            <thead>
            <tr class="bg-gray-100">
                <th class="px-4 py-2 border">Rang</th>
                <th class="px-4 py-2 border">Nom</th>
                <th class="px-4 py-2 border">Score</th>
                <th class="w-1"></th> <!-- Ajouter une colonne vide pour le bouton -->
            </tr>
            </thead>
            <tbody id="ranking">
            </tbody>
        </table>
    </div>
</div>







