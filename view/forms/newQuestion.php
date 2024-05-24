<a href="/home" class="absolute left-5 top-5 w-20 h-20">
    <img class="p-2 bg-customBlue rounded-xl" src="/assets/images/home.svg" alt="Delete">
</a>
    <form class="bg-white p-10 rounded-md drop-shadow-xl flex flex-col justify-center items-center space-y-5" id="form" method="post">
        <input type="hidden" name="action" value="createQuestion">
        <h1 class="text-2xl"> Nouvelle question </h1>
        <p hidden class="text-red-600 text-md">Veuillez remplir tous les champs.</p>
        <label>Question :
            <textarea id="question" class="w-full rounded-xl" type="text" name="text" required></textarea>
        </label>
        <label>Bonne réponse :
            <textarea id="goodAnswer" class="w-full rounded-xl" type="text" name="true" required></textarea>
        </label>
        <label>Mauvaise réponse 1 :
            <textarea id="badAnswer1" class="w-full rounded-xl" type="text" name="false1" required></textarea>
        </label>
        <label>Mauvaise réponse 2 :
            <textarea id="badAnswer2" class="w-full rounded-xl" type="text" name="false2" required></textarea>
        </label>
        <input id="createQuestion" class="bg-blue-500 rounded-xl text-lg py-4 px-8" type="submit" name="create" value="Créer">
    </form>
