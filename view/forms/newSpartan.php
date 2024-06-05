<a href="/home" class="absolute left-5 top-4 md:top-5 w-12 md:w-16 h-12 md:h-16">
    <img class="p-2 bg-customBlue rounded-xl" src="/assets/images/home.svg" alt="Home">
</a>
<form class="bg-white p-6 md:p-10 rounded-md drop-shadow-xl flex flex-col justify-center items-center space-y-5 w-full max-w-lg mx-auto" id="form" method="post" enctype="multipart/form-data">
    <input type="hidden" name="action" value="createSpartan">
    <h1 class="text-2xl md:text-3xl lg:text-4xl mb-4" id="username">Nouveau Spartiate</h1>
    <label class="w-full text-lg md:text-xl">Nom :
        <input class="rounded-xl w-full mt-2 p-2 border-gray-300" name="lastName" id="lastName" type="text" required maxlength="32"/>
    </label>
    <label class="w-full text-lg md:text-xl">Prénom :
        <input class="rounded-xl w-full mt-2 p-2 border-gray-300" name="name" id="name" type="text" required maxlength="32"/>
    </label>
    <label class="w-full text-lg md:text-xl">Télécharger une photo :
        <input class="rounded w-full mt-2 p-1" type="file" name="fileToUpload" id="fileToUpload" required accept="image/png, image/jpeg, image/jpg">
    </label>
    <input class="bg-customBlue hover:bg-sky-300 text-white rounded-xl text-lg py-4 px-8 mt-4" type="submit" name="create" value="Créer">
</form>
