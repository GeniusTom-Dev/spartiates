<a href="/home" class="absolute left-5 top-4 md:top-5 w-12 md:w-16 h-12 md:h-16">
    <img class="p-2 bg-customBlue rounded-xl" src="/assets/images/home.svg" alt="Home">
</a>
<form class="bg-white p-10 rounded-md drop-shadow-xl flex flex-col justify-center items-center space-y-5 w-full max-w-lg mx-auto" id="form" method="post">
    <input type="hidden" name="action" value="updateQuestion">
    <input type="hidden" name="id" value="<?= $data->getId() ?>">
    <h1 class="text-2xl">Mise à jour question</h1>

    <div class="w-full">
        <label>Question :
            <textarea id="question" class="w-full rounded-xl mt-2 p-2 border-gray-300" type="text" name="text" required><?= $data->getText() ?></textarea>
        </label>
        <p id="counter" class="text-[2vh] text-gray-600 text-right w-full">0/150</p>
    </div>

    <div class="w-full">
        <label>Bonne réponse :
            <textarea class="w-full rounded-xl mt-2 p-2 border-gray-300" type="text" name="true" required maxlength="25"><?= $data->getAnswer() ?></textarea>
        </label>
    </div>

    <div class="w-full">
        <label>Mauvaise réponse 1 :
            <textarea class="w-full rounded-xl mt-2 p-2 border-gray-300" type="text" name="false1" required maxlength="25"><?= $data->getFalse1() ?></textarea>
        </label>
    </div>

    <div class="w-full">
        <label>Mauvaise réponse 2 :
            <textarea class="w-full rounded-xl mt-2 p-2 border-gray-300" type="text" name="false2" required maxlength="25"><?= $data->getFalse2() ?></textarea>
        </label>
    </div>

    <input id="updateQuestion" class="bg-customBlue hover:bg-sky-300 rounded-xl text-lg py-4 px-8" type="submit" name="update" value="Mettre à jour">
</form>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const question = document.getElementById("question");
        const counter = document.getElementById("counter");
        const submitButton = document.getElementById("updateQuestion");


        counter.innerHTML = question.value.length + "/150";
        if (question.value.length >= 150) {
            counter.style.color = "red";
            submitButton.disabled = true;
        } else {
            counter.style.color = "grey";
            submitButton.disabled = false;
        }

        question.addEventListener("input", function() {
            const charCount = this.value.length;
            counter.innerHTML = charCount + "/200";

            if (charCount >= 200) {
                counter.style.color = "red";
                submitButton.disabled = true;
            } else {
                counter.style.color = "grey";
                submitButton.disabled = false;
            }
        });
    });
</script>
