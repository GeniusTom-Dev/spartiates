<script src="/assets/socket.js"></script>

<a href="/home" class="absolute left-5 top-5 w-20 h-20">
    <img class="p-2 bg-customBlue rounded-xl" src="/assets/images/home.svg" alt="Home">
</a>
<a class="absolute right-5 top-5 w-16 h-16 cursor-pointer">
    <img class="p-2 bg-customBlue rounded-xl actionButton" src="/assets/images/deconnect.svg"
         data-action="deconnect" alt="Disconnect">
</a>

<div class="w-full p-4">
    <h1 class="titlePage text-center text-3xl md:text-4xl lg:text-5xl mb-4">
        <span class="text-black">La</span> page users
    </h1>
    <div class="w-full flex justify-center items-center text-xl md:text-2xl lg:text-4xl mb-4">
        <h2 class="bg-customBlue p-4 md:p-5 rounded-xl" id="code"></h2>
    </div>
    <div class="px-5 w-full flex flex-col lg:flex-row justify-center items-center space-y-4 lg:space-y-0 lg:space-x-4 mb-4">
        <a class="bg-white lg:w-1/3 w-full h-[8vh] py-4 md:py-6 lg:py-8 drop-shadow-xl text-xl md:text-2xl lg:text-4xl rounded-lg flex justify-center items-center cursor-pointer buttonWS"
           data-action="startWS">Demarrer</a>
        <a class="bg-white lg:w-1/3 w-full h-[8vh] py-4 md:py-6 lg:py-8 drop-shadow-xl text-xl md:text-2xl lg:text-4xl rounded-lg flex justify-center items-center cursor-pointer buttonWS"
           data-action="stopWS">Stop</a>
    </div>

    <div class="px-5 w-full flex flex-col lg:flex-row justify-center items-center space-y-4 lg:space-y-0 lg:space-x-4 mb-4">
        <a class="bg-customBlue lg:w-1/3 w-full h-[8vh] py-4 md:py-6 lg:py-8 drop-shadow-xl text-xl md:text-2xl lg:text-4xl rounded-lg flex justify-center items-center cursor-pointer"
           href='/spartiates'>Sportifs</a>
        <a class="bg-customBlue lg:w-1/3 w-full h-[8vh] py-4 md:py-6 lg:py-8 drop-shadow-xl text-xl md:text-2xl lg:text-4xl rounded-lg flex justify-center items-center cursor-pointer"
           href='/questions'>Questions</a>
    </div>

    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-center mb-4">Classement</h1>
        <table class="w-full table-auto border-collapse">
            <thead>
            <tr class="bg-gray-100">
                <th class="px-2 md:px-4 py-2 border">Rang</th>
                <th class="px-2 md:px-4 py-2 border">Nom</th>
                <th class="px-2 md:px-4 py-2 border">Score</th>
                <th class="w-1"></th> <!-- Ajouter une colonne vide pour le bouton -->
            </tr>
            </thead>
            <tbody id="ranking">
            </tbody>
        </table>
    </div>
</div>
