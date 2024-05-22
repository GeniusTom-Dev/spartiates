<a href="/home" class="absolute left-5 top-5 w-20 h-20">
    <img class="p-2 bg-customBlue rounded-xl" src="/assets/images/home.svg" alt="Delete">
</a>
    <form class="bg-white p-10 rounded-md drop-shadow-xl flex flex-col justify-center items-center space-y-5" id="form"
          method="post">
        <input type="hidden" name="action" value="updateQuestion">
        <input type="hidden" name="id" value="<?= $data->getQuestion_id() ?>">
        <h1> Mise a jour question </h1>
        <label>Question :
            <textarea class="w-full rounded-xl" type="text" name="text" required><?= $data->getText() ?></textarea>
        </label>
        <label>Niveau :</label>
        <select name="level" required>
            <option value="attaquant" <?php if ($data->getDifficulty() === "ATTAQUANT") echo 'selected' ?> >Attaquant
            </option>
            <option value="defenseur" <?php if ($data->getDifficulty() === "DEFENSEUR") echo 'selected' ?>>Defenseur
            </option>
            <option value="gardien" <?php if ($data->getDifficulty() === "GARDIEN") echo 'selected' ?>>Gardien</option>
        </select>
        <label>Bonne réponse :
            <textarea class="w-full rounded-xl" type="text" name="true" required><?= $data->getResponse() ?></textarea>
        </label>
        <label>Mauvaise réponse 1 :
            <textarea class="w-full rounded-xl" type="text" name="false1" required><?= $data->getFalse1() ?></textarea>
        </label>
        <label>Mauvaise réponse 2 :
            <textarea class="w-full rounded-xl" type="text" name="false2" required><?= $data->getFalse2() ?></textarea>
        </label>
        <input class="bg-blue-500 rounded-xl text-lg py-4 px-8" type="submit" name="update" value="Mettre a jour">
    </form>
