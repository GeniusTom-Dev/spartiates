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

<div class="content flex items-center justify-center">
    %content%
</div>

<div class="bg-image bg-footer"></div>

</body>
</html>
