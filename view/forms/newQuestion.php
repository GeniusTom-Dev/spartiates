<a href="/home" class="absolute left-5 top-4 md:top-5 w-12 md:w-16 h-12 md:h-16">
    <img class="p-2 bg-customBlue rounded-xl" src="/assets/images/home.svg" alt="Home">
</a>
<form class="bg-white p-10 rounded-md drop-shadow-xl flex flex-col justify-center items-center space-y-5 w-full max-w-lg mx-auto" id="form" method="post">
    <input type="hidden" name="action" value="createQuestion">
    <h1 class="text-2xl">Nouvelle question</h1>
    <p hidden class="text-red-600 text-md">Veuillez remplir tous les champs.</p>
    <label class="w-full">Question :
        <textarea id="question" class="w-full rounded-xl mt-2 p-2 border-gray-300" name="text" required></textarea>
    </label>
    <label class="w-full">Bonne réponse :
        <textarea id="goodAnswer" class="w-full rounded-xl mt-2 p-2 border-gray-300" name="true" required></textarea>
    </label>
    <label class="w-full">Mauvaise réponse 1 :
        <textarea id="badAnswer1" class="w-full rounded-xl mt-2 p-2 border-gray-300" name="false1" required></textarea>
    </label>
    <label class="w-full">Mauvaise réponse 2 :
        <textarea id="badAnswer2" class="w-full rounded-xl mt-2 p-2 border-gray-300" name="false2" required></textarea>
    </label>
    <input id="createQuestion" class="bg-customBlue hover:bg-sky-300 rounded-xl text-lg py-4 px-8" type="submit" name="create" value="Créer">
</form>
