<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="description" content="Serious Game de hockey pour les Spartiate de Marseille"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../favicon.ico" type="image/x-icon"/>
    <title>%title%</title>
    <!--   style   -->
    <link rel="stylesheet" href="/dist/output.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="/dist/bundle.js"></script>
    <script src="/dist/jquery.min.js"></script>
    <script src="../assets/script/index.js" defer></script>
    <script src="../assets/script/gameController.js" type="module"></script>
</head>

<body class="bg-[var(--color-bg)] flex flex-col min-h-screen">

<header class="bg-cover bg-bottom bg-no-repeat h-[15vh] sm:h-[13vh] md:h-[15vh] lg:h-[20vh] xl:h-[25vh] 2xl:h-[35vh] relative mb-5"
        style="background-image: url('/assets/images/layout/header.png')">
    <a href="https://marseillehockeyclub.com" target="_blank">
        <img class="mt-2 w-1/2 sm:w-1/3 md:w-1/4 lg:w-1/4 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2"
             src="/assets/images/logo.png" alt="lg-logo">
    </a>
    <img class="w-1/5 absolute bottom-0 right-0" src="../assets/images/layout/headerLines.png" alt="headerLines">
</header>

<div class="flex-1 px-5 flex items-center justify-center">
    %content%
</div>

<footer class="bg-cover bg-top h-[15vh] sm:h-[13vh] md:h-[15vh] lg:h-[20vh] xl:h-[25vh] 2xl:h-[35vh] relative -z-10" style="background-image: url('/assets/images/layout/footer.png')">
    <img class="w-1/5 absolute bottom-0 right-0" src="../assets/images/layout/headerLines.png" alt="headerLines.png">
</footer>

</body>
</html>