<a href="/home" class="absolute left-5 top-5 w-20 h-20">
    <img class="p-2 bg-customBlue rounded-xl" src="/assets/images/home.svg" alt="Delete">
</a>
    <form class="bg-white p-10 rounded-md drop-shadow-xl flex flex-col justify-center items-center space-y-5" id="form"
          method="post">
        <input type="hidden" name="action" value="updateSpartiate">
        <input type="hidden" name="id" value="<?= $data->getSpart_id() ?>">
        <h1 id="login"> Mise a jour question Spartiate </h1>
        <label>Nom :</label>
        <input name="lastName" id="lastName" type="text" value="<?= $data->getLastname() ?>" required/>
        <label>Prenom :</label>
        <input name="name" id="name" type="text" value="<?= $data->getName() ?>" required/>
        <input class="bg-blue-500 rounded-xl text-lg py-4 px-8" type="submit" name="update" value="Mettre a jour">
    </form>
