<a href="/home" class="absolute left-5 top-5 w-20 h-20">
    <img class="p-2 bg-customBlue rounded-xl" src="/assets/images/home.svg" alt="Delete">
</a>
<div class="result grid gap-4 p-4 grid-cols-1 md:grid-cols-2 xl:grid-cols-3">
    <?php foreach ($data as $spartiate) { ?>
        <div class="spartCard cursor-pointer flex flex-col items-center justify-center w-full p-6 bg-white border border-gray-200 rounded-lg shadow-md"
             data-id="<?= $spartiate->getSpart_id() ?>">
            <?php
            if ($fileName = glob('assets/spartImage/' . strtolower($spartiate->getLastname()) . '_' . strtolower($spartiate->getName()) . '.*')) {
                echo '<img class="w-24 h-32 rounded-3xl object-contain" src="' . $fileName[0] . '" alt="image du spartiate">';
            }
            ?>
            <div class="flex flex-row items-center justify-between w-full mt-2">
                <p class="text-lg font-medium text-gray-800 mr-5"><?= $spartiate->getLastname() ?> <?= $spartiate->getName() ?></p>
            </div>
        </div>
    <?php } ?>
</div>
