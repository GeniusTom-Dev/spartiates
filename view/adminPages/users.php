<a href="/home" class="absolute left-5 top-5 w-20 h-20">
    <img class="p-2 bg-customBlue rounded-xl" src="/assets/images/home.svg" alt="Delete">
</a>
<a class="absolute right-5 top-5 w-16 h-16">
    <img class="p-2 bg-customBlue rounded-xl" src="/assets/images/deconnect.svg" id="deconnect" alt="deconnect">
</a>
<h1 class="titlePage">
    <span class="text-black">La</span> page users
</h1>
<div class="w-full flex justify-center items-center text-4xl"><h2 class="bg-customBlue p-5 rounded-xl" id="code"></h2>
</div>
<div class="w-full flex flex-row justify-center items-center">
    <a class="button cursor-pointer sessionAction" data-action="start"><span>Demarrer</span></a>
    <a class="button cursor-pointer sessionAction" data-action="stop"><span>Arreter</span></a>
    <!--    <a class="sessionAction" data-action="reset"><span>Reinitialiser</span></a>-->
</div>

<div class="w-full flex flex-row justify-center items-center">
    <a class="blueButton" href='/spartiates'><span>Sportifs</span></a>
    <a class="blueButton" href='/questions'><span>Questions</span></a>
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








