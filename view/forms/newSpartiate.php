<a href="/home" class="absolute left-5 top-5 w-20 h-20">
    <img class="p-2 bg-customBlue rounded-xl" src="/assets/images/home.svg" alt="Delete">
</a>
    <form class="bg-white p-10 rounded-md drop-shadow-xl flex flex-col justify-center items-center space-y-5" id="form"
          method="post" enctype="multipart/form-data">
        <input type="hidden" name="action" value="createSpartiate">
        <h1 id="login"> Nouveau Spartiate </h1>
        <label>Nom :<br>
            <input class="rounded-xl" name="lastName" id="lastName" type="text" required/>
        </label>
        <label>Prenom :<br>
            <input class="rounded-xl" name="name" id="name" type="text" required/>
        </label>
        <input type="file" name="fileToUpload" id="fileToUpload" required>
        <input class="bg-blue-500 rounded-xl text-lg py-4 px-8" type="submit" name="create" value="Créer">
    </form>
