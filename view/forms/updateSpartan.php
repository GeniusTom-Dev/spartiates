<a href="/home" class="absolute left-5 top-4 md:top-5 w-12 md:w-16 h-12 md:h-16">
    <img class="p-2 bg-customBlue rounded-xl" src="../../assets/images/icon/home.svg" alt="Home">
</a>
<form class="bg-white p-8 md:p-10 rounded-md drop-shadow-xl flex flex-col space-y-5 max-w-md mx-auto" id="form" method="post" enctype="multipart/form-data">
    <input type="hidden" name="action" value="updateSpartan">
    <input type="hidden" name="id" value="<?= $data->getId() ?>">
    <h1 class="text-2xl text-center">Mise à jour question Spartiate</h1>
    <label for="lastName" class="text-left">Nom :</label>
    <input name="lastName" id="lastName" type="text" value="<?= $data->getLastname() ?>" pattern=".*\S.*" maxlength="32" required class="rounded-xl border-gray-300 border w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
    <label for="name" class="text-left">Prénom :</label>
    <input name="name" id="name" type="text" value="<?= $data->getName() ?>" pattern=".*\S.*" maxlength="32" required class="rounded-xl border-gray-300 border w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
    <label class="w-full text-lg md:text-xl">Nouvelle photo :
        <input class="rounded w-full mt-2 p-1" type="file" name="fileToUpload" id="fileToUpload" accept="image/png, image/jpeg, image/jpg">
    </label>
    <input class="bg-customBlue rounded-xl text-lg py-3 px-6 hover:bg-sky-300 cursor-pointer" type="submit" name="update" value="Mettre à jour">
</form>

