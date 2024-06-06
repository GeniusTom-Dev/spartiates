<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="description" content="Serious Game de hockey pour les Spartiate de Marseille"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../favicon.ico" type="image/x-icon"/>
    <title>%title%</title>
    <link rel="stylesheet" href="/dist/output.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="/dist/bundle.js"></script>
    <script src="/dist/jquery.min.js"></script>
    <script src="../assets/script/index.js" defer></script>
    <script src="../assets/script/gameController.js" type="module"></script>
    <style>
        html, body {
            height: 100%;
            margin: 0;
            /*overflow: hidden;*/
        }
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            position: relative;
        }
        .bg-image {
            position: fixed;
            width: 100%;
            z-index: -1;
            background-size: cover;
            background-position: center;
        }
        .bg-header {
            top: 0;
            height: 25vh; /* Ajustez la hauteur selon vos besoins */
            background-image: url('/assets/images/layout/newHeader.png');
        }
        .bg-footer {
            bottom: 0;
            height: 25vh; /* Ajustez la hauteur selon vos besoins */
            background-image: url('/assets/images/layout/newFooter.png');
        }
        .content {
            flex: 1;
            overflow-y: auto;
            width: 100%;
            padding: 0 5px; /* Ajustez le padding si nécessaire */
        }
    </style>
</head>

<body class="bg-[var(--color-bg)]">

<div class="bg-image bg-header"></div>
<header class="bg-cover bg-bottom bg-no-repeat h-[12vh] sm:h-[13vh] md:h-[10vh] lg:h-[15vh] xl:h-[15vh] 2xl:h-[20vh] relative mb-5"
        style="background-image: url('/assets/images/header.png')">
    <a href="https://marseillehockeyclub.com" target="_blank">
        <img class="mt-5 w-1/2 sm:w-1/3 md:w-1/4 lg:w-1/4 xl:w-1/5 2xl:w-1/6 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2"
             src="/assets/images/logo.png" alt="lg-logo">
    </a>
    <img class="w-1/5 absolute bottom-0 right-0" src="/assets/images/headerLines.png" alt="headerLines">
</header>

<div class="content flex items-center justify-center">
    %content%
</div>

<div class="bg-image bg-footer"></div>
<footer class="bg-cover bg-top h-[12vh] sm:h-[13vh] md:h-[10vh] lg:h-[15vh] xl:h-[20vh] 2xl:h-[20vh] relative -z-10" style="background-image: url('/assets/images/footer.png')">
    <img class="w-1/5 absolute bottom-0 right-0" src="/assets/images/headerLines.png" alt="headerLines.png">
</footer>

</body>
</html>
