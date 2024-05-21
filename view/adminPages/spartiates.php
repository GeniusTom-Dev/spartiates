<a href="/home" class="absolute left-5 top-5 w-20 h-20">
    <img class="p-2 bg-customBlue rounded-xl" src="/assets/images/home.svg" alt="Delete">
</a>
<a class="absolute right-5 top-5 w-16 h-16">
    <img class="p-2 bg-customBlue rounded-xl" src="/assets/images/deconnect.svg" id="deconnect" alt="deconnect">
</a>
<h1 class="titlePage">
    <span class="text-black">Les</span> Spartiates
</h1>

<div class="w-full flex flex-row justify-center items-center">
    <a class="button" href='/users'><span>Utilisateurs</span></a>
    <a class="button" href='/questions'><span>Questions</span></a>
</div>

<div class="flex flex-col items-center justify-center">
    <button class="blueButton" onclick="window.location.href='/newSpartiate'">Nouveau Joueur</button>
    <div class="flex flex-row items-center justify-between w-full px-4 py-2 border-b border-gray-200">
        <input type="text" placeholder="Rechercher" id="searchSpartiate"
               class="w-full px-4 py-2 text-gray-700 bg-gray-200 border border-gray-200 rounded-lg focus:outline-none focus:bg-white focus:border-gray-500">
    </div>
    <div class="searchedResult grid gap-4 p-4 grid-cols-1 md:grid-cols-2 xl:grid-cols-3" style="display: none;"></div>
    <div class="result grid gap-4 p-4 grid-cols-1 md:grid-cols-2 xl:grid-cols-3">
        <?php foreach ($data as $spartiate) { ?>
            <div class="flex flex-col items-center justify-center w-full p-6 bg-white border border-gray-200 rounded-lg shadow-md">
                <?php
                if ($fileName = glob('assets/spartImage/' . strtolower($spartiate->getLastname()) . '_' . strtolower($spartiate->getName()) . '.*')) {
                    echo '<img class="w-24 h-32 rounded-3xl object-contain" src="' . $fileName[0] . '" alt="image du spartiate">';
                }
                ?>

                <div class="flex flex-row items-center justify-between w-full mt-2">
                    <p class="text-lg font-medium text-gray-800 mr-5"><?= $spartiate->getLastname() ?> <?= $spartiate->getName() ?></p>
                    <div class="flex flex-row space-x-2">
                        <div class="inline-block w-8 h-8 bg-customBlue hover:bg-blue-700 rounded cursor-pointer">
                            <img class="p-1 star" data-spartiate-id="<?= $spartiate->getSpart_id() ?>"
                                 data-filled="<?= $spartiate->isStarred() ?>"
                                 src="<?php echo $spartiate->isStarred() ? '/assets/images/fullStar.svg' : '/assets/images/emptyStar.svg'; ?>"
                                 alt="etoile du match">
                        </div>
                        <a href="/updateSpartiate?id=<?= $spartiate->getSpart_id() ?>"
                           class="inline-block w-8 h-8 bg-customBlue hover:bg-blue-700 rounded">
                            <img class="p-1" src="/assets/images/edit.svg" alt="Edit">
                        </a>
                        <button id="callActionButton" data-id="<?= $spartiate->getSpart_id() ?>"
                                data-modal-target="deleteModalSpartiate" data-modal-toggle="deleteModalSpartiate"
                                class="inline-block w-8 h-8 bg-red-500 hover:bg-red-700 rounded" type="button">
                            <img class="p-1" src="/assets/images/trashcan.svg" alt="Delete">
                        </button>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

<!-- Main modal -->
<div id="deleteModalSpartiate" tabindex="-1" aria-hidden="true"
     class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-modal md:h-full">
    <div class="relative p-4 w-full max-w-md h-full md:h-auto">
        <!-- Modal content -->
        <div class="relative p-4 text-center rounded-lg shadow bg-customBlueDark sm:p-5">
            <button type="button"
                    class="text-gray-400 absolute top-2.5 right-2.5 bg-transparent rounded-lg text-sm p-1.5 ml-auto inline-flex items-center hover:bg-gray-600 hover:text-white"
                    data-modal-toggle="deleteModalSpartiate">
                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                     xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                          d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                          clip-rule="evenodd"></path>
                </svg>
                <span class="sr-only">Close modal</span>
            </button>
            <img class="text-gray-500 w-11 h-11 mb-3.5 mx-auto" aria-hidden="true"
                 src="/assets/images/trashcan.svg" </img>
            <p class="mb-4 text-gray-300">Etes vous sur de vouloir supprimer ?</p>
            <div class="flex justify-center items-center space-x-4">
                <button data-modal-toggle="deleteModalSpartiate" type="button"
                        class="py-2 px-3 text-sm font-medium rounded-lg border focus:ring-4 focus:outline-none focus:ring-primary-300 focus:z-10 bg-gray-700 text-gray-300 border-gray-500 hover:text-white hover:bg-gray-600 focus:ring-gray-600">
                    Non, annuler
                </button>
                <button data-action="deleteSpartiate" id="actionButton"
                        class="py-2 px-3 text-sm font-medium text-center text-white rounded-lg focus:ring-4 focus:outline-none bg-red-500 hover:bg-red-600 focus:ring-red-900 cursor-pointer">
                    Oui, supprimer
                </button>
            </div>
        </div>
    </div>
</div>