<a href="/home" class="absolute left-5 top-4 md:top-5 w-12 md:w-16 h-12 md:h-16">
    <img class="p-2 bg-customBlue rounded-xl" src="/assets/images/home.svg" alt="Delete">
</a>
<div>
    <h1 class="text-3xl text-black text-center">Choisissez <span class="text-customBlue">votre spartiate</span></h1>
    <div class="result grid gap-4 p-4 grid-cols-1 md:grid-cols-2 xl:grid-cols-3">
        <?php foreach ($data as $spartan) { ?>
            <div class="spartCard cursor-pointer flex flex-col items-center justify-center w-full p-6 bg-white border border-gray-200 rounded-lg shadow-md"
                 data-id="<?= $spartan->getId() ?>">
                <?php
                if ($fileName = glob('assets/spartImage/' . strtolower($spartan->getLastname()) . '_' . strtolower($spartan->getName()) . '.*')) {
                    echo '<img class="w-24 h-32 rounded-3xl object-contain" src="' . $fileName[0] . '" alt="image du spartiate">';
                }
                ?>
                <div class="flex flex-row items-center justify-between w-full mt-2">
                    <p class="text-lg font-medium text-gray-800 mr-5"><?= $spartan->getLastname() ?> <?= $spartan->getName() ?></p>
                </div>
            </div>
        <?php } ?>
    </div>
</div>